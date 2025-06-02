<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameSessionController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/sessions', [GameSessionController::class, 'create']);
Route::post('/sessions/{code}/join', [GameSessionController::class, 'join']);
Route::post('/sessions/{code}/choose', [GameSessionController::class, 'chooseCard']);
Route::get('/sessions/{code}', [GameSessionController::class, 'show']);
