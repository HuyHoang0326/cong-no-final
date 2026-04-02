<?php

namespace App\Services;

use App\Models\InvoiceItem;
use App\Models\Car;
use App\Models\Parst;
use Illuminate\Support\Facades\DB;

class InvoiceItemService
{
    public function createItems($invoiceId, $items)
    {
        if (empty($items)) return;

        foreach ($items as $item) {

            $type = $item['type'] ?? null;

            // ===================== CAR =====================
            if ($type === 'car') {

                InvoiceItem::create([
                    'invoice_id' => $invoiceId,
                    'product_type' => 'car',

                    // chung
                    'quantity' => 1,
                    'unit_price' => $item['car_invoice_price'] ?? 0,
                    'sale_price_invoice' => $item['car_invoice_price'] ?? 0,
                    'sale_price' => $item['car_price'] ?? 0,

                    // snapshot CAR
                    'product_code' => $item['car_serial'] ?? null,
                    'car_name' => $item['car_name'] ?? null,
                    'car_brand' => $item['brand'] ?? null,
                    'car_engine_number' => $item['engine_number'] ?? null,
                    'car_chassis_number' => $item['chassis_number'] ?? null,
                    'car_payload' => $item['payload'] ?? null,
                ]);
            }

            // ===================== PARST =====================
            if ($type === 'parst') {

                $quantity = $item['quantity_sold'] ?? 0;

                InvoiceItem::create([
                    'invoice_id' => $invoiceId,
                    'product_type' => 'parst',

                    // chung
                    'quantity' => $quantity,
                    'unit' => $item['unit'],
                    'unit_price' => $item['parst_invoice_price'] ?? 0,
                    'sale_price_invoice' => $item['parst_invoice_price'] ?? 0,
                    'sale_price' => $item['parst_price'] ?? 0,

                    // snapshot PARST
                    'product_code' => $item['parst_code'] ?? null,
                    'parst_name' => $item['parst_name'] ?? null,
                    'parst_category' => $item['category'] ?? null,
                    'parst_condition' => $item['condition'] ?? null,
                    'parst_supplier' => $item['supplier'] ?? null,
                    'parst_quantity_sold' => $quantity,
                ]);
            }
        }
    }

    public function updateItems($invoice, $items)
    {
        DB::transaction(function () use ($invoice, $items) {
            $invoiceId = $invoice->id;
            // ===== 1. LẤY ITEM CŨ =====
            $oldItems = InvoiceItem::where('invoice_id', $invoiceId)->get();

            // ===== 2. HOÀN KHO =====
            foreach ($oldItems as $old) {


                if ($old->product_type === 'car') {
                    // xe thì thường chỉ có 1 → set lại trạng thái
                    Car::where('code', $old->product_code)
                        ->update(['sale_status' => 0]); // 0 = trong kho
                }

                if ($old->product_type === 'parst') {
                    Parst::where('code', $old->product_code)
                        ->increment('quantity', $old->quantity);
                }
            }

            // ===== 3. XOÁ ITEM CŨ =====
            InvoiceItem::where('invoice_id', $invoiceId)->delete();

            if (empty($items)) return;

            // ===== 4. TẠO MỚI + TRỪ KHO =====
            foreach ($items as $item) {

                $type = $item['type'] ?? null;

                //================= CAR =================
                if ($type === 'car') {
                    $carStatus = $invoice->status == 1 ? 1 : 2;
                    Car::where('code', $item['car_serial'])
                        ->update(['sale_status' => $carStatus]);
                    InvoiceItem::create([
                        'invoice_id' => $invoiceId,
                        'product_type' => 'car',
                        'quantity' => 1,
                        'unit_price' => $item['car_invoice_price'] ?? 0,
                        'sale_price_invoice' => $item['car_invoice_price'] ?? 0,
                        'sale_price' => $item['car_price'] ?? 0,

                        'product_code' => $item['car_serial'] ?? null,
                        'car_name' => $item['car_name'] ?? null,
                        'car_brand' => $item['brand'] ?? null,
                        'car_engine_number' => $item['engine_number'] ?? null,
                        'car_chassis_number' => $item['chassis_number'] ?? null,
                        'car_payload' => $item['payload'] ?? null,
                    ]);
                }

                // ================= PARST =================
                if ($type === 'parst') {

                    $quantity = $item['quantity_sold'] ?? 0;
                    // kiểm tra còn đủ số lượng không
                    $parst = Parst::where('code', $item['parst_code'])->first();
                    if (!$parst || $parst->quantity < $quantity) {
                        throw new \Exception("Phụ tùng {$item['parst_code']} không đủ số lượng");
                    }
                    // tạo mới item 
                    InvoiceItem::create([
                        'invoice_id' => $invoiceId,
                        'product_type' => 'parst',

                        'quantity' => $quantity,
                        'parst_unit' => $item['unit'] ?? null,
                        'unit_price' => $item['parst_invoice_price'] ?? 0,
                        'sale_price_invoice' => $item['parst_invoice_price'] ?? 0,
                        'sale_price' => $item['parst_price'] ?? 0,

                        'product_code' => $item['parst_code'] ?? null,
                        'parst_name' => $item['parst_name'] ?? null,
                        'parst_category' => $item['category'] ?? null,
                        'parst_condition' => $item['condition'] ?? null,
                        'parst_supplier' => $item['supplier'] ?? null,
                        'parst_quantity_sold' => $quantity,
                    ]);

                    // trừ kho phụ tùng
                    Parst::where('code', $item['parst_code'])
                        ->decrement('quantity', $quantity);
                }
            }
        });
    }
    public function handleCancel($invoiceId)
    {
        $items = InvoiceItem::where('invoice_id', $invoiceId)->get();

        foreach ($items as $item) {
            if ($item->product_type === 'car') {
                Car::where('code', $item->product_code)
                    ->update(['sale_status' => 0]);
            }

            if ($item->product_type === 'parst') {
                Parst::where('code', $item->product_code)
                    ->increment('quantity', $item->quantity);
            }
        }
    }

    public function calculateTotal($invoiceId)
    {
        return InvoiceItem::where('invoice_id', $invoiceId)
            ->get()
            ->sum(function ($item) {
                return $item->quantity * $item->sale_price;
            });
    }
}
