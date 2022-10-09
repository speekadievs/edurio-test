<?php

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
