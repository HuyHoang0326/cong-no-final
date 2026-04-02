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
        Schema::create('debts', function (Blueprint $table) {
            $table->id()->nullable();
            $table->integer('invoices_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('debt_amount')->nullable();
            $table->date('debt_date')->nullable();
            $table->date('debt_due_date')->nullable();
            $table->date('payment_date')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debts');
    }
};
