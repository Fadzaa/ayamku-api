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

Route::group(['prefix' => 'users'], function () {
    Route::post('/', [\App\Http\Controllers\UserController::class , 'register']);
    Route::post('/login', [\App\Http\Controllers\UserController::class , 'login']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/', [\App\Http\Controllers\UserController::class , 'currentUser']);
        Route::put('/', [\App\Http\Controllers\UserController::class , 'updateUser']);
        Route::delete('/logout', [\App\Http\Controllers\UserController::class , 'logout']);
    });
});

Route::group(['prefix' => 'products'], function () {
    Route::get('/', [\App\Http\Controllers\ProductController::class , 'index']);
    Route::get('/terlaris', [\App\Http\Controllers\ProductController::class , 'indexTerlaris']);
    Route::get('/{id}', [\App\Http\Controllers\ProductController::class , 'show']);

//    Route::group(['middleware' => 'admin'], function () {
        Route::post('/', [\App\Http\Controllers\ProductController::class , 'store']);
        Route::put('/{id}', [\App\Http\Controllers\ProductController::class , 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\ProductController::class , 'destroy']);
//    });

});

Route::group(['prefix' => 'promos'], function () {
    Route::get('/', [\App\Http\Controllers\PromoController::class , 'index']);
    Route::get('/active', [\App\Http\Controllers\PromoController::class , 'indexActivePromo']);

//    Route::group(['middleware' => 'admin'], function () {
        Route::post('/', [\App\Http\Controllers\PromoController::class , 'store']);
        Route::put('/{id}', [\App\Http\Controllers\PromoController::class , 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\PromoController::class , 'destroy']);
//    });

});

Route::group(['prefix' => 'posts'], function () {
    Route::get('/', [\App\Http\Controllers\PostController::class , 'index']);

//    Route::group(['middleware' => 'admin'], function () {
        Route::post('/', [\App\Http\Controllers\PostController::class , 'store']);
        Route::put('/{id}', [\App\Http\Controllers\PostController::class , 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\PostController::class , 'destroy']);
//    });
});

Route::group(['prefix' => 'vouchers'], function () {
    Route::get('/', [\App\Http\Controllers\VoucherController::class , 'index']);

//    Route::group(['middleware' => 'admin'], function () {
        Route::post('/', [\App\Http\Controllers\VoucherController::class , 'store']);
        Route::put('/{id}', [\App\Http\Controllers\VoucherController::class , 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\VoucherController::class , 'destroy']);
//    });
});

Route::group(['prefix' => 'carts'], function () {
    Route::get('/{userId}', [\App\Http\Controllers\CartController::class , 'showCartByUser']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/', [\App\Http\Controllers\CartController::class , 'storeCart']);
    });

//    Route::group(['middleware' => 'admin'], function () {

//    });
});

Route::group(['prefix' => 'orders'], function () {
    Route::get('/', [\App\Http\Controllers\OrderController::class , 'index']);
    Route::post('/', [\App\Http\Controllers\OrderController::class , 'store']);


//    Route::group(['middleware' => 'admin'], function () {

//    });
});

Route::post('/payments', [\App\Http\Controllers\PaymentController::class , 'create']);

Route::group(['prefix' => 'favourite-foods', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [\App\Http\Controllers\FavouriteFoodController::class , 'index']);
    Route::post('/', [\App\Http\Controllers\FavouriteFoodController::class , 'store']);
    Route::delete('/{productId}', [\App\Http\Controllers\FavouriteFoodController::class , 'destroy']);
});





