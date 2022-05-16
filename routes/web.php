<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemoController;

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

Route::get('demos',[DemoController::class,'showTasks']);
Route::post('demos/column', [DemoController::class,'addColumn']);
Route::post('demos/card', [DemoController::class,'addCard']);
Route::patch('demos/card/{id}', [DemoController::class,'updateCard']);
Route::patch('demos/tasks/{id}', [DemoController::class,'updateTasksStatus']);
Route::put('demos/tasks/updateAll', [DemoController::class,'updateTasksOrder']);
Route::delete('demos/tasks/deleteColumn/{id}', [DemoController::class,'destroy']);
Route::get('demos/db-download',[DemoController::class,'downloadDB']);

