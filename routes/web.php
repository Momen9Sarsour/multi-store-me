<?php

use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Dashboard\DeliveryController as DashboardDeliveryController;

use App\Http\Controllers\EmployeeAdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryDashboard\DeliveryArea;
use App\Http\Controllers\VendorAdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\HomesController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\Front\CategoriesController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\StorController;
use App\Http\Controllers\Front\CheckOutController;
use App\Http\Controllers\front\StoresController;
use App\Http\Controllers\Front\CategoryStoreController;




use App\Http\Controllers\employeeVendor\DeliveriesController;
// use App\Http\Controllers\employeeVendor\StoreController;
// use App\Http\Controllers\employeeVendor\CategoriesController;
use App\Http\Controllers\employeeVendor\OrderesController;
use App\Http\Controllers\employeeVendor\ProductesController;
use App\Http\Controllers\employeeVendor\SupportsController;
use App\Http\Controllers\Front\OrdersController;
use App\Http\Controllers\Front\PaymentsController;
use App\Http\Controllers\Front\ProductAllController;
use App\Http\Controllers\Front\ProductStoreController;
use App\Http\Controllers\SocailController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\StripeWebhookController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\DeliveryDashboard\DeliveryController;
use App\Http\Controllers\DeliveryDashboard\DeliveryMenController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



// Route::group([
//     'prefix' => LaravelLocalization::setLocale(),
//   ], function(){


Route::middleware(['auth', 'auth.type:deliveryAdmin'])->group(function () {
    Route::get('/deliveryDashboard', [DeliveryController::class, 'index'])->name('delivery');
    Route::resource('deliveryDashboard/deliveries',DeliveryMenController::class);
    Route::get('/deliveries/trash', [DeliveryMenController::class, 'trash'])
   ->name('deliveries.trash');
   Route::put('deliveries/{delivery}/restore', [DeliveryMenController::class, 'restore'])->name('deliveries.restore');
    Route::delete('deliveries/{delivery}/force-delete', [DeliveryMenController::class, 'forceDelete'])->name('deliveries.force-delete');
    Route::resource('deliveryDashboard/deliveriesArea',DeliveryArea::class);

});

Route::get('/', [HomesController::class, 'index'])->name('home');
Route::get('/category/{slug}', [HomesController::class, 'show'])->name('categ.show');
Route::get('/createStore', [HomesController::class, 'create'])->name('addStore');
Route::post('/Store/store', [HomesController::class, 'store'])->name('storeStore');

Route::get('/category/stores', [CategoryStoreController::class, 'index'])->name('category.stores.index');
Route::get('/category/stores/{slug}', [CategoryStoreController::class, 'show'])->name('categor.show');
Route::get('/all-products',[ProductAllController::class, 'index'])->name('all-products');
Route::get('/storeproductt/{store}', [ProductStoreController::class, 'index'])->name('storeproductt');
Route::get('/featured-products',[ProductAllController::class, 'showproduct'])->name('best-products');
Route::get('/products/{product:slug}', [ProductsController::class, 'show'])->name('prod.show');

Route::get('/productss', [ProductsController::class, 'index'])->name('products-show');


Route::get('/store/{store:slug}', [StoresController::class, 'showProducts'])
->name('store.products');
Route::get('/categorystore/{store:slug}', [StoresController::class, 'showCategories'])
->name('storeCategory');
Route::resource('cart', CartController::class);
Route::post('cart/empty', [CartController::class, 'emptyCart'])->name('cart.empty');
Route::get('checkout',[CheckOutController::class,'create'])
->name('checkout');
Route::post('checkout',[CheckOutController::class,'store']);

Route::get('orders/{order}/pay',[PaymentsController::class,'create'])
->name('orders.payments.create');

Route::post('orders/{order}/stripe/payment-intent/create',[PaymentsController::class,'createStripePaymentIntent'])
->name('stripe.paymentIntent.create');

Route::get('orders/{order}/pay/stripe/callback',[PaymentsController::class,'confirm'])->name('stripe.return');

Route::get('auth/{provider}/redirect',[SocialLoginController::class,'redirect'])
->name('auth.socilatie.redirect');
Route::get('auth/{provider}/callback', [SocialLoginController::class, 'callback'])
    ->name('auth.socialite.callback');
