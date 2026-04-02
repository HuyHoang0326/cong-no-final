<?php

namespace App\Services;

use App\Models\Parst;

class ParstService
{
    public function create($data)
    {
        return Parst::create([
            'code' => $data['code'] ?? '',
            'name' => $data['name'] ?? '',
            'parst_category_id' => $data['parst_category_id'] ?? null,
            'item_condition' => $data['item_condition'] ?? '',
            'supplier_id' => $data['supplier_id'] ?? null,
            'quantity' => $data['quantity'] ?? 0,
            'unit' => $data['unit'] ?? '',
            'buy_price' => $data['buy_price'] ?? 0,
            'buy_shipping_cost' => $data['buy_shipping_cost'] ?? 0,
            'buy_date' => $data['buy_date'] ?? null,
            'stock_in_date' => $data['stock_in_date'] ?? null,
            'warehouse_id' => $data['warehouse_id'] ?? null,
            'sale_status' => $data['sale_status'] ?? 0,
            'sale_date' => $data['sale_date'] ?? null,
            'sale_price' => $data['sale_price'] ?? 0,
            'sale_price_invoices' => $data['sale_price_invoices'] ?? 0,
        ]);
    }

    public function find($id)
    {
        return Parst::findOrFail($id);
    }

    public function update($id, $data)
    {
        $parst = $this->find($id);

        $parst->update([
            'code' => $data['code'] ?? $parst->code,
            'name' => $data['name'] ?? $parst->name,
            'parst_category_id' => $data['parst_category_id'] ?? $parst->parst_category_id,
            'item_condition' => $data['item_condition'] ?? $parst->item_condition,
            'supplier_id' => $data['supplier_id'] ?? $parst->supplier_id,
            'quantity' => $data['quantity'] ?? $parst->quantity,
            'unit' => $data['unit'] ?? $parst->unit,
            'buy_price' => $data['buy_price'] ?? $parst->buy_price,
            'buy_shipping_cost' => $data['buy_shipping_cost'] ?? $parst->buy_shipping_cost,
            'buy_date' => $data['buy_date'] ?? $parst->buy_date,
            'stock_in_date' => $data['stock_in_date'] ?? $parst->stock_in_date,
            'warehouse_id' => $data['warehouse_id'] ?? $parst->warehouse_id,
            'sale_status' => $data['sale_status'] ?? $parst->sale_status,
            'sale_date' => $data['sale_date'] ?? $parst->sale_date,
            'sale_price' => $data['sale_price'] ?? $parst->sale_price,
            'sale_price_invoices' => $data['sale_price_invoices'] ?? $parst->sale_price_invoices,
        ]);
        return $parst;
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }

    public function getConditionNew()
    {
        return Parst::where('item_condition', 0)->get();
    }

    public function getConditionOld()
    {
        return Parst::where('item_condition', 1)->get();
    }
}
