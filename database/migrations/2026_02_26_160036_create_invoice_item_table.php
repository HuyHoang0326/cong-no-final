<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();

            // liên kết
            $table->unsignedBigInteger('invoice_id');

            // loại sản phẩm
            $table->enum('product_type', ['car', 'parst']);

            // chung
            $table->string('product_code')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 15, 2)->default(0); // giá nhập
            $table->decimal('sale_price', 15, 2)->default(0); // giá bán
            $table->decimal('sale_price_invoice', 15, 2)->default(0); // giá hóa đơn

            // ===== CAR =====
            $table->string('car_id')->nullable();
            $table->string('car_name')->nullable();
            $table->string('car_brand')->nullable();
            $table->string('car_engine_number')->nullable();
            $table->string('car_chassis_number')->nullable();
            $table->string('car_payload')->nullable();

            // ===== PARST =====
            $table->string('parst_id')->nullable();
            $table->string('parst_name')->nullable();
            $table->string('parst_category')->nullable();
            $table->string('parst_condition')->nullable();
            $table->string('parst_supplier')->nullable();
            $table->integer('parst_quantity_sold')->nullable();
            $table->string('parst_unit')->nullable();

            $table->timestamps();

            // FK
            $table->foreign('invoice_id')
                ->references('id')
                ->on('invoices')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};