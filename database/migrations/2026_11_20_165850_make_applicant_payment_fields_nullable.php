<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->string('bank_name')->nullable()->change();
            $table->string('pay_order_no')->nullable()->change();
            $table->decimal('amount', 10, 2)->nullable()->change();
            $table->date('order_date')->nullable()->change();
            $table->string('py_order_image')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->string('bank_name')->nullable(false)->change();
            $table->string('pay_order_no')->nullable(false)->change();
            $table->decimal('amount', 10, 2)->nullable(false)->change();
            $table->date('order_date')->nullable(false)->change();
            $table->string('py_order_image')->nullable(false)->change();
        });
    }
};