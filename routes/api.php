<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PricingPlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get-categories', [CategoryController::class, 'getCategories'])->name('getCategories');
Route::get('/get-agent-service', [ServiceController::class, 'getAgentService'])->name('getAgentService');
Route::get('/get-users', [SearchController::class, 'getUsers'])->name('getUsers');
Route::get('/get-user-from-dropdown', [SearchController::class, 'getUsersFromDropdown'])->name('getUsersFromDropdown');
Route::get('/get-customer-concerns', [SearchController::class, 'getCustomerConcerns'])->name('getCustomerConcerns');
Route::get('/get-services-admin', [ServiceController::class, 'getServices'])->name('getServicesAdmin');
Route::get('/get-pricing-plan', [PricingPlanController::class, 'getPricingPlan'])->name('getPricingPlan');
Route::get('/get-rewards', [RewardController::class, 'getRewards'])->name('getRewards');
