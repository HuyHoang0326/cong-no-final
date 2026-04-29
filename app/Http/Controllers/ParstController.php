<?php

namespace App\Http\Controllers;

use App\Models\Parst;
use App\Models\ParstsCategory;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Services\ParstService;

class ParstController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $service;

    public function __construct(ParstService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $parsts = Parst::latest()->get();
        $new = $this->service->getConditionNew()->count();
        $old = $this->service->getConditionOld()->count();
        $car = \App\Models\Car::get()->count();

        return view('parst.index', compact('parsts', 'new', 'old', 'car'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ParstsCategory::all();
        $suppliers = Supplier::all();
        $warehouses = Warehouse::all();

        return view('parst.create', compact(
            'categories',
            'suppliers',
            'warehouses'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
            'parst_category_id' => 'required|exists:parsts_category,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'quantity' => 'nullable|numeric',
            'buy_price' => 'nullable|numeric',
            'buy_shipping_cost' => 'nullable|numeric',
            'sale_price' => 'nullable|numeric',
            'sale_price_invoices' => 'nullable|numeric',
        ]);

        $this->service->create($request->all());

        return redirect()
            ->route('parsts.index')
            ->with('success', 'Tạo phụ tùng thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Parst $parst)
    {
        return view('parst.detail', compact('parst'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $parst = $this->service->find($id);

        $suppliers = Supplier::all();
        $categories = ParstsCategory::all();
        $warehouses = Warehouse::all();

        return view('parst.edit', compact('parst', 'suppliers', 'categories', 'warehouses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->service->update($id, $request->all());

        return redirect()->route('parsts.index')
            ->with('success', 'Cập nhật phụ tùng thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->service->delete($id);

        return redirect()->route('parsts.index')
            ->with('success', 'Đã xoá');
    }

    public function searchSerial(Request $request)
    {
        $keyword = $request->keyword;

        $parsts = Parst::with('parstsCategory:id,name')
            ->where('code', 'LIKE', $keyword . '%')
            ->limit(10)
            ->get([
                'id',
                'code',
                'name',
                'parst_category_id',
                'item_condition',
                'supplier_id',
                'quantity',
                'unit',
                'sale_price'
            ])
            ->map(function ($parst) {
                return [
                    'id' => $parst->id,
                    'code' => $parst->code,
                    'name' => $parst->name,
                    'category_name' => $parst->parstsCategory?->name,
                    'condition' => $parst->item_condition,
                    'supplier' => $parst->supplier_id,
                    'quantity' => $parst->quantity,
                    'unit' => $parst->unit,
                    'sale_price' => $parst->sale_price,
                ];
            });
        return response()->json($parsts);
    }

    public function searchName(Request $request)
{
    $keyword = $request->keyword;

    $parsts = Parst::with('parstsCategory:id,name')
        ->where('name', 'LIKE', '%' . $keyword . '%') // 🔥 search name
        ->limit(10)
        ->get([
            'id',
            'code',
            'name',
            'parst_category_id',
            'item_condition',
            'supplier_id',
            'quantity',
            'unit',
            'sale_price'
        ])
        ->map(function ($parst) {
            return [
                'id' => $parst->id,
                'code' => $parst->code,
                'name' => $parst->name,
                'category_name' => $parst->parstsCategory?->name,
                'condition' => $parst->item_condition,
                'supplier' => $parst->supplier_id,
                'quantity' => $parst->quantity,
                'unit' => $parst->unit,
                'sale_price' => $parst->sale_price,
            ];
        });

    return response()->json($parsts);
}
    public function getConditionNew()
    {
        $parsts =  $this->service->getConditionNew();
        $new = $this->service->getConditionNew()->count();
        $old = $this->service->getConditionOld()->count();
        $car = \App\Models\Car::get()->count();
        return view('parst.list_parsts_new', compact('parsts','new','old', 'car'));
    }

    public function getConditionOld()
    {
        $parsts =  $this->service->getConditionOld();
        $new = $this->service->getConditionNew()->count();
        $old = $this->service->getConditionOld()->count();
        $car = \App\Models\Car::get()->count();
        return view('parst.list_parsts_old', compact('parsts','new','old', 'car'));
    }
}
