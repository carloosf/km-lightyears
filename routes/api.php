<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConversionController;

Route::post('/quilometros', [ConversionController::class, 'convertToLightYears']);
Route::post('/anosLuz', [ConversionController::class, 'convertToKilometers']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
