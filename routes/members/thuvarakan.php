<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;








Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create')->middleware('permission:can-add-customer');
Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index')->middleware('permission:can-view-customer');
Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show')->middleware('permission:can-view-customer');
Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store')->middleware('permission:can-add-customer');
Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit')->middleware('permission:can-edit-customer');
Route::put('/customers/{customer}/edit', [CustomerController::class, 'update'])->name('customers.update')->middleware('permission:can-edit-customer');
Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy')->middleware('permission:can-delete-customer');

Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create')->middleware('permission:can-add-supplier');
Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index')->middleware('permission:can-view-supplier');
Route::get('/suppliers/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show')->middleware('permission:can-view-supplier');
Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store')->middleware('permission:can-add-supplier');
Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit')->middleware('permission:can-edit-supplier');
Route::put('/suppliers/{supplier}/edit', [SupplierController::class, 'update'])->name('suppliers.update')->middleware('permission:can-edit-supplier');
Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy')->middleware('permission:can-delete-supplier');

Route::get('/stocks/create', [StockController::class, 'create'])->name('stocks.create')->middleware('permission:can-add-supplier');
Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index')->middleware('permission:can-view-supplier');
Route::get('/stocks/{stock}', [StockController::class, 'show'])->name('stocks.show')->middleware('permission:can-view-supplier');
Route::post('/stocks', [StockController::class, 'store'])->name('stocks.store')->middleware('permission:can-add-supplier');
Route::get('/stocks/{stock}/edit', [StockController::class, 'edit'])->name('stocks.edit')->middleware('permission:can-edit-supplier');
Route::put('/stocks/{stock}/edit', [StockController::class, 'update'])->name('stocks.update')->middleware('permission:can-edit-supplier');
Route::delete('/stocks/{stock}', [StockController::class, 'destroy'])->name('stocks.destroy')->middleware('permission:can-delete-supplier');



Route::get('/products/create', [ProductController::class, 'create'])->name('products.create')->middleware('permission:can-add-product');
Route::get('/products', [ProductController::class, 'index'])->name('products.index')->middleware('permission:can-view-product');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show')->middleware('permission:can-view-product');
Route::post('/products', [ProductController::class, 'store'])->name('products.store')->middleware('permission:can-add-product');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('permission:can-edit-product');
Route::put('/products/{product}/edit', [ProductController::class, 'update'])->name('products.update')->middleware('permission:can-edit-product');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('permission:can-delete-product');
Route::get('/add_products', [ProductController::class, 'productCreate'])->name('products.productCreate')->middleware('permission:can-view-product');
Route::post('/add_products', [ProductController::class, 'productStore'])->name('products.productStore')->middleware('permission:can-add-product');


Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create')->middleware('permission:can-add-sales');
Route::get('/sales', [SaleController::class, 'index'])->name('sales.index')->middleware('permission:can-view-sales');
Route::get('/sales/{room_reservation}', [SaleController::class, 'show'])->name('sales.show')->middleware('permission:can-view-sales');
Route::post('/sales', [SaleController::class, 'store'])->name('sales.store')->middleware('permission:can-add-sales');
Route::get('/sales/{room_reservation}/edit', [SaleController::class, 'edit'])->name('sales.edit')->middleware('permission:can-edit-sales');
Route::put('/sales/{room_reservation}/edit', [SaleController::class, 'update'])->name('sales.update')->middleware('permission:can-edit-sales');
Route::delete('/sales/{room_reservation}', [SaleController::class, 'destroy'])->name('sales.destroy')->middleware('permission:can-delete-sales');

Route::post('/sales-payment', [SaleController::class, 'calculatePayment'])->name('sales.payment');

Route::get('/customers-search', [CustomerController::class, 'customerSearch'])->name('customers.search');
Route::get('/products-search', [ProductController::class, 'productSearch'])->name('products.search');