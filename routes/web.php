<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group([
    'prefix' => 'users',
    'as' => 'user.',
    'middleware' => ['auth']
], function () {
    Route::resource('todos', TodoController::class,[
        'except' => ['destroy']
    ]);
    Route::get('todos/delete/{id}', [TodoController::class, 'delete'])->name('todos.delete');
    Route::get('todos/change-status/{id}', [TodoController::class, 'changeTodoStatus'])->name('todos.change-status');
});
