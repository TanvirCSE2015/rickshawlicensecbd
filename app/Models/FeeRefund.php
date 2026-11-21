<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeeRefund extends Model
{
    protected $table = 'fee_refunds';

    protected $fillable = [
        'payment_info_id', 'refund_type', 'amount', 'refund_date',
        'gateway_refund_id', 'gateway_response', 'refunded_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'refund_date' => 'date',
        'gateway_response' => 'array',
    ];

    public function paymentInfo(): BelongsTo
    {
        return $this->belongsTo(PaymentInfo::class, 'payment_info_id');
    }

    public function refundedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'refunded_by');
    }
}