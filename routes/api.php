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
Route::middleware('auth:sanctum')->post('/users/logout', [\App\Http\Controllers\UserController::class , 'updateUser']);
Route::middleware('auth:sanctum')->delete('/users/logout', [\App\Http\Controllers\UserController::class , 'logout']);

Route::group(['prefix' => 'products'], function () {
    Route::get('/', [\App\Http\Controllers\ProductController::class , 'index']);
    Route::get('/geprek', [\App\Http\Controllers\ProductController::class , 'indexGeprek']);
    Route::get('/ricebowl', [\App\Http\Controllers\ProductController::class , 'indexRicebowl']);
    Route::get('/snack', [\App\Http\Controllers\ProductController::class , 'indexSnack']);
    Route::get('/minuman', [\App\Http\Controllers\ProductController::class , 'indexMinuman']);
    Route::get('/terlaris', [\App\Http\Controllers\ProductController::class , 'indexTerlaris']);
    Route::get('/{id}', [\App\Http\Controllers\ProductController::class , 'show']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/', [\App\Http\Controllers\ProductController::class , 'store']);
        Route::put('/{id}', [\App\Http\Controllers\ProductController::class , 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\ProductController::class , 'destroy']);
    });
});


