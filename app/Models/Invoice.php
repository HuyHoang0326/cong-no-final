<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoices';
    protected $casts = [
        'document_delivered' => 'array',
    ];
    protected $fillable = [
    'code',
    'customer_id',
    'customer_name',
    'customer_phone',
    'customer_address',
    'receiver_name',
    'sale_date',
    'invoicer',
    'delivery_date',
    'shipping_cost',
    'document_delivered',
    'sale_price_invoices',
    'price',
    'is_paid',
    'status',
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    public function debt()
    {
        return $this->hasOne(Debt::class, 'invoices_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
