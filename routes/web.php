<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Middleware\AuthenticateUser;


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
    return view('auth.login');
})->middleware(AuthenticateUser::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth.user');

Route::get('/home', [TaskController::class, 'index'])->name('note.index')->middleware('auth.user');
Route::get('/tasks/del/{task_id}', [TaskController::class, 'delete'])->middleware('auth.user');
Route::get('/tasks/edit/{task_id}', [TaskController::class, 'edit'])->middleware('auth.user');
Route::post('note/update/{id}', [TaskController::class, 'update'])->middleware('auth.user');
Route::post('note/store',[TaskController::class,'store'])->middleware('auth.user');







