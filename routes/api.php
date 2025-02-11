<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AccessUser;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/', function () {
    return "Demo API";
});
Route::middleware(['AccessUser'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/users/edit', [UserController::class, 'update']);
    Route::post('/users/delete', [UserController::class, 'destroy']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/users', [UserController::class, 'index']);

