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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->integer('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('receiver_name')->nullable();
            $table->date('sale_date')->nullable();
            $table->string('invoicer')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('document_delivered')->nullable();
            $table->integer('shipping_cost')->nullable();
            $table->integer('sale_price_invoices')->nullable();
            $table->integer('price')->nullable();
            $table->integer('is_paid')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
