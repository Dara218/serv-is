<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;



Route::middleware(['guest'])->group(function(){

    Route::get('/', function () {
        return view('components.login');
    });

    Route::prefix('register')->name('register.')->group(function(){
        Route::get('/register', [RegisterController::class, 'create'])->name('create');
        Route::post('/register-store', [RegisterController::class, 'store'])->name('store');
        Route::post('/register-storeAgent', [RegisterController::class, 'storeAgent'])->name('storeAgent');
    });

    Route::prefix('session')->name('session.')->group(function(){
        Route::post('/login-store', [SessionController::class, 'store'])->name('store');
        Route::post('/login-store-client', [SessionController::class, 'storeClient'])->name('storeClient');
    });
});

Route::middleware(['auth'])->group(function(){

    Route::prefix('home')->name('home.')->group(function(){
        Route::get('/home', [HomeController::class, 'index'])->name('index');
    });

    Route::prefix('session')->name('session.')->group(function(){
        Route::post('/logout', [SessionController::class, 'logout'])->name('logout');
    });

});
