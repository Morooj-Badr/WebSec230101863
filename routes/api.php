<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('login', [UserController::class, 'login']);
Route::get('/users', [UserController::class, 'users'])->middleware('auth:api');
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:api');