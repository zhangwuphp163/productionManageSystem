<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SkuController;
use App\Http\Controllers\Admin\StockController;
use Illuminate\Support\Facades\Route;

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
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
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

    Route::get('/stocks', [StockController::class,'index'])->name('admin.stocks');
    Route::get('/stocks/{id}/edit', [StockController::class,'edit'])->name('admin.stocks.edit');
    Route::put('/stocks/{id}', [StockController::class,'update'])->name('admin.stocks.update');
    Route::delete('/stocks/{id}', [StockController::class,'destroy'])->name('admin.stocks.destroy');
    Route::get('/stocks/create', [StockController::class,'create'])->name('admin.stocks.create');
    Route::post('/stocks', [StockController::class,'store'])->name('admin.stocks.store');
    Route::post('/stocks/batch', [StockController::class,'batch'])->name('admin.stocks.batch');

});
