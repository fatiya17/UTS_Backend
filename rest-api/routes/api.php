<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/beritas', [BeritaController::class, 'index']);
    Route::post('/beritas', [BeritaController::class, 'store']);
    Route::get('/beritas/{id}', [BeritaController::class, 'show']);
    Route::put('/beritas/{id}', [BeritaController::class, 'update']);
    Route::delete('/beritas/{id}', [BeritaController::class, 'destroy']);
    Route::get('/beritas/search/{title}', [BeritaController::class, 'search']);
    Route::get('/beritas/category/sport', [BeritaController::class, 'sport']);
    Route::get('/beritas/category/finance', [BeritaController::class, 'finance']);
    Route::get('/beritas/category/automotive', [BeritaController::class, 'automotive']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
