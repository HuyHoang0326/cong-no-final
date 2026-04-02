<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class InvoiceHandler
{
    protected $invoiceService;
    protected $itemService;
    protected $debtService;

    public function __construct(
        InvoiceService $invoiceService,
        InvoiceItemService $itemService,
        DebtService $debtService
    ) {
        $this->invoiceService = $invoiceService;
        $this->itemService = $itemService;
        $this->debtService = $debtService;
    }

    public function handleCreate($request)
    {
        return DB::transaction(function () use ($request) {

            // ===== TÍNH TIỀN =====
            $paid = (int) $request->paid_amount;
            $deposit = (int) $request->deposit_amount;
            $isPaid = $paid + $deposit;

            // ===== 1. INVOICE =====
            $invoice = $this->invoiceService->create($request, $isPaid);
            // ===== 2. ITEMS =====
            $this->itemService->createItems($invoice->id, $request->items);

            // ===== 3. DEBT =====
            $this->debtService->createDebt($invoice->id, $request, $isPaid);

            return $invoice;
        });
    }

    public function handleUpdate($id, $request)
    {
        return DB::transaction(function () use ($id, $request) {

            // ===== TÍNH TIỀN =====
            $paid = (int) $request->paid_amount;
            $deposit = (int) $request->deposit_amount;
            $isPaid = $paid + $deposit;
            // 1. update invoice
            $invoice = $this->invoiceService->update($id, $request, $isPaid);

            // 2. nếu huỷ → xử lý riêng
            if ($invoice->status == 2) {
                $this->itemService->handleCancel($invoice->id);
                $this->debtService->cancelDebt($invoice->id);
                return $invoice;
            }

            // 3. update items
            $this->itemService->updateItems($invoice, $request->items);

            // 4. tính total thật từ DB
            $total = $this->itemService->calculateTotal($invoice->id);

            // 5. update debt
            $this->debtService->updateDebt($invoice, $total, $isPaid);

            return $invoice;
        });
    }
}
