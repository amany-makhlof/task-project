<?php

use App\Common\Enums\RouteName;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::post('register', [RegisterController::class, 'register'])->name(RouteName::REGISTER);
Route::post('login', [LoginController::class, 'login'])->name(RouteName::LOGIN);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('users', [UserController::class, 'show']);
    Route::put('users', [UserController::class, 'update']);
    Route::apiResource('posts', PostController::class);


    //logout
    Route::post('logout', [LoginController::class, 'logout'])->name(RouteName::LOGOUT);
});
