<?php

use App\Http\Controllers\SchemaController;
use App\Http\Controllers\UserContrller;
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

Route::prefix('users')->group(function () {
    Route::get('/', [UserContrller::class, 'index']);
    Route::post('/', [UserContrller::class, 'store']);
    Route::put('/{id}', [UserContrller::class, 'update']);
    Route::delete('/{id}', [UserContrller::class, 'deleteData']);
});

Route::prefix('schema')->group(function () {
    Route::get('/', [SchemaController::class, 'index']);
    Route::post('/', [SchemaController::class, 'store']);
    Route::put('/{id}', [SchemaController::class, 'update']);
    Route::delete('/{id}', [SchemaController::class, 'deleteSchema']);
});
