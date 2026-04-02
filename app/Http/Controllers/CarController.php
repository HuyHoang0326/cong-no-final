<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarBrand;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Services\CarService;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $service;

    public function __construct(CarService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $cars = Car::latest()->get();
        $car = $cars->count();
        $parst = \App\Models\Parst::get()->count();
        return view('car.index', compact('cars', 'parst', 'car'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = CarBrand::all();
        $suppliers = Supplier::all();
        $warehouses = Warehouse::all();

        return view('car.create', compact('brands', 'suppliers', 'warehouses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
        ]);

        $this->service->create($request->all());

        return redirect()->route('cars.index')
            ->with('success', 'Tạo xe thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {

        $brands = CarBrand::all();
        $suppliers = Supplier::all();
        $warehouses = Warehouse::all();

        return view('car.detail', compact('car', 'brands', 'suppliers', 'warehouses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        $car = $this->service->find($id);

        $brands = CarBrand::all();
        $suppliers = Supplier::all();
        $warehouses = Warehouse::all();

        return view('car.edit', compact(
            'car',
            'brands',
            'suppliers',
            'warehouses'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->service->update($id, $request->all());

        return redirect()->route('cars.index')
            ->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->service->delete($id);

        return redirect()->route('cars.index')
        ->with('success', 'Đã xoá');
    }

    public function searchSerial(Request $request)
    {
        $keyword = $request->keyword;

        $cars = Car::with('carBrand:id,name')
            ->where('code', 'LIKE', $keyword . '%')
            ->limit(10)
            ->get([
                'id',
                'code',
                'name',
                'brand_id',
                'engine_number',
                'chassis_number',
                'payload',
                'sale_price'
            ])
            ->map(function ($car) {
                return [
                    'id' => $car->id,
                    'code' => $car->code,
                    'name' => $car->name,
                    'brand_name' => optional($car->carBrand)->name,
                    'engine_number' => $car->engine_number,
                    'chassis_number' => $car->chassis_number,
                    'payload' => $car->payload,
                    'sale_price' => $car->sale_price,
                ];
            });
        return response()->json($cars);
    }
}
