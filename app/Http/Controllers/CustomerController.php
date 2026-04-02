<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Services\CustomerService;
use App\Services\InvoiceService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $service;
    protected $invoiceService;
    public function __construct(CustomerService $service, InvoiceService $invoiceService)
    {
        $this->service = $service;
        $this->invoiceService = $invoiceService;
    }
    public function index()
    {
        $customerDebt = $this->service->customerDebt();
        $customers = Customer::latest()->get();
        return view('customer.index', compact('customers', 'customerDebt'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        $data = $request->validated();
        $this->service->create($data);

        return redirect()->route('customers.index')
            ->with('success', 'Tạo xe thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $invoiceIsDebt = $this->invoiceService->invoiceCustomerIsDebt($customer->id)->count();
        $invoiceIsPaid = $this->invoiceService->invoiceCustomerIsPaid($customer->id)->count();
        $invoiceCustomerCancelled = $this->invoiceService->invoiceCustomerCancelled($customer->id)->count();
        return view('customer.detail', compact('customer', 'invoiceIsDebt', 'invoiceIsPaid', 'invoiceCustomerCancelled'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $customer = $this->service->find($id);
        $invoice = InvoiceController::class;

        return view('customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, $id)
    {
        
        $this->service->update($id, $request->validated());

        return redirect()->route('customers.index')
            ->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customers)
    {
        //
    }

    public function searchName(Request $request)
    {
        $keyword = $request->keyword;
        $customers = Customer::where('name', 'like', "%$keyword%")
            ->limit(10)
            ->get(['id', 'name', 'phone', 'address']);
        return response()->json($customers);
    }

    public function customerDebt()
    {
        $customers = $this->service->customerDebt();
        return view('customer.list_customer_debt', compact('customers'));
    }
}
