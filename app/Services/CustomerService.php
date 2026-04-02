<?php

namespace App\Services;

use App\Models\Customer;

class CustomerService
{
    public function create($data)
    {
        return Customer::create([
            'customer_code' => $data['customer_code'] ?? $data['code'] ?? '',
            'name' => $data['name'] ?? '',
            'phone' => $data['phone'] ?? '',
            'address' => $data['address'] ?? '',
            'email' => $data['email'] ?? '',
            'is_potential' => $data['is_potential'] ?? 0,
            'paid_orders_count' => $data['paid_orders_count'] ?? 0,
            'unpaid_orders_count' => $data['unpaid_orders_count'] ?? 0,
            'total_purchased_amount' => $data['total_purchased_amount'] ?? 0,
            'outstanding_amount' => $data['outstanding_amount'] ?? 0,
        ]);
    }
    public function find($id)
    {
        return Customer::findOrFail($id);
    }
    public function update($id, $data)
    {
        $customer = $this->find($id);

        $customer->update([
            'customer_code' => $data['customer_code'] ?? $customer->customer_code,
            'name' => $data['name'] ?? $customer->name,
            'phone' => $data['phone'] ?? $customer->phone,
            'address' => $data['address'] ?? $customer->address,
            'email' => $data['email'] ?? $customer->email,
            'is_potential' => $data['is_potential'] ?? $customer->is_potential,
            'paid_orders_count' => $data['paid_orders_count'] ?? $customer->paid_orders_count,
            'unpaid_orders_count' => $data['unpaid_orders_count'] ?? $customer->unpaid_orders_count,
            'total_purchased_amount' => $data['total_purchased_amount'] ?? $customer->total_purchased_amount,
            'outstanding_amount' => $data['outstanding_amount'] ?? $customer->outstanding_amount,
        ]);

        return $customer;
    }

    public function customerDebt()
    {
        return Customer::with(['debt' => function ($q) {
            $q->where('status', '!=', 2);
        }])->whereHas('debt', function ($q) {
            $q->where('status', '!=', 2);
        })->get();
    }
}
