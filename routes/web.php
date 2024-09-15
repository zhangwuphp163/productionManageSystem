<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SkuController;
use App\Http\Controllers\Admin\StockController;
use App\Admin\Controllers\OrderController;
use App\Admin\Controllers\UploadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mobile\MobileOrderController;
use App\Admin\Controllers\LocationShelfController;
use App\Admin\Controllers\LocationController;
use App\Admin\Controllers\AsnController;

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
Route::get('/mobile/order', [MobileOrderController::class,'index'])->name('mobile.order');

Route::group(['namespace' => 'Admin', 'prefix' => 'admin','middleware' => 'admin.permission'], function () {

    \App\Admin\Controllers\StoreController::routes('/stores', '\App\Admin\Controllers\StoreController');
    \App\Admin\Controllers\AsnController::routes('/asns', '\App\Admin\Controllers\AsnController');
    \App\Admin\Controllers\ProductController::routes('/products', '\App\Admin\Controllers\ProductController');

    Route::get('/shelf', [LocationShelfController::class,'index'])->name('admin.shelf');
    Route::get('/shelf/create', [LocationShelfController::class,'create'])->name('admin.shelf.create');
    Route::post('/shelf', [LocationShelfController::class,'store'])->name('admin.shelf.store');
    Route::get('/shelf/{id}/edit', [LocationShelfController::class,'edit'])->name('admin.shelf.edit');
    Route::put('/shelf/{id}', [LocationShelfController::class,'update'])->name('admin.shelf.update');
    Route::delete('/shelf/{id}', [LocationShelfController::class,'destroy'])->name('admin.shelf.destroy');

    Route::get('/asns', [AsnController::class,'index'])->name('admin.asns');
    Route::get('/asns/create', [AsnController::class,'create'])->name('admin.asns.create');
    Route::get('/asns/{id}', [AsnController::class,'show'])->name('admin.asns.show');
    Route::post('/asns', [AsnController::class,'store'])->name('admin.asns.store');
    Route::get('/asns/{id}/edit', [AsnController::class,'edit'])->name('admin.asns.edit');
    Route::put('/asns/{id}', [AsnController::class,'update'])->name('admin.asns.update');
    Route::delete('/asns/{id}', [AsnController::class,'destroy'])->name('admin.asns.destroy');

    Route::get('/locations', [LocationController::class,'index'])->name('admin.locations');
    Route::get('/locations/create', [LocationController::class,'create'])->name('admin.locations.create');
    Route::post('/locations', [LocationController::class,'store'])->name('admin.locations.store');
    Route::get('/locations/{id}/edit', [LocationController::class,'edit'])->name('admin.locations.edit');
    Route::put('/locations/{id}', [LocationController::class,'update'])->name('admin.locations.update');
    Route::delete('/locations/{id}', [LocationController::class,'destroy'])->name('admin.locations.destroy');


    Route::get('/categories', [CategoryController::class,'index'])->name('admin.categories');
    Route::get('/categories/create', [CategoryController::class,'create'])->name('admin.categories.create');
    Route::post('/categories', [CategoryController::class,'store'])->name('admin.categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class,'edit'])->name('admin.categories.edit');
    Route::put('/categories/{id}', [CategoryController::class,'update'])->name('admin.categories.update');
    Route::delete('/categories/{id}', [CategoryController::class,'destroy'])->name('admin.categories.destroy');

    Route::get('/skus', [SkuController::class,'index'])->name('admin.skus');
    Route::get('/skus/create', [SkuController::class,'create'])->name('admin.skus.create');
    Route::post('/skus', [SkuController::class,'store'])->name('admin.skus.store');
    Route::get('/skus/{id}', [SkuController::class,'detail'])->name('admin.skus.detail');
    Route::get('/skus/{id}/edit', [SkuController::class,'edit'])->name('admin.skus.edit');
    Route::post('/skus', [SkuController::class,'store'])->name('admin.skus.store');
    Route::put('/skus/{id}', [SkuController::class,'update'])->name('admin.skus.update');
    Route::delete('/skus/{id}', [SkuController::class,'destroy'])->name('admin.skus.destroy');
    Route::post('/skus/print-label', [SkuController::class,'printLabel'])->name('admin.skus.print-label');

    Route::get('/stocks', [StockController::class,'index'])->name('admin.stocks');
    Route::get('/stocks/{id}/edit', [StockController::class,'edit'])->name('admin.stocks.edit');
    Route::put('/stocks/{id}', [StockController::class,'update'])->name('admin.stocks.update');
    Route::delete('/stocks/{id}', [StockController::class,'destroy'])->name('admin.stocks.destroy');
    Route::get('/stocks/create', [StockController::class,'create'])->name('admin.stocks.create');
    Route::post('/stocks', [StockController::class,'store'])->name('admin.stocks.store');
    Route::post('/stocks/batch', [StockController::class,'batch'])->name('admin.stocks.batch');


    Route::get('/orders', [OrderController::class,'index'])->name('admin.orders');
    Route::post('/orders', [OrderController::class,'store'])->name('admin.orders.store');
    Route::get('/orders/batch', [OrderController::class,'batch'])->name('admin.orders.batch');
    Route::post('/orders/upload', [OrderController::class,'upload'])->name('admin.orders.upload');
    Route::get('/orders/{id}/edit', [OrderController::class,'edit'])->name('admin.orders.edit');
    Route::put('/orders/{id}', [OrderController::class,'update'])->name('admin.orders.update');
    Route::delete('/orders/{id}', [OrderController::class,'destroy'])->name('admin.orders.destroy');
    Route::get('/orders/create', [OrderController::class,'create'])->name('admin.orders.create');
    Route::post('/orders/print-label', [OrderController::class,'printLabel'])->name('admin.orders.print-label');

    Route::put('/orders/upload-design-image/{id}', [OrderController::class,'uploadDesignImage'])->name('admin.orders.upload-design-image');
    Route::put('/orders/update-design-image/{id}', [OrderController::class,'updateDesignImage'])->name('admin.upload.update-design-image');

    Route::get('/upload', [UploadController::class,'index'])->name('admin.upload.index');

});
