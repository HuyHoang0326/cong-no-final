<?php

use App\Http\Controllers\CarBrandController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceItemController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ParstController;
use App\Http\Controllers\ParstsCategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::get('/',[DashboardController::class, 'index'])->name('dashboard');
Route::get('/job',[JobController::class, 'index'])->name('jobs.index');
// ----------------search---------------------
Route::get('/cars/search-serial', [CarController::class, 'searchSerial']);
Route::get('/parsts/search-serial', [ParstController::class, 'searchSerial']);
Route::get('/customers/search', [CustomerController::class, 'searchName']);
//----------------parst condition ----------------------
Route::get('parsts/new', [ParstController::class, 'getConditionNew'])->name('parsts.new');
Route::get('parsts/old', [ParstController::class, 'getConditionOld'])->name('parsts.old');
//------------------debt--------------------------------
Route::get('debts/overdueDebtList',[DebtController::class, 'overdueDebtList'])->name('debts.overdueDebtList');
Route::get('debts/debtIsPaidList',[DebtController::class, 'debtIsPaidList'])->name('debts.isPaidList');
// -----------------invoice--------------------------------
Route::get('invoices/customerIsPaid/{id}',[InvoiceController::class, 'invoiceCustomerIsPaid'])->name('invoices.customerIsPaid');
Route::get('invoices/customerIsDebt/{id}',[InvoiceController::class, 'invoiceCustomerIsDebt'])->name('invoices.customerIsDebt');
Route::get('invoices/pending',[InvoiceController::class, 'listStatus0'])->name('invoices.listStatus0');
Route::get('invoices/success',[InvoiceController::class, 'listStatus1'])->name('invoices.listStatus1');
Route::get('invoices/danger',[InvoiceController::class, 'listStatus2'])->name('invoices.listStatus2');
// -----------------customer--------------------------------
Route::get('customers/debt',[CustomerController::class, 'customerDebt'])->name('customers.debt');
// -----------carbrand--------------------
Route::get('car-brand/create',[CarBrandController::class, 'create'])->name('carBrands.create');
Route::post('car-brand/store',[CarBrandController::class, 'store'])->name('carBrands.store');
// -----------supplier--------------------
Route::get('supplier/create',[SupplierController::class, 'create'])->name('suppliers.create');
Route::post('supplier/store',[SupplierController::class, 'store'])->name('suppliers.store');
// -----------warehouse--------------------
Route::get('warehouse/create',[WarehouseController::class, 'create'])->name('warehouses.create');
Route::post('warehouse/store',[WarehouseController::class, 'store'])->name('warehouses.store');
// -----------resource--------------------
Route::resource('cars', CarController::class);
Route::resource('customers', CustomerController::class);
Route::resource('parsts', ParstController::class);
Route::resource('parstsCategory', ParstsCategoryController::class);
Route::resource('debts', DebtController::class);
Route::resource('invoices', InvoiceController::class);
Route::resource('invoiceItem', InvoiceItemController::class);


