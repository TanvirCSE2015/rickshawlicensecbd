<?php
namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Services\JanataPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class JanataPayController extends Controller
{
    public function callback(
        Request $request,
        JanataPayService $janataPay
    ) {
        $referenceId = $request->query('refid');

        if (!$referenceId) {
            return redirect('/payment-result?status=invalid');
        }

        try {
            // Never trust the callback alone.
            // Always verify directly with JanataPay.
            $result = $janataPay->verifyAndSave($referenceId);
            if (in_array($result['status'], ['failed', 'cancelled'], true)
                && $result['payment_type'] === 'application_fee') {

                $applicant = Applicant::find($result['applicant_id']);
                $this->discardApplicant($applicant);
            }
            return redirect()->route('payment.result', ['status' => $result['status'], 'refid' => $referenceId]);

        } catch (Throwable $e) {

            // Do not log tokens, AES keys, passwords or credentials.
            Log::error('JanataPay callback verification failed', [
                'reference_id' => $referenceId,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('payment.result', ['status' => 'pending', 'refid' => $referenceId]);
        }
    }
    public function result(Request $request)
    {
        $status = in_array($request->query('status'), ['success','failed','cancelled','pending'], true)
            ? $request->query('status') : 'invalid';

        return view('payment_result', [
            'status' => $status,
            'refid'  => $request->query('refid'),
        ]);
    }
    private function discardApplicant(Applicant $applicant): void
    {
        $fileFields = ['applicant_image', 'signature_image', 'nid_image', 'citizen_certificate_image', 'category_proof_image'];

        try {
            DB::transaction(function () use ($applicant, $fileFields) {
                // collect file paths before deleting the row
                $paths = collect($fileFields)->map(fn ($f) => $applicant->{$f})->filter()->all();

                // payment rows that startPayment() may have created before it failed
                if ($applicant->paymentInfo) {
                    $applicant->paymentInfo->applicationFee?->delete();
                    $applicant->paymentInfo->delete();
                }

                $applicant->delete();   // use forceDelete() if Applicant uses SoftDeletes

                // delete files only after the DB delete has succeeded
                DB::afterCommit(function () use ($paths) {
                    foreach ($paths as $path) {
                        Storage::disk('public')->delete($path);
                    }
                });
            });
        } catch (Throwable $e) {
            Log::error('Failed to discard applicant after payment failure', [
                'applicant_id' => $applicant->id,
                'error'        => $e->getMessage(),
            ]);
        }
    }
}
