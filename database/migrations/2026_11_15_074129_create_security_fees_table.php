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
        Schema::create('security_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_info_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2); // security fee paid
            $table->decimal('refundable_amount', 10, 2)->default(0); // from settings
            $table->date('fee_date')->nullable();
            $table->enum('status', ['pending', 'paid', 'refunded', 'partial_refund'])->default('pending');
            $table->string('gateway_transaction_id')->nullable();
            $table->string('gateway_response')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            
            $table->index(['payment_info_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_fees');
    }
};
