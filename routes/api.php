<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LacakController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/tracking/{kode_service}', [LacakController::class, 'track']);
Route::get('/tracking', [LacakController::class, 'index']);
