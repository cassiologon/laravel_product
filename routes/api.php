<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/user', [AuthController::class,'create']);
Route::get('/unauthorized', [AuthController::class,'unauthorized'])->name('login');

Route::get('/product/query', [ProductController::class,'query'])->middleware('auth:sanctum');
