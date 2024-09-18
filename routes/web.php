<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SkuController;
use App\Http\Controllers\Admin\StockController;
use App\Admin\Controllers\OrderController;
use App\Admin\Controllers\NewOrderController;
use App\Admin\Controllers\UploadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mobile\MobileOrderController;
use App\Http\Controllers\Mobile\MobileSkuController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/admin');
});
Route::group(['namespace' => 'Admin', 'prefix' => 'mobile'], function () {
    Route::get('/order', [MobileOrderController::class,'index'])->name('mobile.order');
    Route::get('/sku', [MobileSkuController::class,'index'])->name('mobile.sku');
});


Route::group(['namespace' => 'Admin', 'prefix' => 'admin','middleware' => 'admin.permission'], function () {

    \App\Admin\Controllers\StoreController::routes('/stores', '\App\Admin\Controllers\StoreController');
    \App\Admin\Controllers\ProductController::routes('/products', '\App\Admin\Controllers\ProductController');
    Route::post('/products/batch-copy', [\App\Admin\Controllers\ProductController::class,'batchCopy'])->name('admin.products.batch-copy');

    \App\Admin\Controllers\StoreSkuController::routes('/store-skus', '\App\Admin\Controllers\StoreSkuController');
    Route::post('/store-skus/print-label', [\App\Admin\Controllers\StoreSkuController::class,'printLabel'])->name('admin.store-skus.print-label');
    Route::post('/store-skus/batch-add-product', [\App\Admin\Controllers\StoreSkuController::class,'batchAddProduct'])->name('admin.store-skus.batch-add-product');

    \App\Admin\Controllers\AsnController::routes('/asns', '\App\Http\Controllers\Admin\Controllers\AsnController');
    \App\Admin\Controllers\LocationShelfController::routes('/shelf', '\App\Http\Controllers\Admin\LocationShelfController');
    \App\Admin\Controllers\LocationController::routes('/locations', '\App\Http\Controllers\Admin\LocationController');
    CategoryController::routes('/categories', '\App\Http\Controllers\Admin\CategoryController');

    SkuController::routes('/skus', '\App\Http\Controllers\Admin\SkuController');
    Route::post('/skus/print-label', [SkuController::class,'printLabel'])->name('admin.skus.print-label');

    StockController::routes('/stocks', '\App\Http\Controllers\Admin\StockController');
    Route::post('/stocks/batch', [StockController::class,'batch'])->name('admin.stocks.batch');

    Route::get('/new-orders/batch', [NewOrderController::class,'batch'])->name('admin.new-orders.batch');
    Route::post('/new-orders/upload', [NewOrderController::class,'upload'])->name('admin.new-orders.upload');
    Route::post('/new-orders/print-label', [NewOrderController::class,'printLabel'])->name('admin.new-orders.print-label');
    Route::put('/new-orders/upload-design-image/{id}', [NewOrderController::class,'uploadDesignImage'])->name('admin.new-orders.upload-design-image');
    Route::put('/new-orders/update-design-image/{id}', [NewOrderController::class,'updateDesignImage'])->name('admin.new-orders.update-design-image');
    Route::get('/new-orders/export', [NewOrderController::class,'export'])->name('admin.new-orders.export');

    NewOrderController::routes('/new-orders', '\App\Admin\Controllers\NewOrderController');

    Route::get('/orders/batch', [OrderController::class,'batch'])->name('admin.orders.batch');
    Route::post('/orders/upload', [OrderController::class,'upload'])->name('admin.orders.upload');
    Route::post('/orders/print-label', [OrderController::class,'printLabel'])->name('admin.orders.print-label');
    OrderController::routes('/orders', '\App\Admin\Controllers\OrderController');

    Route::put('/orders/upload-design-image/{id}', [OrderController::class,'uploadDesignImage'])->name('admin.orders.upload-design-image');
    Route::put('/orders/update-design-image/{id}', [OrderController::class,'updateDesignImage'])->name('admin.upload.update-design-image');

    Route::get('/upload', [UploadController::class,'index'])->name('admin.upload.index');

});