Route::any('stripe/webhook',[StripeWebhookController::class,'handle']);
Route::get('auth/{provider}/user',[SocialController::class,'index']);

Route::get('/orders/{order}',[OrdersController::class,'show'])
->name('orders.show');





//
Route::get('/Stor', [StorController::class, 'index']);
// });


Route::get('/dashboard', function () {
    return view('adminStore/dashboard');
})->middleware(['auth', 'verified'])->name('admin/dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//dashboard Admin Store

Route::middleware(['auth', 'auth.type:admin,employeeAdmin'])->group(function () {
    Route::resource('/adminStores', StoreController::class);
    Route::resource('/adminEmployee', EmployeeAdminController::class);
    Route::resource('/adminCategory', CategoryController::class);
    Route::resource('/adminProduct', ProductController::class);
    Route::resource('/adminReport', ReportController::class);
    Route::resource('/adminDelivery', DeliveryController::class);
    Route::get('/admin/support', function () {
        return view('adminStore.support.support');
    })->name('admin/support');
    Route::resource('/adminOrder', OrderController::class);
});

require __DIR__.'/employeeAdmin/employeeAdmin.php';
Route::get('/employeeAdmin/stores', [StoreController::class, 'empStoresList'])->name('employeeAdmin/stores');
Route::get('/employeeAdmin/stores/create', [StoreController::class , 'empCreateStore'])->name('employeeAdmin/stores/create');
Route::post('/employeeAdmin/stores/store', [StoreController::class, 'empStore']);
Route::get('/employeeAdmin/stores/edit/{id}', [StoreController::class, 'empEdit']);
Route::put('/employeeAdmin/stores/update/{id}', [StoreController::class, 'empUpdate']);
Route::delete('/employeeAdmin/stores/delete/{id}', [StoreController::class, 'empDelete']);




// ROUTE DASHBORD
Route::get('employeeVendor/dashboard', function () {
    return view('employeeVendor/dashboardemployee');
})->name('employeeVendor/dashboard');

// ROUTE SUPPORT
Route::get('employeeVendor/support', function () {
    return view('employeeVendor.support.index');
})->name('employeeVendor/support');


// ROUTE SOTRES
Route::get('employeeVendor/stores',[StoreController::class, 'index'])
->name('employeeVendor/stores');

// ROUTE CATEGORY
Route::get('employeeVendor/category',[CategoriesController::class, 'index'])
->name('employeeVendor/category');

// ROUTE ORDERS
Route::get('employeeVendor/order',[OrderesController::class, 'index'])
->name('employeeVendor/order');


//ROUTE DELIVERY
Route::get('employeeVendor/delivery',[DeliveriesController::class, 'index'])
->name('employeeVendor/delivery');

//ROUTE PRODUCT
Route::get('employeeVendor/product',[ProductesController::class, 'index'])
->name('employeeVendor/product');

//ROUTE CREATE PRODUCT
Route::get('employeeVendor/product/create',
[ProductesController::class, 'create'])
->name('employeeVendor/product/create');
Route::post('employeeVendor/product/store',
[ProductesController::class, 'store'])
->name('employeeVendor/product/store');




//ROUTE EDIT PRODUCT
Route::get('employeeVendor/product/edit/{id}', [ProductesController::class, 'edit'])->name('employeeVendor/product/edit');
Route::put('employeeVendor/product/update/{id}',[ProductesController::class, 'update'])->name('employeeVendor/product/update');

 //ROUTE DELETE PRODUCT
Route::delete('employeeVendor/product/delete/{id}', [ProductesController::class, 'destroy'])->name('employeeVendor/product/delete');


//ROUTE CREATE ORDER
Route::get('employeeVendor/order/create',
[OrderesController::class, 'create'])
->name('employeeVendor/order/create');
Route::post('employeeVendor/order/store',
[OrderesController::class, 'store'])
->name('employeeVendor/order/store');

//ROUTE EDIT ORDER
Route::get('employeeVendor/order/edit/{id}', [OrderesController::class, 'edit'])->name('employeeVendor/order/edit');
Route::put('employeeVendor/order/update/{id}',[OrderesController::class, 'update'])->name('employeeVendor/order/update');

 //ROUTE DELETE ORDER
Route::delete('employeeVendor/order/delete/{id}', [OrderesController::class, 'destroy'])->name('employeeVendor/order/delete');



//require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php';
// require __DIR__.'/api.php';

