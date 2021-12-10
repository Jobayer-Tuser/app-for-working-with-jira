<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DailyTaskController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Models\DailyTask;

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


    Route::get('home', [HomeController::class, 'index'])->name('home');

    #project route
    Route::post('project', [ProjectController::class, 'runCronJobForProject'])->name('project.sync');
    Route::get('project', [ProjectController::class, 'index'])->name('project.list');
    Route::post('projects/update',[ProjectController::class, 'update'])->name('project.update');

    #task route
    Route::post('task', [DailyTaskController::class, 'runCronJobForTask'])->name('task.sync');
    Route::get('task/{id}', [DailyTaskController::class, 'index'])->name('task.list');

    Route::group(['middleware' => ['auth']], function() {
    });

    Route::post('get', [ProjectController::class, 'fetch'])->name('project.get');
    Route::get('project/show', [ProjectController::class, 'show'])->name('project.show');
