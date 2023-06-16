<?php

use App\Http\Controllers\ApiCategory;
use App\Http\Controllers\ApiPortfolio;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthApiController::class, 'login']);
Route::group([
    'middleware' => 'auth:api'
],function(){
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::apiResource('/category', ApiCategory::class);
    Route::apiResource('/portfolio', ApiPortfolio::class);
});