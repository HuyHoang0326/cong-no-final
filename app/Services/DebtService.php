<?php

namespace App\Services;

use App\Models\Debt;

class DebtService
{
    public function createDebt($invoiceId, $data, $isPaid)
    {
        $total = (int) $data->price;
        $debt = $total - $isPaid;

        if ($debt <= 0) return;

        return Debt::create([
            'invoices_id' => $invoiceId,
            'customer_id' => $data->customer_id ?? 0,
            'debt_amount' => $debt,
            'debt_date' => now(),
            'debt_due_date' => $data->dubt_due_date,
            'status' => 0,
        ]);
    }

    public function find($id)
    {
        return Debt::findOrFail($id);
    }

    public function update($id, $data)
    {
        $debt = $this->find($id);
        $debt->update([
            "invoices_id" => $data["invoices_id"] ?? $debt->invoices_id,
            "customer_id" => $data["customer_id"] ?? $debt->customer_id,
            "debt_amount" => $data["debt_amount"] ?? $debt->debt_amount,
            "debt_date" => $data["debt_date"] ?? $debt->debt_date,
            "payment_date" => $data["payment_date"] <= 0 ? now() : $data["payment_date"],
            "debt_due_date" => $data["debt_due_date"] ?? $debt->debt_due_date,
            "status" => $data["status"]
        ]);

        return $debt;
    }

    public function updateDebt($invoice, $total, $paid)
    {
        $debt = Debt::firstOrNew([
            'invoices_id' => $invoice->id
        ]);

        $remaining = $total - $paid;

        $status = $debt->status;

        if ($remaining <= 0) {
            $status = 2; // đã thanh toán
        }

        $debt->update([
            'customer_id' => $invoice->customer_id,
            'debt_amount' => max($remaining, 0),
            'debt_date' => $invoice->sale_date,
            'status' => $status
        ]);

        return $debt;
    }

    public function cancelDebt($invoiceId)
    {
        Debt::where('invoices_id', $invoiceId)
            ->update(['status' => 3]);
    }
}
