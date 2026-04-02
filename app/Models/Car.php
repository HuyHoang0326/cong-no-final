<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    
    protected $table = 'cars';
    protected $casts = [
    'document_in_stock' => 'array',
];
    protected $fillable = [
        'id',
        'code',
        'name',
        'brand_id',
        'engine_number',
        'chassis_number',
        'payload',
        'supplier_id',
        'buy_price',
        'buy_shipping_cost',
        'buy_date',
        'stock_in_date',
        'warehouse_id',
        'document_in_stock',
        'sale_status',
        'sale_date',
        'sale_price',
        'sale_price_invoices',
    ];

    public function invoiceItem()
    {
        return $this->morphMany(InvoiceItem::class, 'product');
    }

    public function carBrand(){
        return $this->belongsTo(CarBrand::class,'brand_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
