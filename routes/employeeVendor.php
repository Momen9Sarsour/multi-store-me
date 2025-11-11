<?php
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Delivery;
use App\Models\Store;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\employeeVendor\DeliveryController;
use App\Http\Controllers\employeeVendor\StoreController;
use App\Http\Controllers\employeeVendor\CategoriesController;
use App\Http\Controllers\employeeVendor\OrderController;
use App\Http\Controllers\employeeVendor\ProductController;
use App\Http\Controllers\employeeVendor\SupportsController;


Route::prefix('employeeVendor')->group ( function() {

// ROUTE DASHBORD
Route::get('employeeVendor/dashboard', function () {
    return view('employeeVendor/dashboard');
})->name('employeeVendor/dashboard');

// ROUTE SUPPORT
Route::get('employeeVendor/support', function () {
    return view('employeeVendor.support.index');
})->name('employeeVendor/support');
});

// ROUTE SOTRES
Route::get('employeeVendor/stores',
[App\Http\Controllers\employeeVendor\StoreController::class, 'index'])
->name('employeeVendor/stores');

// ROUTE CATEGORY
Route::get('employeeVendor/category',
[App\Http\Controllers\employeeVendor\CategoryController::class, 'index'])
->name('employeeVendor/category');

// ROUTE ORDERS
Route::get('employeeVendor/order',
[App\Http\Controllers\employeeVendor\OrderController::class, 'index'])
->name('employeeVendor/order');

//ROUTE PRODUCT
Route::get('employeeVendor/product',
[App\Http\Controllers\employeeVendor\ProductController::class, 'index'])
->name('employeeVendor/product');

//ROUTE CREATE PRODUCT
Route::get('employeeVendor/product/create',
[App\Http\Controllers\employeeVendor\ProductController::class, 'create'])
->name('employeeVendor/product/create');

//ROUTE EDIT PRODUCT
Route::get('employeeVendor/product/edit/{id}',
 [App\Http\Controllers\employeeVendor\ProductController::class, 'edit']);
Route::post('employeeVendor/product/update/{id}',
 [App\Http\Controllers\employeeVendor\ProductController::class, 'update']);

 //ROUTE DELETE PRODUCT
Route::delete('employeeVendor/product/delete/{id}',
 [App\Http\Controllers\employeeVendor\ProductController::class, 'destroy']);


