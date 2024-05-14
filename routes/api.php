<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/product', [ProductController::class, 'createProduct']);
//Route::middleware('auth:sanctum')->get('/products', [ProductController::class, 'getAllProducts']);
Route::get('/products', [ProductController::class, 'getAllProducts']);
Route::get('/product/{id}', [ProductController::class, 'getProduct']);
Route::put('product/{id}/edit', [ProductController::class, 'updateProduct']);
Route::delete('/product/{id}/delete', [ProductController::class, 'deleteProduct']);

/**
 * AUTHENTICATION
 */
Route::post('/auth/register', [UserController::class, 'createUser']);
Route::post('/auth/login', [UserController::class, 'loginUser']);
