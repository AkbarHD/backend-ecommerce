<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\SizeController;
use App\Http\Controllers\admin\TemImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::post('/admin/login', [AuthController::class, 'authenticate']);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{id}', [CategoryController::class, 'show']);
    Route::put('categories/{id}', [CategoryController::class, 'update']);
    Route::delete('categories/{id}', [CategoryController::class, 'destroy']);
    Route::post('categories', [CategoryController::class, 'store']);

    Route::resource('brands', BrandController::class);
    Route::resource('products', ProductController::class);

    Route::get('sizes', [SizeController::class, 'index']);
    Route::post('temp-images', [TemImageController::class, 'store']);
});
