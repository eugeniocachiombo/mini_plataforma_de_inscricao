<?php

use App\Http\Controllers\Api\v1\CandidatureController;
use App\Http\Controllers\Api\v1\ProgramController;
use App\Http\Controllers\Api\v1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::apiResource('candidatos', UserController::class);
	Route::apiResource('programas', ProgramController::class);
    Route::apiResource('candidaturas', CandidatureController::class);
});