<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use RuntimeException;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Crypt\RSA;

class JanataPayService
{
    /*
    |--------------------------------------------------------------------------
    | 1. Start a payment
    |--------------------------------------------------------------------------
    */

    public function startPayment(
        int $applicantId,
        string $paymentType,
        int $amount,
        ?int $createdBy = null
    ): string {
        $allowedTypes = [
            'application_fee',
            'yearly_fee',
            'security_fee',
        ];

        if (!in_array($paymentType, $allowedTypes, true)) {
            throw new RuntimeException('Invalid payment type.');
        }

        if ($amount <= 0) {
            throw new RuntimeException('Payment amount must be greater than zero.');
        }

        if (!DB::table('applicants')->where('id', $applicantId)->exists()) {
            throw new RuntimeException('Applicant does not exist.');
        }

        // Generate a unique reference for this payment attempt.
        $referenceId = 'REF-' . strtoupper(Str::random(20));

        $attemptId = DB::table('gateway_payment_attempts')->insertGetId([
            'applicant_id' => $applicantId,
            'reference_id' => $referenceId,
            'payment_type' => $paymentType,
            'amount' => $amount,
            'currency' => config('janatapay.currency'),
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Reuse existing gateway credentials until they expire.
        $credentials = $this->getCredentials();

        $aesKey = $credentials['aes_key'];
        $accessToken = $credentials['access_token'];

        $payload = [
            'merchantUid' => config('janatapay.merchant_uid'),
            'amount' => $amount,
            'currency' => config('janatapay.currency'),
            'description' => ucfirst(str_replace('_', ' ', $paymentType)),
            'referenceId' => $referenceId,
            'accessToken' => $accessToken,
        ];

        $response = $this->postEncrypted(
            '/jbagg/api/transaction/tokenize',
            $payload,
            $aesKey
        );

        $paymentUrl = $response['url'] ?? null;
        $transactionToken = $response['transactionToken'] ?? null;

        if (!$paymentUrl || !$transactionToken) {
            throw new RuntimeException(
                'JanataPay did not return a payment URL or transaction token.'
            );
        }

        // Store the credentials required for later verification.
        DB::table('gateway_payment_attempts')
            ->where('id', $attemptId)
            ->update([
                'transaction_token' => $transactionToken,
                'payment_url' => $paymentUrl,
                'aes_key_encrypted' => Crypt::encryptString(
                    $aesKey
                ),
                'access_token_encrypted' => Crypt::encryptString(
                    $accessToken
                ),
                'updated_at' => now(),
            ]);

        return $paymentUrl;
    }


    /*
    |--------------------------------------------------------------------------
    | 2. Authenticate with JanataPay
    |--------------------------------------------------------------------------
    */

    
    private function getCredentials(): array
    {
        $cached = Cache::get('janatapay_credentials');

        if ($cached) {
            return Crypt::decrypt($cached);
        }

        // Generate a random 256-bit AES key and encode it as Base64.
        $aesKey = base64_encode(random_bytes(32));

        // Authentication payload: AES key is NOT included here.
        $payload = [
            'merchantUid'      => config('janatapay.merchant_uid'),
            'merchantUsername' => config('janatapay.merchant_username'),
            'merchantPassword' => config('janatapay.merchant_password'),
        ];

        // GatewayCrypto encrypts using the decoded 32-byte AES key.
        $encryptedData = $this->aesEncrypt(
            json_encode($payload, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES),
            base64_decode($aesKey, true)
        );

        // RSA encrypt the Base64 AES key.
        $encryptedAesKey = $this->rsaEncrypt($aesKey);

        $response = Http::timeout(config('janatapay.timeout'))
            ->acceptJson()
            ->asJson()
            ->post(
                rtrim(config('janatapay.base_url'), '/') . '/jbagg/api/auth',
                [
                    'merchant' => base64_encode(
                        config('janatapay.merchant_uid')
                    ),
                    'key'  => $encryptedAesKey,
                    'data' => $encryptedData,
                ]
            )
            ->throw()
            ->json();

        if (empty($response['data'])) {
            throw new RuntimeException(
                'JanataPay authentication response does not contain encrypted data.'
            );
        }

        $decrypted = json_decode(
            $this->aesDecrypt(
                $response['data'],
                base64_decode($aesKey, true)
            ),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $accessToken = $decrypted['accessToken'] ?? null;

        if (!$accessToken) {
            throw new RuntimeException(
                'JanataPay authentication failed: access token missing.'
            );
        }

        $expiresIn = max(120, (int) ($decrypted['expiresIn'] ?? 3600));

        $credentials = [
            'aes_key' => $aesKey,
            'access_token' => $accessToken,
        ];

        Cache::put(
            'janatapay_credentials',
            Crypt::encrypt($credentials),
            now()->addSeconds(max(60, $expiresIn - 60))
        );

        return $credentials;
    }



    /*
    |--------------------------------------------------------------------------
    | 3. Send encrypted API request
    |--------------------------------------------------------------------------
    */

    
    private function postEncrypted(
        string $endpoint,
        array $payload,
        string $aesKey
    ): array {
        $aesKey = base64_decode($aesKeyBase64, true);
        $encryptedData = $this->aesEncrypt(
            json_encode($payload, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES),
            $aesKey
        );

        $accessToken = $payload['accessToken'] ?? null;

        $requestBody = [
            'data' => $encryptedData,
        ];

        if ($accessToken !== null) {
            $requestBody['accessToken'] = $accessToken;
        }

        $response = Http::timeout(config('janatapay.timeout'))
            ->acceptJson()
            ->asJson()
            ->post(
                rtrim(config('janatapay.base_url'), '/') . $endpoint,
                $requestBody
            )
            ->throw()
            ->json();

        if (empty($response['data'])) {
            throw new RuntimeException(
                "JanataPay returned an invalid response from {$endpoint}."
            );
        }

        $decrypted = $this->aesDecrypt(
            $response['data'],
            $aesKey
        );

        return json_decode(
            $decrypted,
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }



    /*
    |--------------------------------------------------------------------------
    | 4. AES-256-GCM encryption
    |--------------------------------------------------------------------------
    */

    private function aesEncrypt(string $plainText, string $key): string
    {
        $iv = random_bytes(12);
        $tag = '';

        $cipherText = openssl_encrypt(
            $plainText,
            'aes-256-gcm',
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag,
            '',
            16
        );

        if ($cipherText === false) {
            throw new RuntimeException('AES encryption failed.');
        }

        // Format: IV (12 bytes) + ciphertext + authentication tag (16 bytes).
        return base64_encode($iv . $cipherText . $tag);
    }


    /*
    |--------------------------------------------------------------------------
    | 5. AES-256-GCM decryption
    |--------------------------------------------------------------------------
    */

    private function aesDecrypt(string $encrypted, string $key): string
    {
        $raw = base64_decode($encrypted, true);

        if ($raw === false || strlen($raw) < 28) {
            throw new RuntimeException('Invalid encrypted response.');
        }

        $iv = substr($raw, 0, 12);
        $tag = substr($raw, -16);
        $cipherText = substr($raw, 12, -16);

        $plainText = openssl_decrypt(
            $cipherText,
            'aes-256-gcm',
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag,
            ''
        );

        if ($plainText === false) {
            throw new RuntimeException('AES response decryption failed.');
        }

        return $plainText;
    }


    /*
    |--------------------------------------------------------------------------
    | 6. RSA-OAEP SHA-256 encryption
    |--------------------------------------------------------------------------
    */

    private function rsaEncrypt(string $plainText): string
    {
        $rawPublicKey = trim(config('janatapay.public_key'));

        if (!$rawPublicKey) {
            throw new RuntimeException('JanataPay public key is missing.');
        }

        // The guide says the supplied key is raw Base64.
        // Wrap it directly; do not Base64-decode it first.
        $pem = "-----BEGIN PUBLIC KEY-----\n"
            . chunk_split($rawPublicKey, 64, "\n")
            . "-----END PUBLIC KEY-----";

        $publicKey = PublicKeyLoader::load($pem)
            ->withPadding(RSA::ENCRYPTION_OAEP)
            ->withHash('sha256')
            ->withMGFHash('sha256');

        return base64_encode($publicKey->encrypt($plainText));
    }


    /*
    |--------------------------------------------------------------------------
    | 7. Verify payment and save records
    |--------------------------------------------------------------------------
    */

    public function verifyAndSave(string $referenceId): array
    {
        $attempt = DB::table('gateway_payment_attempts')
            ->where('reference_id', $referenceId)
            ->first();

        if (!$attempt) {
            throw new RuntimeException('Payment reference was not found.');
        }

        // Idempotency: do not insert payment records twice.
        if ($attempt->status === 'success' && $attempt->payment_info_id) {
            return [
                'status' => 'success',
                'payment_info_id' => $attempt->payment_info_id,
            ];
        }

        if (!$attempt->transaction_token || !$attempt->aes_key_encrypted) {
            throw new RuntimeException('Payment attempt is missing verification data.');
        }

        $aesKey = Crypt::decryptString(
            $attempt->aes_key_encrypted
        );

        $keyBytes = base64_decode($aesKey, true);

        if ($keyBytes === false || strlen($keyBytes) !== 32) {
            throw new RuntimeException('Stored AES key is invalid.');
        }

        $accessToken = Crypt::decryptString(
            $attempt->access_token_encrypted
        );

        if ($aesKey === false || strlen($aesKey) !== 32) {
            throw new RuntimeException('Stored AES key is invalid.');
        }

        $payload = [
            'merchantUid' => config('janatapay.merchant_uid'),
            'referenceId' => $attempt->reference_id,
            'transactionToken' => $attempt->transaction_token,
            'accessToken' => $accessToken,
        ];

        $response = $this->postEncrypted(
            '/jbagg/api/transaction/verify',
            $payload,
            $aesKey
        );

        $data = $response['data'] ?? [];

        $gatewayStatusCode = (string) ($data['transactionStatusCode'] ?? '');
        $gatewayAmount = $data['amount'] ?? null;
        $ftNumber = $data['ftNumber'] ?? null;

        $isSuccessful = in_array(
            $gatewayStatusCode,
            config('janatapay.status_codes.success', []),
            true
        );

        // Check both status code and amount.
        $amountMatches = $gatewayAmount !== null
        && round((float) $gatewayAmount, 2)
            === round((float) $attempt->amount, 2);

        if (!$isSuccessful || !$amountMatches) {
            $status = in_array($gatewayStatusCode, ['005', '1005'], true)
                ? 'cancelled'
                : 'failed';

            DB::table('gateway_payment_attempts')
                ->where('id', $attempt->id)
                ->update([
                    'status' => $status,
                    'gateway_status_code' => $gatewayStatusCode,
                    'ft_number' => $ftNumber,
                    'gateway_response' => json_encode($response),
                    'verified_at' => now(),
                    'updated_at' => now(),
                ]);

            return [
                'status' => $status,
                'gateway_status_code' => $gatewayStatusCode,
                'amount_matches' => $amountMatches,
            ];
        }

        return DB::transaction(function () use (
            $attempt,
            $response,
            $gatewayStatusCode,
            $ftNumber
        ) {
            // Re-check inside transaction to protect against duplicate callbacks.
            $current = DB::table('gateway_payment_attempts')
                ->where('id', $attempt->id)
                ->lockForUpdate()
                ->first();

            if ($current->status === 'success' && $current->payment_info_id) {
                return [
                    'status' => 'success',
                    'payment_info_id' => $current->payment_info_id,
                ];
            }

            $now = now();

            // Create the common payment record.
            $paymentInfoId = DB::table('payment_infos')->insertGetId([
                'applicant_id' => $attempt->applicant_id,
                'invoice_no' => $attempt->reference_id,
                'total_paid' => $attempt->amount,
                'payment_date' => $now->toDateString(),
                'created_by' => null,
                'updated_by' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $common = [
                'payment_info_id' => $paymentInfoId,
                'amount' => $attempt->amount,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            // Insert the matching fee record.
            if ($attempt->payment_type === 'application_fee') {
                DB::table('application_fees')->insert(array_merge($common, [
                    'fee_date' => $now->toDateString(),
                    'status' => 'paid',
                    'gateway_transaction_id' => $ftNumber,
                    'gateway_response' => json_encode($response),
                    'created_by' => null,
                ]));
            }

            if ($attempt->payment_type === 'yearly_fee') {
                DB::table('yearly_fees')->insert(array_merge($common, [
                    'paid_amount' => $attempt->amount,
                    'fee_date' => $now->toDateString(),
                    'due_date' => null,
                    'status' => 'paid',
                    'gateway_transaction_id' => $ftNumber,
                    'created_by' => null,
                ]));
            }

            if ($attempt->payment_type === 'security_fee') {
                DB::table('security_fees')->insert(array_merge($common, [
                    'refundable_amount' => $attempt->amount,
                    'fee_date' => $now->toDateString(),
                    'status' => 'paid',
                    'gateway_transaction_id' => $ftNumber,
                    'created_by' => null,
                ]));
            }

            DB::table('gateway_payment_attempts')
                ->where('id', $attempt->id)
                ->update([
                    'status' => 'success',
                    'gateway_status_code' => $gatewayStatusCode,
                    'ft_number' => $ftNumber,
                    'payment_info_id' => $paymentInfoId,
                    'gateway_response' => json_encode($response),
                    'verified_at' => $now,
                    'updated_at' => $now,
                ]);

            return [
                'status' => 'success',
                'payment_info_id' => $paymentInfoId,
            ];
        });
    }
}
