<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
   public function create()
    {
        return view('supplier.create');
    }

     public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Supplier::create([
            'name' => $request->name
        ]);

        return redirect()->route('cars.create')
            ->with('success', 'Tạo hãng xe thành công');
    }
}
