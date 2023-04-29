<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('components.login');
});

Route::prefix('register')->name('register.')->group(function(){
    Route::get('/register', [RegisterController::class, 'create'])->name('create');
});
