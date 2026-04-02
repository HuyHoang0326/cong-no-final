<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;
    protected $table = 'invoice_items';
    protected $fillable = [
        'invoice_id',
        'product_type',
        'product_code',
        'quantity',
        'unit_price',
        'sale_price',
        'sale_price_invoice',

        // ===== CAR =====
        'car_id',
        'car_name',
        'car_brand',
        'car_engine_number',
        'car_chassis_number',
        'car_payload',

        // ===== PARST =====
        'parst_id',
        'parst_name',
        'parst_category',
        'parst_condition',
        'parst_supplier',
        'parst_quantity_stock',
        'parst_unit',
        'parst_quantity_sold',
    ];
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function parst()
    {
        return $this->belongsTo(Parst::class, 'product_code', 'code');
    }

}
