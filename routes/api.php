<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;



// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/product/create', [ProductController::class, 'create'])->middleware('auth:sanctum');
Route::get('/products/all', [ProductController::class, 'all'])->middleware('auth:sanctum');
Route::get('/product/{id}/single', [ProductController::class, 'single'])->middleware('auth:sanctum');
Route::post('/product/{id}/delete', [ProductController::class, 'delete'])->middleware('auth:sanctum');

Route::get('/single-user-data/{user_id}', [UserController::class, 'singleUserData'])->middleware('auth:sanctum');
Route::get('/all-user-data', [UserController::class, 'allUserData'])->middleware('auth:sanctum');

Route::get('/single-product-data', [ProductController::class, 'allProductData'])->middleware('auth:sanctum');
Route::get('/all-product-data', [ProductController::class, 'allProductData'])->middleware('auth:sanctum');

// Route::group(['middleware' => ['auth:sanctum']], function () {
//     Route::post('/logout', [AuthController::class, 'logout']);
// });
