<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parst extends Model
{
    use HasFactory;
    protected $table = 'parsts';
    protected $fillable = [
    'id',
    'code',
    'name',
    'parst_category_id',
    'item_condition',
    'supplier_id',
    'quantity',
    'unit',
    'buy_price',
    'buy_shipping_cost',
    'buy_date',
    'stock_in_date',
    'warehouse_id',
    'sale_status',
    'sale_date',
    'sale_price',
    'sale_price_invoices',
];

    public function parstsCategory()
    {
        return $this->belongsTo(ParstsCategory::class, 'parst_category_id');
    }

     public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class, 'product_code', 'code');
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
