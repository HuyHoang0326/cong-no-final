<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function create()
    {
        return view('warehouse.create');
    }

     public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Warehouse::create([
            'name' => $request->name
        ]);

        return redirect()->route('cars.create')
            ->with('success', 'Tạo hãng xe thành công');
    }
}
