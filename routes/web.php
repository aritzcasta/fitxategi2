<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::middleware('session.auth')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
