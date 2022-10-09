<?php

use App\Http\Controllers\ResultController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/surveys/{id}', [SurveyController::class, 'get']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/surveys/{id}', [SurveyController::class, 'fill']);
});

Route::get('/surveys/{id}/stats', [ResultController::class, 'getStats']);
Route::get('/surveys/{id}/answers/{userId}', [ResultController::class, 'getAnswersByUser']);
