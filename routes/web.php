<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DailyTaskController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

    Route::get('/', function () {
        return view('welcome');
    });
    Auth::routes();

    Route::get('/home', [HomeController::class, 'index'])->name('home');



    Route::resource('projects', DashboardController::class);
    Route::get('task/{id}', [DailyTaskController::class, 'index'])->name('task.list');
    Route::post('task/search', [DailyTaskController::class, 'searchByOption'])->name('task.search');


    Route::group(['middleware' => ['guest']], function() {

    });

    Route::group(['middleware' => ['auth']], function() {
        /**
         * Logout Routes
         */
        Route::get('/logout', [LogoutController::class, 'perform'])->name('logout.perform');
    });


