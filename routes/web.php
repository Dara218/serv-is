<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PricingPlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;


Route::middleware(['guest'])->group(function(){

    Route::get('/', function () {
        return view('components.login');
    })->name('login');

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
        Route::get('/edit-profile', [HomeController::class, 'showEditProfile'])->name('showEditProfile');
        Route::put('/edit-profile-process', [ProfileController::class, 'update'])->name('editProfile');
        Route::get('/my-wallet', [ProfileController::class, 'showWallet'])->name('showWallet');
        Route::get('/service-provider', [ProfileController::class, 'showServiceProvider'])->name('showServiceProvider');
        Route::get('/employee-profile/{user:username}', [ProfileController::class, 'showEmployeeProfile'])->name('showEmployeeProfile');
        Route::get('/service-address', [ProfileController::class, 'showServiceAddress'])->name('showServiceAddress');
        Route::get('/rewards', [ProfileController::class, 'showRewards'])->name('showRewards');
        Route::get('/transaction-history', [ProfileController::class, 'showTransactionHistory'])->name('showTransactionHistory');
        Route::get('/faqs', [ProfileController::class, 'showFaqs'])->name('showFaqs');
        Route::get('/agenda', [ProfileController::class, 'showAgenda'])->name('showAgenda');
        Route::get('/chat', [ProfileController::class, 'showChat'])->name('showChat');
        Route::post('/get-user-chat', [ProfileController::class, 'getUserChat'])->name('getUserChat');
        Route::post('/handle-message', [MessageController::class, 'handleMessage'])->name('handleMessage');
        Route::get('/pricing-plan/{user}', [PricingPlanController::class, 'showPricingPlan'])->name('showPricingPlan');
        Route::post('/pricing-plan-store', [PricingPlanController::class, 'storePricing'])->name('storePricing');
    });

    Route::prefix('session')->name('session.')->group(function(){
        Route::post('/logout', [SessionController::class, 'logout'])->name('logout');
    });

});

Route::middleware(['customer'])->group(function(){
    Route::prefix('home')->name('home.')->group(function(){
        Route::get('/home', [HomeController::class, 'index'])->name('index');
    });
});

Route::middleware(['agent'])->group(function(){
    Route::prefix('home')->name('home.')->group(function(){
        Route::get('/home-agent', [HomeController::class, 'indexAgent'])->name('indexAgent');
    });
});

Route::middleware(['admin'])->group(function(){
    Route::prefix('home')->name('home.')->group(function(){
        Route::get('/home-admin', [HomeController::class, 'indexAdmin'])->name('indexAdmin');
    });
});
