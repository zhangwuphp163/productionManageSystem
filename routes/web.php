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
    Route::post('/categories', [CategoryController::class,'store'])->name('admin.categories.store');
    Route::put('/categories/{id}', [CategoryController::class,'update'])->name('admin.categories.update');

    Route::get('/skus', [SkuController::class,'index'])->name('admin.skus');
    Route::post('/skus', [SkuController::class,'store'])->name('admin.skus.store');
    Route::put('/skus/{id}', [SkuController::class,'update'])->name('admin.skus.update');

    Route::get('/stocks', [StockController::class,'index'])->name('admin.stocks');
    Route::delete('/stocks/{id}', [StockController::class,'destroy'])->name('admin.stocks.destroy');

});
