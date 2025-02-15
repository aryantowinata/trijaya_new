<?php

use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserMiddleware;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware([UserMiddleware::class])->name('user.')->group(function () {
    Route::post('/midtrans/callback', [CartController::class, 'midtransCallback'])->name('callback');
});
