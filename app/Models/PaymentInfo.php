<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentInfo extends Model
{
    protected $table = 'payment_infos';

    protected $fillable = [
        'applicant_id', 'invoice_no', 'total_paid',
        'payment_date', 'created_by', 'updated_by',
    ];

    protected $casts = [
        'total_paid' => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }

    public function applicationFee(): HasOne
    {
        return $this->hasOne(ApplicationFee::class, 'payment_info_id');
    }

    public function yearlyFee(): HasOne
    {
        return $this->hasOne(YearlyFee::class, 'payment_info_id');
    }

    public function securityFee(): HasOne
    {
        return $this->hasOne(SecurityFee::class, 'payment_info_id');
    }

    public function refunds(): HasMany
    {
        return $this->hasMany(FeeRefund::class, 'payment_info_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /** Recalculate total_paid from all child payments minus refunds */
    public function recalculateTotalPaid(): void
    {
        $total = 0;

        if ($this->applicationFee && $this->applicationFee->status === 'paid') {
            $total += $this->applicationFee->amount;
        }

        if ($this->yearlyFee) {
            $total += $this->yearlyFee->paid_amount;
        }

        if ($this->securityFee && in_array($this->securityFee->status, ['paid', 'partial_refund'])) {
            $total += $this->securityFee->amount;
        }

        $total -= $this->refunds->sum('amount');

        $this->updateQuietly([
            'total_paid' => $total,
            'payment_date' => now(),
        ]);
    }

    /** Generate next invoice number: INV-2026-0001 */
    public static function generateNextInvoiceNo(): string
    {
        $year = now()->format('Y');
        $prefix = "INV-{$year}-";

        $last = self::where('invoice_no', 'like', $prefix . '%')
            ->orderByDesc('invoice_no')
            ->first();

        $number = $last ? ((int)substr($last->invoice_no, -4)) + 1 : 1;

        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    /** Get or create payment_info for an applicant */
    public static function getOrCreateForApplicant(int $applicantId): self
    {
        $applicant = Applicant::findOrFail($applicantId);

        return $applicant->paymentInfo ?? self::create([
            'applicant_id' => $applicantId,
            'invoice_no' => self::generateNextInvoiceNo(),
            'payment_date' => now(),
            'created_by' => auth()->id(),
        ]);
    }
}