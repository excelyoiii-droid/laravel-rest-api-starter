<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\TaskController;
use App\Http\Controllers\API\auth\LoginController;

route::prefix('v1')->group(function () {
    Route::apiResource('tasks', TaskController::class);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::post('login', LoginController::class);
});
