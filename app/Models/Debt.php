<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;
    protected $table = 'debts';
    protected $fillable = [
    'id',
    'invoices_id',
    'customer_id',
    'debt_amount',
    'debt_date',
    'debt_due_date',
    'payment_date',
    'status',
];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoices_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
