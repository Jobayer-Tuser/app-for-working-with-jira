<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DailyTaskController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;


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


    Route::group(['middleware' => ['auth']], function() {
        Route::get('home', [HomeController::class, 'index'])->name('home');
        Route::get('projects', [ProjectController::class, 'index'])->name('project.list');
        Route::get('task/{id}', [DailyTaskController::class, 'index'])->name('task.list');

    });
