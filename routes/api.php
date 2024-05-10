<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1/auth'], function () {

    //  /api/v1/auth/login
    Route::post("login", [AuthController::class, "loginLaravel"]);

    //  /api/v1/auth/registro
    Route::post("registro", [AuthController::class, "registro"]);

    Route::group(["middleware" => "auth:sanctum"], function () {
        Route::get("perfil", [AuthController::class, "perfil"]);
        Route::get("logout", [AuthController::class, "logout"]);
    });
});
