<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\API\ApiAuthController;
use App\Http\Controllers\API\ApiProductController;
use Laravel\Sanctum\Sanctum;
use App\Http\Controllers\UserTransactionController;


Route::middleware('auth:sanctum')->group( function () {
   
    Route::get('products', [ApiProductController::class, 'index']);
    Route::get('products/{id}', [ApiProductController::class, 'show']);
    Route::post('products', [ApiProductController::class, 'store']);
    Route::put('products/{id}', [ApiProductController::class, 'update']);
    Route::delete('products/{id}', [ApiProductController::class, 'destroy']);
});

// routes/api.php
Route::post('/xendit/callback', [UserTransactionController::class, 'callback'])
    ->withoutMiddleware([
        'auth:sanctum',
        \App\Http\Middleware\VerifyCsrfToken::class,
    ]);



  Route::post('login', [ApiAuthController::class, 'login'])->name('api.login');
  Route::post('register', [ApiAuthController::class, 'register']);
  
Route::middleware('auth:sanctum')->get('/test-sanctum', function () {
    return response()->json(['message' => 'Sanctum is working']);
});

Route::get('/test-outsanctum', function () {
    return response()->json(['message' => 'Sanctum is working']);
});

Route::post('/dark-mode', function (Request $request) {
    $mode = $request->input('mode', 'light');
    session(['dark_mode' => $mode]);
    return response()->json(['mode' => $mode, 'success' => true]);
});