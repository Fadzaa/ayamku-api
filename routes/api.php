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
    Route::post('/otp', [\App\Http\Controllers\OtpController::class , 'sendOtp']);


    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/', [\App\Http\Controllers\UserController::class , 'currentUser']);
        Route::put('/', [\App\Http\Controllers\UserController::class , 'updateUser']);
        Route::delete('/logout', [\App\Http\Controllers\UserController::class , 'logout']);
        Route::put('/update-password', [\App\Http\Controllers\UserController::class , 'updatePassword']);
    });
});

Route::group(['prefix' => 'products'], function () {
    Route::get('/', [\App\Http\Controllers\ProductController::class , 'index']);
    Route::get('/terlaris', [\App\Http\Controllers\ProductController::class , 'indexTerlaris']);
    Route::get('/{id}', [\App\Http\Controllers\ProductController::class , 'show']);

    Route::group(['middleware' => ['auth:sanctum', 'admin']], function () {
        Route::post('/', [\App\Http\Controllers\ProductController::class , 'store']);
        Route::put('/{id}', [\App\Http\Controllers\ProductController::class , 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\ProductController::class , 'destroy']);
    });

});

Route::group(['prefix' => 'promos'], function () {
    Route::get('/', [\App\Http\Controllers\PromoController::class , 'index']);
    Route::get('/active', [\App\Http\Controllers\PromoController::class , 'indexActivePromo']);

    Route::group(['middleware' => ['auth:sanctum', 'admin']], function () {
        Route::post('/', [\App\Http\Controllers\PromoController::class , 'store']);
        Route::put('/{id}', [\App\Http\Controllers\PromoController::class , 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\PromoController::class , 'destroy']);
    });

});

Route::group(['prefix' => 'posts'], function () {
    Route::get('/', [\App\Http\Controllers\PostController::class , 'index']);

    Route::group(['middleware' => ['auth:sanctum', 'admin']], function () {
        Route::post('/', [\App\Http\Controllers\PostController::class , 'store']);
        Route::put('/{id}', [\App\Http\Controllers\PostController::class , 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\PostController::class , 'destroy']);
    });
});

Route::group(['prefix' => 'vouchers'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/show', [\App\Http\Controllers\VoucherController::class , 'currentUserVoucher']);
        Route::post('/redeem', [\App\Http\Controllers\VoucherController::class , 'redeemVoucher']);
    });

    Route::get('/', [\App\Http\Controllers\VoucherController::class , 'index']);

    Route::group(['middleware' => ['auth:sanctum', 'admin']], function () {
        Route::post('/', [\App\Http\Controllers\VoucherController::class , 'store']);
        Route::put('/{id}', [\App\Http\Controllers\VoucherController::class , 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\VoucherController::class , 'destroy']);
        Route::post('/give', [\App\Http\Controllers\VoucherController::class , 'giveVoucher']);
    });
});

Route::group(['prefix' => 'carts'], function () {
    Route::get('/', [\App\Http\Controllers\CartController::class , 'showCartByUser'])->middleware('auth:sanctum');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/', [\App\Http\Controllers\CartController::class , 'storeCart']);
        Route::put('/update-qty', [\App\Http\Controllers\CartController::class , 'updateCartItem']);
    });

});

Route::group(['prefix' => 'orders'], function () {
    Route::get('/', [\App\Http\Controllers\OrderController::class , 'index']);
    Route::get('/show', [\App\Http\Controllers\OrderController::class , 'show'])->middleware('auth:sanctum');
    Route::post('/', [\App\Http\Controllers\OrderController::class , 'store'])->middleware('auth:sanctum');
    Route::put('/update-status', [\App\Http\Controllers\OrderController::class , 'updateStatus'])->middleware('auth:sanctum');
    Route::get('/order-summary', [\App\Http\Controllers\OrderController::class , 'orderSummary'])->middleware('auth:sanctum', 'admin');
});

Route::post('/payments', [\App\Http\Controllers\PaymentController::class , 'create']);

Route::group(['prefix' => 'favourite-foods', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [\App\Http\Controllers\FavouriteFoodController::class , 'index']);
    Route::post('/', [\App\Http\Controllers\FavouriteFoodController::class , 'store']);
    Route::delete('/{productId}', [\App\Http\Controllers\FavouriteFoodController::class , 'destroy']);
});

Route::group(['prefix' => 'store-status'], function () {
    Route::get('/', [\App\Http\Controllers\StoreStatusController::class , 'getStoreStatus']);
    Route::put('/', [\App\Http\Controllers\StoreStatusController::class , 'updateStoreStatus']);
});


Route::group(['prefix' => 'order-histories'], function () {
    Route::get('/', [\App\Http\Controllers\OrderHistoryController::class , 'index']);
    Route::get('/show', [\App\Http\Controllers\OrderHistoryController::class , 'show'])->middleware('auth:sanctum');
});

Route::group(['prefix' => 'reviews'], function () {
    Route::get('/', [\App\Http\Controllers\ReviewController::class , 'index']);
    Route::post('/', [\App\Http\Controllers\ReviewController::class , 'store']);
    Route::put('/{id}', [\App\Http\Controllers\ReviewController::class , 'update']);
    Route::delete('/{id}', [\App\Http\Controllers\ReviewController::class , 'destroy']);
});

Route::get('/sales-summary', [\App\Http\Controllers\AnalyticController::class , 'salesSummary']);
