<?php

use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::resource("products", ProductController::class)->parameters([
    'products' => 'product:slug',
]);
Route::middleware(['can:edit settings'])->group(function () {
    Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'show']);
    Route::post('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'save']);
});

