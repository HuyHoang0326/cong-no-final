<?php

namespace App\Services;

use App\Models\Invoice;

class InvoiceService
{
    public function create($data, $isPaid)
    {
        return Invoice::create([
            'code' => $data->code,
            'customer_id' => $data->customer_id ?? 0,
            'customer_name' => $data->customer_name,
            'customer_phone' => $data->customer_phone,
            'customer_address' => $data->customer_address,
            'receiver_name' => $data->receiver_name,
            'sale_date' => $data->sale_date,
            'invoicer' => $data->invoicer,
            'delivery_date' => $data->delivery_date,
            'shipping_cost' => $data->shipping_cost ?? 0,
            'document_delivered' => $data->document_delivered ?? [],
            'sale_price_invoices' => $data->sale_price_invoices ?? 0,
            'price' => $data->price ?? 0,
            'is_paid' => $isPaid,
            'status' => $data->status ?? 0,
        ]);
    }

    public function find($id)
    {
        return Invoice::findOrFail($id);
    }

    public function update($id, $data, $isPaid)
    {
        $invoice = $this->find($id);

        $invoice->update([
            'code' => $data->code ?? $invoice->code,
            'customer_id' => $data->customer_id ?? $invoice->customer_id,
            'customer_name' => $data->customer_name ?? $invoice->customer_name,
            'customer_phone' => $data->customer_phone ?? $invoice->customer_phone,
            'customer_address' => $data->customer_address ?? $invoice->customer_address,
            'receiver_name' => $data->receiver_name ?? $invoice->receiver_name,
            'sale_date' => $data->sale_date ?? $invoice->sale_date,
            'invoicer' => $data->invoicer ?? $invoice->invoicer,
            'delivery_date' => $data->delivery_date ?? $invoice->delivery_date,
            'shipping_cost' => $data->shipping_cost ?? $invoice->shipping_cost,
            'document_delivered' => $data->document_delivered ?? $invoice->document_delivered,
            'sale_price_invoices' => $data->sale_price_invoices ?? $invoice->sale_price_invoices,
            'price' => $data->price ?? $invoice->price,
            'is_paid' => $isPaid ?? $invoice->is_paid,
            'status' => $data->status ?? $invoice->status,
        ]);

        return $invoice;
    }

    public function invoiceCustomerIsPaid($id)
    {
        return Invoice::where('customer_id', $id)
        ->whereHas('debt', function ($q) {
            $q->where('status', 2);
        })
        ->get();
    }

    public function invoiceCustomerIsDebt($id)
    {
       return Invoice::where('customer_id', $id)
        ->whereHas('debt', function ($q) {
            $q->whereIn('status', [0, 1]);
        })
        ->get();
    }

    public function invoiceCustomerCancelled($id)
{
    return Invoice::where('customer_id', $id)
        ->whereHas('debt', function ($q) {
            $q->where('status', 3);
        })
        ->get();
}

    public function inoviceStatus(){
        $invoice['success'] =  Invoice::where('status', 1)->get();
        $invoice['danger'] = Invoice::where('status', 2)->get();
        $invoice['pending'] = Invoice::where('status', 0)->get();

        return $invoice;
    }
}
