
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gateway_payment_attempts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('applicant_id')
                ->constrained('applicants')
                ->cascadeOnDelete();

            $table->string('reference_id')->unique();

            $table->enum('payment_type', [
                'application_fee',
                'yearly_fee',
                'security_fee',
            ]);

            $table->unsignedBigInteger('amount');
            $table->string('currency', 3)->default('BDT');

            $table->text('transaction_token')->nullable();
            $table->text('payment_url')->nullable();

            // These values are encrypted using Laravel Crypt.
            $table->longText('aes_key_encrypted')->nullable();
            $table->longText('access_token_encrypted')->nullable();

            $table->enum('status', [
                'pending',
                'success',
                'failed',
                'cancelled',
            ])->default('pending');

            $table->string('gateway_status_code')->nullable();
            $table->string('ft_number')->nullable();

            $table->json('gateway_response')->nullable();

            $table->foreignId('payment_info_id')
                ->nullable()
                ->constrained('payment_infos')
                ->nullOnDelete();

            $table->timestamp('verified_at')->nullable();

            $table->timestamps();

            $table->index(['applicant_id', 'payment_type']);
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gateway_payment_attempts');
    }
};
