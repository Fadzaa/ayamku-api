<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/users', [\App\Http\Controllers\UserController::class , 'register']);
Route::post('/users/login', [\App\Http\Controllers\UserController::class , 'login']);

Route::middleware('auth:sanctum')->get('/users', [\App\Http\Controllers\UserController::class , 'currentUser']);
Route::middleware('auth:sanctum')->post('/users', [\App\Http\Controllers\UserController::class , 'updateUser']);
Route::middleware('auth:sanctum')->delete('/users/logout', [\App\Http\Controllers\UserController::class , 'logout']);

Route::group(['prefix' => 'products'], function () {
    Route::get('/', [\App\Http\Controllers\ProductController::class , 'index']);
    Route::get('/terlaris', [\App\Http\Controllers\ProductController::class , 'indexTerlaris']);
    Route::get('/{id}', [\App\Http\Controllers\ProductController::class , 'show']);

    Route::group(['middleware' => 'admin'], function () {
        Route::post('/', [\App\Http\Controllers\ProductController::class , 'store']);
        Route::put('/{id}', [\App\Http\Controllers\ProductController::class , 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\ProductController::class , 'destroy']);
    });

});

Route::group(['prefix' => 'promos'], function () {
    Route::get('/', [\App\Http\Controllers\PromoController::class , 'index']);
    Route::get('/active', [\App\Http\Controllers\PromoController::class , 'indexActivePromo']);

    Route::group(['middleware' => 'admin'], function () {
        Route::post('/', [\App\Http\Controllers\PromoController::class , 'store']);
        Route::put('/{id}', [\App\Http\Controllers\PromoController::class , 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\PromoController::class , 'destroy']);
    });

});

Route::group(['prefix' => 'posts'], function () {
    Route::get('/', [\App\Http\Controllers\PostController::class , 'index']);

    Route::group(['middleware' => 'admin'], function () {
        Route::post('/', [\App\Http\Controllers\PostController::class , 'store']);
        Route::put('/{id}', [\App\Http\Controllers\PostController::class , 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\PostController::class , 'destroy']);
    });
});

Route::group(['prefix' => 'vouchers'], function () {
    Route::get('/', [\App\Http\Controllers\VoucherController::class , 'index']);

    Route::group(['middleware' => 'admin'], function () {
        Route::post('/', [\App\Http\Controllers\VoucherController::class , 'store']);
        Route::put('/{id}', [\App\Http\Controllers\VoucherController::class , 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\VoucherController::class , 'destroy']);
    });
});




