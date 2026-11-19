<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fee_refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_info_id')->constrained()->cascadeOnDelete();
            $table->enum('refund_type', ['yearly_fee', 'security_fee']);
            $table->decimal('amount', 10, 2);
            $table->date('refund_date');
            $table->string('gateway_refund_id')->nullable(); // gateway refund transaction ID
            $table->string('gateway_response')->nullable();
            $table->foreignId('refunded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            
            $table->index(['payment_info_id', 'refund_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_refunds');
    }
};
