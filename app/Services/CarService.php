<?php

namespace App\Services;

use App\Models\Car;

class CarService
{
    public function getAll()
    {
        return Car::with(['brand', 'supplier', 'warehouse'])->latest()->get();
    }

    public function create($data)
    {
        return Car::create([
            'code' => $data['code'] ?? '',
            'name' => $data['name'] ?? '',
            'brand_id' => $data['brand_id'] ?? null,
            'engine_number' => $data['engine_number'] ?? '',
            'chassis_number' => $data['chassis_number'] ?? '',
            'payload' => $data['payload'] ?? '',
            'supplier_id' => $data['supplier_id'] ?? null,
            'buy_price' => $data['buy_price'] ?? 0,
            'buy_shipping_cost' => $data['buy_shipping_cost'] ?? 0,
            'buy_date' => $data['buy_date'] ?? null,
            'stock_in_date' => $data['stock_in_date'] ?? null,
            'warehouse_id' => $data['warehouse_id'] ?? null,
            'document_in_stock' => $data['document_in_stock'] ?? '',
            'sale_status' => $data['sale_status'] ?? 0,
            'sale_date' => $data['sale_date'] ?? null,
            'sale_price' => $data['sale_price'] ?? 0,
            'sale_price_invoices' => $data['sale_price_invoices'] ?? 0,
        ]);
    }

    public function find($id)
    {
        return Car::findOrFail($id);
    }

    public function update($id, $data)
    {
        $car = $this->find($id);

        $car->update([
            'code' => $data['code'] ?? $car->code,
            'name' => $data['name'] ?? $car->name,
            'brand_id' => $data['brand_id'] ?? $car->brand_id,
            'engine_number' => $data['engine_number'] ?? $car->engine_number,
            'chassis_number' => $data['chassis_number'] ?? $car->chassis_number,
            'payload' => $data['payload'] ?? $car->payload,
            'supplier_id' => $data['supplier_id'] ?? $car->supplier_id,
            'buy_price' => $data['buy_price'] ?? $car->buy_price,
            'buy_shipping_cost' => $data['buy_shipping_cost'] ?? $car->buy_shipping_cost,
            'buy_date' => $data['buy_date'] ?? $car->buy_date,
            'stock_in_date' => $data['stock_in_date'] ?? $car->stock_in_date,
            'warehouse_id' => $data['warehouse_id'] ?? $car->warehouse_id,
            'document_in_stock' => $data['document_in_stock'] ?? $car->document_in_stock,
            'sale_status' => $data['sale_status'] ?? $car->sale_status,
            'sale_date' => $data['sale_date'] ?? $car->sale_date,
            'sale_price' => $data['sale_price'] ?? $car->sale_price,
            'sale_price_invoices' => $data['sale_price_invoices'] ?? $car->sale_price_invoices,
        ]);

        return $car;
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}
