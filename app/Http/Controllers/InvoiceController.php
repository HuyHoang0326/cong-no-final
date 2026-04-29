<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Services\InvoiceHandler;
use App\Services\InvoiceService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $handler;
    protected $service;
    public function __construct(
        InvoiceHandler $handler,
        InvoiceService $service)
    {
        $this->handler = $handler;
        $this->service = $service;
    }


    public function index()
    {
        $invoiceStatus = $this->service->inoviceStatus();
        $invoices = Invoice::latest()->get();
        return view('invoice.index', compact('invoices','invoiceStatus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nextCode = $this->getNextInvoiceCode();
         return view('invoice.create', compact('nextCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->handler->handleCreate($request);
        return redirect()->route('dashboard')
            ->with('success', 'Tạo hoá đơn thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return view('invoice.detail', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);

        return view('invoice.edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->handler->handleUpdate($id, $request);
        return redirect()->route('invoices.index')
            ->with('success', 'Sửa hoá đơn thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoices)
    {
        //
    }

    public function invoiceCustomerIsPaid($id)
    {
        $invoices = $this->service->invoiceCustomerIsPaid($id);
        return view('invoice.index', compact('invoices'));
    }

    public function invoiceCustomerIsDebt($id)
    {
        $invoices = $this->service->invoiceCustomerIsDebt($id);
        return view('invoice.index', compact('invoices'));
    }

    public function listStatus0()
    {
        $invoiceStatus = $this->service->inoviceStatus();
        $invoices = $invoiceStatus['pending'];
        return view('invoice.list_invoice_status_0', compact('invoices','invoiceStatus'));
    }

    public function listStatus1()
    {
        $invoiceStatus = $this->service->inoviceStatus();
        $invoices = $invoiceStatus['success'];
        return view('invoice.list_invoice_status_1', compact('invoices','invoiceStatus'));
    }

    public function listStatus2()
    {
        $invoiceStatus = $this->service->inoviceStatus();
        $invoices =  $invoiceStatus['danger'];
        return view('invoice.list_invoice_status_2', compact('invoices','invoiceStatus'));
    }

    private function getNextInvoiceCode()
{
    $today = now()->format('dmy');

    $lastInvoice = Invoice::whereDate('created_at', now())
        ->where('code', 'like', "HD{$today}%")
        ->orderBy('code', 'desc')
        ->first();

    if ($lastInvoice) {
        $lastNumber = (int) substr($lastInvoice->code, 8);
        $nextNumber = $lastNumber + 1;
    } else {
        $nextNumber = 0;
    }

    return 'HD' . $today . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
}
}
