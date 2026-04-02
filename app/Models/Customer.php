<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $fillable = [
    'customer_code',
    'name',
    'phone',
    'address',
    'email',
    'is_potential',
    'paid_orders_count',
    'unpaid_orders_count',
    'total_purchased_amount',
    'outstanding_amount',
];
    public function invoice()
    {
        return $this->hasMany(Invoice::class, 'customer_id');
    }

    public function debt()
    {
        return $this->hasMany(Debt::class, 'customer_id');
    }
}
