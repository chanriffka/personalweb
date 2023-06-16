<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [\App\Http\Controllers\WebController::class, 'Welcome'])->name('login');

Route::group(['prefix' => 'admin'], function () {

    Route::get('dashboard', function () {  
        return view('admin');
    })->name('admin.home');

    Route::resource('/portfolios', PortfolioController::class);
    Route::resource('/categories', CategoryController::class);
});
Auth::routes();
Auth::routes([
    'register' => false,
    // 'confirm' => false,
]);