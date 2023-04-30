<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;



Route::middleware(['guest'])->group(function(){

    Route::prefix('home')->name('home.')->group(function(){
        Route::get('/home', [HomeController::class, 'index']);
    });

    Route::get('/', function () {
        return view('components.login');
    });

    Route::prefix('register')->name('register.')->group(function(){
        Route::get('/register', [RegisterController::class, 'create'])->name('create');
    });
});
