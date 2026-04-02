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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('brand_id')->nullable();
            $table->string('engine_number')->nullable();
            $table->string('chassis_number')->nullable();
            $table->string('payload')->nullable();
            $table->string('supplier_id')->nullable();
            $table->integer('buy_price')->nullable();
            $table->integer('buy_shipping_cost')->nullable();
            $table->date('buy_date')->nullable();
            $table->date('stock_in_date')->nullable();
            $table->string('warehouse_id')->nullable();
            $table->string('document_in_stock')->nullable();
            $table->integer('sale_status')->nullable();
            $table->date('sale_date')->nullable();
            $table->integer('sale_price')->nullable();
            $table->integer('sale_price_invoices')->nullable();
            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
