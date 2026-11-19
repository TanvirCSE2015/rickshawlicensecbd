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
        Schema::create('application_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_info_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->date('fee_date')->nullable();
            $table->enum('status', ['pending', 'paid', 'refunded'])->default('pending');
            $table->string('gateway_transaction_id')->nullable(); // for payment gateway data
            $table->string('gateway_response')->nullable(); // JSON of gateway response
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
        Schema::dropIfExists('application_fees');
    }
};
