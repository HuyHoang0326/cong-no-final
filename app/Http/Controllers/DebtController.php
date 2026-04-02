<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\Invoice;
use App\Services\DebtService;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $service;

    public function __construct(DebtService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $debts = Debt::where('status', '!=', 2)
            ->get();

        $debts_count = $debts->count();
        $debtsPrice = $debts->sum('debt_amount');

        $overdueDebts = Debt::whereDate('debt_due_date', '<', now())
            ->where('status', '!=', 2)
            ->get();

        $overdueDebtsCount = $overdueDebts->count();
        $totalOverdue = $overdueDebts->sum('debt_amount');

        $debtIsPaid = Debt::where('status', '=', 2)
            ->get();
        
        $debtIsPaidCount = $debtIsPaid->count();
        $totalDebtsIsPaid = $debtIsPaid->sum('debt_amount');
        return view('debt.index', compact('debts', 'debts_count', 'totalOverdue', 'debtsPrice', 'overdueDebtsCount', 'debtIsPaidCount', 'totalDebtsIsPaid'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Debt $debt)
    {
        return view('debt.detail', compact('debt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $debt = $this->service->find($id);
        $invoice = Invoice::all();
        return view('debt.edit', compact('debt', 'invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->service->update($id, $request->all());

        return redirect()->route('debts.index')
            ->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Debt $debts)
    {
        //
    }

    public function debtIsPaidList()
    {
        $debtAll =  Debt::where('status', '!=', 2)
            ->get();
        $debts_count = $debtAll->count();
        $debtsPrice = $debtAll->sum('debt_amount');

        $overdueDebts = Debt::whereDate('debt_due_date', '<', now())
            ->where('status', '!=', 2)
            ->get();
        $overdueDebtsCount =  $overdueDebts->count();
        $totalOverdue =  $overdueDebts->sum('debt_amount');

        $debts = $debtIsPaid = Debt::where('status', '=', 2)
            ->get();
        
        $debtIsPaidCount = $debtIsPaid->count();
        $totalDebtsIsPaid = $debtIsPaid->sum('debt_amount');
        return view('debt.list_is_paid_debt', compact('debts', 'debts_count', 'totalOverdue', 'debtsPrice', 'overdueDebtsCount', 'debtIsPaidCount', 'totalDebtsIsPaid'));
    }

    public function overdueDebtList(){
         $debtAll =  Debt::where('status', '!=', 2)
            ->get();
        $debts_count = $debtAll->count();
        $debtsPrice = $debtAll->sum('debt_amount');

        $debts =$overdueDebts = Debt::whereDate('debt_due_date', '<', now())
            ->where('status', '!=', 2)
            ->get();
        $overdueDebtsCount =  $overdueDebts->count();
        $totalOverdue =  $overdueDebts->sum('debt_amount');

        $debtIsPaid = Debt::where('status', '=', 2)
            ->get();
        
        $debtIsPaidCount = $debtIsPaid->count();
        $totalDebtsIsPaid = $debtIsPaid->sum('debt_amount');
        return view('debt.list_overdue_debts', compact('debts', 'debts_count', 'totalOverdue', 'debtsPrice', 'overdueDebtsCount', 'debtIsPaidCount', 'totalDebtsIsPaid'));
    }
}
