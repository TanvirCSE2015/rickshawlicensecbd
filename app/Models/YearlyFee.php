<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class YearlyFee extends Model
{
    protected $table = 'yearly_fees';

    protected $fillable = [
        'payment_info_id', 'amount', 'paid_amount', 'fee_date',
        'due_date', 'status', 'gateway_transaction_id',
        'gateway_response', 'created_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'fee_date' => 'date',
        'due_date' => 'date',
        'gateway_response' => 'array',
    ];

    public function paymentInfo(): BelongsTo
    {
        return $this->belongsTo(PaymentInfo::class, 'payment_info_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}