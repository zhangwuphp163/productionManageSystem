<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Route;

trait RouteServer
{
    public static function routes($prefix, $controller) {
        Route::get("/{$prefix}", [$controller,'index'])->name("admin.{$prefix}");
        Route::get("/{$prefix}/create", [$controller,'create'])->name("admin.{$prefix}.create");
        Route::get("/{$prefix}/{id}", [$controller,'show'])->name("admin.{$prefix}.show");
        Route::post("/{$prefix}", [$controller,'store'])->name("admin.{$prefix}.store");
        Route::get("/{$prefix}/{id}/edit", [$controller,'edit'])->name("admin.{$prefix}.edit");
        Route::put("/{$prefix}/{id}", [$controller,'update'])->name("admin.{$prefix}.update");
        Route::delete("/{$prefix}/{id}", [$controller,'destroy'])->name("admin.{$prefix}.destroy");
        Route::get("/{$prefix}/{id}", [$controller,'detail'])->name("admin.{$prefix}.detail");
    }

}
