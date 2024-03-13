<?php

use App\Http\Controllers\MenuOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

//Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => 'orders'], function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::post('/', [OrderController::class, 'store']);
    Route::get('/{order}', [OrderController::class, 'show']);
    Route::put('/{order}', [OrderController::class, 'update']);
    Route::delete('/{order}', [OrderController::class, 'destroy']);
});

Route::group(['prefix' => 'menu_orders'], function () {
    Route::get('/', [MenuOrderController::class, 'index']);
    Route::post('/', [MenuOrderController::class, 'store']);
    Route::get('/{order_id}/{menu_id}', [MenuOrderController::class, 'show']);
    Route::put('/{order_id}/{menu_id}', [MenuOrderController::class, 'update']);
    Route::delete('/{order_id}/{menu_id}', [MenuOrderController::class, 'destroy']);
    Route::get(
        '/{order_id}',
        [MenuOrderController::class, 'showMenuOrdersByOrder']
    );
});
