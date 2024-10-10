<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserTypeController;
use App\Http\Controllers\Api\UserDetailController;
use App\Http\Controllers\Api\TodoController;
use App\Http\Controllers\Api\TodoStatusController;

// Login Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/auth/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
 
    return ['token' => $token->plainTextToken];
});

// TODOS
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('todos', TodoController::class);
});

// TODO STATUSES
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('todostatuses', TodoStatusController::class);
});

// USERS
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
});

// USER TYPES
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('user-types', UserTypeController::class);
});

// USER DETAILS
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('user-details', UserDetailController::class);
});