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
        Schema::create('yearly_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_info_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2); // total yearly fee due
            $table->decimal('paid_amount', 10, 2)->default(0); // amount actually paid
            $table->date('fee_date')->nullable(); // when paid
            $table->date('due_date')->nullable(); // when it was due (from order_date)
            $table->enum('status', ['pending', 'paid', 'partial', 'refunded'])->default('pending');
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
        Schema::dropIfExists('yearly_fees');
    }
};
