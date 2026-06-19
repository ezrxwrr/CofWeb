<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\MejaController;
use App\Http\Controllers\Api\ReservasiController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\StaffController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

});

Route::get('/menus', [MenuController::class, 'index']);
Route::post('/menus', [MenuController::class, 'store']);
Route::post('/menus/{id}/upload', [MenuController::class, 'uploadImage']);

Route::get('/meja', [MejaController::class, 'index']);
Route::get('/meja/{id}', [MejaController::class, 'show']);
Route::post('/meja/{id}/occupy', [MejaController::class, 'occupy']);
Route::post('/meja/{id}/vacate', [MejaController::class, 'vacate']);

Route::get('/reservasi', [ReservasiController::class, 'index']);
Route::get('/reservasi/{id}', [ReservasiController::class, 'show']);
Route::post('/reservasi', [ReservasiController::class, 'store']);
Route::put('/reservasi/{id}', [ReservasiController::class, 'update']);
Route::delete('/reservasi/{id}', [ReservasiController::class, 'destroy']);

Route::get('/payment', [PaymentController::class, 'index']);
Route::get('/payment/{id}', [PaymentController::class, 'show']);
Route::post('/payment/pay', [PaymentController::class, 'pay']);

Route::post('/staff/login', [StaffController::class, 'login']);

