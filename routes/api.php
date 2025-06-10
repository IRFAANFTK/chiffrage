<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameSessionController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/sessions', [GameSessionController::class, 'create']);
Route::post('/sessions/{code}/join', [GameSessionController::class, 'join']);
Route::get('/sessions/{code}', [GameSessionController::class, 'getSession']);
Route::post('/sessions/{code}/choose', [GameSessionController::class, 'chooseCard']);
Route::post('/sessions/{code}/reset', [GameSessionController::class, 'resetRound']);
Route::post('/sessions/{session}/players/{player}/reset', [GameSessionController::class, 'resetRound']);
Route::post('/sessions/{code}/reveal-cards', [GameSessionController::class, 'revealCards']);
Route::get('/sessions/{code}', [GameSessionController::class, 'show']);


