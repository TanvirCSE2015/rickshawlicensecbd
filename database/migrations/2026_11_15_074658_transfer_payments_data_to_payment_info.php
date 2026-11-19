
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
// use RuntimeException;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Check that all required tables exist.
        $requiredTables = [
            'payments',
            'payment_infos',
            'application_fees',
            'yearly_fees',
            'security_fees',
            'fee_refunds',
            'applicants',
            'users',
        ];

        foreach ($requiredTables as $table) {
            if (!Schema::hasTable($table)) {
                throw new RuntimeException(
                    "Required table '{$table}' does not exist."
                );
            }
        }

        // 2. Prevent accidental duplicate migration.
        // If payment_info already contains data, inspect it before proceeding.
        if (DB::table('payment_infos')->exists()) {
            throw new RuntimeException(
                'payment_info already contains records. Migration stopped to prevent duplicate data.'
            );
        }

        // 3. Transfer everything inside one transaction.
        DB::transaction(function () {

            DB::table('payments')
                ->orderBy('id')
                ->chunkById(500, function ($payments) {

                    foreach ($payments as $payment) {

                        // Check that the applicant exists.
                        if (!DB::table('applicants')
                            ->where('id', $payment->applicant_id)
                            ->exists()) {
                            throw new RuntimeException(
                                "Applicant ID {$payment->applicant_id} does not exist. Payment ID: {$payment->id}"
                            );
                        }

                        // Create payment_info record.
                        $paymentInfoId = DB::table('payment_infos')->insertGetId([
                            'applicant_id' => $payment->applicant_id,
                            'invoice_no'   => $payment->invoice_no,
                            'total_paid'   => $payment->total_paid ?? 0,
                            'payment_date' => $payment->payment_date,
                            'created_by'   => $this->validUserId($payment->created_by),
                            'updated_by'   => $this->validUserId($payment->updated_by),
                            'created_at'   => $payment->created_at,
                            'updated_at'   => $payment->updated_at,
                        ]);

                        // -----------------------------------------
                        // APPLICATION FEE
                        // -----------------------------------------

                        $applicationAmount = (float) ($payment->fee ?? 0);

                        if ($applicationAmount > 0) {

                            $feePaid = strtolower(trim((string) $payment->fee_paid));

                            $status = in_array($feePaid, ['paid', 'yes'], true)
                                ? 'paid'
                                : 'pending';

                            DB::table('application_fees')->insert([
                                'payment_info_id' => $paymentInfoId,
                                'amount'          => $applicationAmount,
                                'fee_date'        => $payment->fee_date,
                                'status'          => $status,
                                'gateway_transaction_id' => null,
                                'gateway_response' => null,
                                'created_by'      => $this->validUserId($payment->created_by),
                                'created_at'      => $payment->created_at,
                                'updated_at'      => $payment->updated_at,
                            ]);
                        }

                        // -----------------------------------------
                        // YEARLY FEE
                        // -----------------------------------------

                        $yearlyAmount = (float) ($payment->yearly_fee ?? 0);
                        $yearlyPaid = (float) ($payment->yearly_fee_paid ?? 0);

                        if ($yearlyAmount > 0 || $yearlyPaid > 0) {

                            $status = 'pending';

                            if ($yearlyAmount > 0 && $yearlyPaid >= $yearlyAmount) {
                                $status = 'paid';
                            } elseif ($yearlyPaid > 0) {
                                $status = 'partial';
                            }

                            $isYearlyRefund = (bool) ($payment->is_yearly_fee_refund ?? false);

                            if ($isYearlyRefund) {
                                $status = 'refunded';
                            }

                            DB::table('yearly_fees')->insert([
                                'payment_info_id' => $paymentInfoId,
                                'amount'          => $yearlyAmount,
                                'paid_amount'     => $yearlyPaid,
                                'fee_date'        => $payment->yearly_fee_date,
                                'due_date'        => $payment->yearly_fee_date,
                                'status'          => $status,
                                'created_by'      => $this->validUserId($payment->yearly_fee_by),
                                'created_at'      => $payment->created_at,
                                'updated_at'      => $payment->updated_at,
                            ]);

                            // Yearly fee refund.
                            $yearlyRefund = (float) ($payment->yearly_fee_refund ?? 0);

                            if ($isYearlyRefund && $yearlyRefund > 0) {

                                DB::table('fee_refunds')->insert([
                                    'payment_info_id' => $paymentInfoId,
                                    'refund_type'     => 'yearly_fee',
                                    'amount'          => $yearlyRefund,
                                    'refund_date'     => $payment->yearly_fee_refund_date,
                                    'gateway_refund_id' => null,
                                    'refunded_by'     => $this->validUserId($payment->yearly_fee_refund_by),
                                    'created_at'      => $payment->created_at,
                                    'updated_at'      => $payment->updated_at,
                                ]);
                            }
                        }

                        // -----------------------------------------
                        // SECURITY FEE
                        // -----------------------------------------

                        $securityAmount = (float) ($payment->security_fee ?? 0);
                        $securityPayable = (float) ($payment->security_payable ?? 0);

                        if ($securityAmount > 0 || $securityPayable > 0) {

                            $status = 'pending';

                            if (strtolower(trim((string) $payment->security_paid)) === 'paid') {
                                $status = 'paid';
                            }

                            $isSecurityRefund = (bool) ($payment->is_security_refund ?? false);
                            $securityRefund = (float) ($payment->security_fee_refund ?? 0);

                            if ($isSecurityRefund) {
                                $status = (
                                    $securityRefund >= $securityAmount
                                    && $securityAmount > 0
                                ) ? 'refunded' : 'partial_refund';
                            }

                            DB::table('security_fees')->insert([
                                'payment_info_id' => $paymentInfoId,
                                'amount'          => $securityAmount,
                                'refundable_amount' => $payment->security_refundable ?? 0,
                                'fee_date'        => $payment->security_fee_date,
                                'status'          => $status,
                                'created_by'      => $this->validUserId($payment->security_fee_by),
                                'created_at'      => $payment->created_at,
                                'updated_at'      => $payment->updated_at,
                            ]);

                            // Security fee refund.
                            if ($isSecurityRefund && $securityRefund > 0) {

                                DB::table('fee_refunds')->insert([
                                    'payment_info_id' => $paymentInfoId,
                                    'refund_type'     => 'security_fee',
                                    'amount'          => $securityRefund,
                                    'refund_date'     => $payment->security_fee_refund_date,
                                    'gateway_refund_id' => null,
                                    'refunded_by'     => $this->validUserId($payment->security_fee_refund_by),
                                    'created_at'      => $payment->created_at,
                                    'updated_at'      => $payment->updated_at,
                                ]);
                            }
                        }
                    }
                });
        }, 3);
    }

    /**
     * Return a valid user ID or null.
     * Prevents foreign-key errors when an old user no longer exists.
     */
    private function validUserId($userId): ?int
    {
        if (!$userId) {
            return null;
        }

        return DB::table('users')
            ->where('id', $userId)
            ->exists()
                ? (int) $userId
                : null;
    }

    /**
     * This is a one-way data migration.
     * Do not automatically delete migrated payment records.
     */
    public function down(): void
    {
        throw new RuntimeException(
            'This data migration is irreversible. Restore from a database backup if reversal is required.'
        );
    }
};
