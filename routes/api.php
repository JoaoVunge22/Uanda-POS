<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\CallbackController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\HeaderCompanyController;
use App\Http\Controllers\Api\RuleController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Auth\Api\AuthController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1/uanda/auth')->group(function () {
    Route::post('/admin-login', [AuthController::class, 'adinlogin']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('/register', [AuthController::class, 'register']);
    Route::put('/resetPassword/{id}', [AuthController::class, 'reset']);
});

//API
Route::prefix('v1/uanda')->group(function () {
    Route::apiResource('admin', AdminController::class);
    Route::apiResource('headerCompone', HeaderCompanyController::class);
    Route::apiResource('compane', CompanyController::class);
    Route::apiResource('wallet', WalletController::class);
    Route::apiResource('rules', RuleController::class);
    Route::apiResource('transaction', TransactionController::class);
    Route::apiResource('users', UserController::class);
})->middleware('auth:api');


Route::prefix('v1/uanda/callback')->group(function () {
    Route::match(['put', 'post'], '/uanda', [CallbackController::class, 'login']);
});
