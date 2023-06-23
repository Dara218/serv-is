<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AgentServiceController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PricingPlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SentRequestController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function()
{
    Route::view('/', 'components.login')->name('login');

    Route::prefix('register')->name('register.')->group(function(){
        Route::get('/register', [RegisterController::class, 'create'])->name('create');
        Route::post('/register-store', [RegisterController::class, 'store'])->name('store');
        Route::post('/register-storeAgent', [RegisterController::class, 'storeAgent'])->name('storeAgent');
    });

    Route::prefix('session')->name('session.')->group(function(){
        Route::post('/login-store', [SessionController::class, 'store'])->name('store');
    });
});

Route::post('/stripe-webhook', [CheckInController::class, 'handleWebhook'])->name('stripe.webhook');
Route::post('/store-check-in', [CheckInController::class, 'storeCheckIn'])->name('storeCheckIn');

Route::middleware(['auth'])->group(function()
{
    Route::get('/edit-profile', [HomeController::class, 'showEditProfile'])->name('showEditProfile');
    Route::put('/edit-profile-process', [ProfileController::class, 'update'])->name('updateProfile');
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
    Route::get('/pricing-plan/{id}', [PricingPlanController::class, 'index'])->name('showPricingPlan');
    Route::post('/pricing-plan-store', [PricingPlanController::class, 'store'])->name('storePricing');
    Route::post('/pricing-plan-add-chat/{user}', [PricingPlanController::class, 'storeChat'])->name('storeChat');
    Route::post('/store-address', [AddressController::class, 'storeAddress'])->name('storeAddress');
    Route::put('/address-changed-update/{serviceaddress}', [AddressController::class, 'updateChangeAddress'])->name('updateChangeAddress');
    Route::put('/address-changed-secondary-update/{serviceaddress}', [AddressController::class, 'updateChangeSecondaryAddress'])->name('updateChangeSecondaryAddress');
    Route::put('/address-primary-update/{serviceaddress}', [AddressController::class, 'updatePrimaryAddress'])->name('updatePrimaryAddress');
    Route::put('/address-secondary-update/{serviceaddress}', [AddressController::class, 'updateSecondaryAddress'])->name('updateSecondaryAddress');
    Route::put('/address-to-primary-update/{id}', [AddressController::class, 'updateToPrimaryAddress'])->name('updateToPrimaryAddress');
    Route::put('/address-to-secondary-update/{id}', [AddressController::class, 'updateToSecondaryAddress'])->name('updateToSecondaryAddress');
    Route::delete('/address-destroy/{id}', [AddressController::class, 'destroyAddress'])->name('destroyAddress');
    Route::post('/store-contact-message', [ContactUsController::class, 'storeContactMessage'])->name('storeContactMessage');
    Route::post('/store-agenda', [AgendaController::class, 'storeAgenda'])->name('storeAgenda');
    Route::get('/get-services', [AgendaController::class, 'getServices'])->name('getServices');
    Route::put('/update-agenda/{agenda}', [AgendaController::class, 'updateAgenda'])->name('updateAgenda');
    Route::delete('/agenda-destroy/{agenda}', [AgendaController::class, 'destroyAgenda'])->name('destroyAgenda');
    Route::get('/get-services', [ServiceController::class, 'getServices'])->name('getServices');
    Route::put('/update-notification-count/{id}', [NotificationController::class, 'updateNotificationCount'])->name('updateNotificationCount');
    Route::put('/update-notification-accept/{notification}', [NotificationController::class, 'updateNotificationAccept'])->name('updateNotificationAccept');
    Route::put('/update-notification-reject/{notification}', [NotificationController::class, 'updateNotificationReject'])->name('updateNotificationReject');
    Route::post('/store-notification-to-customer', [NotificationController::class, 'storeNotificationToCustomer'])->name('storeNotificationToCustomer');
    Route::put('/update-availed-user-accepted/{notification}', [NotificationController::class, 'updateAvailedUserAccepted'])->name('updateAvailedUserAccepted');
    Route::post('/store-notification-negotiate-agenda', [NotificationController::class, 'storeNegotiateAgenda'])->name('storeNegotiateAgenda');
    Route::post('/get-sent-request', [SentRequestController::class, 'getSentRequest'])->name('getSentRequest');
    Route::post('/store-chat-after-negotiate', [MessageController::class, 'storeChatAfterNegotiate'])->name('storeChatAfterNegotiate');
    Route::put('/store-agent-updated-details/{id}', [AgentServiceController::class, 'storeAgentUpdatedDetails'])->name('storeAgentUpdatedDetails');
    Route::get('/get-all-agent-service', [ServiceController::class, 'getAllAgentService'])->name('getAllAgentService');
    Route::get('/get-search-agent-services', [SearchController::class, 'getSearchAgentService'])->name('getSearchAgentService');
    Route::get('/get-search-services', [SearchController::class, 'getSearchService'])->name('getSearchService');
    Route::put('/update-message-read/{id}', [MessageController::class, 'updateMessageRead'])->name('updateMessageRead');
    Route::get('/get-unread-messages', [MessageController::class, 'getUnreadMessages'])->name('getUnreadMessages');
    Route::post('/store-user-comment', [ReviewController::class, 'store'])->name('storeUserComment');

    Route::prefix('session')->name('session.')->group(function(){
        Route::post('/logout', [SessionController::class, 'logout'])->name('logout');
    });
});

Route::middleware(['auth', 'user-access:3'])->group(function()
{
    Route::get('/home', [HomeController::class, 'index'])->name('index');
});

Route::middleware(['auth', 'user-access:2'])->group(function()
{
    Route::get('/home-agent', [HomeController::class, 'indexAgent'])->name('indexAgent');
    Route::put('/update-agent-services/{id}', [AgentServiceController::class, 'updateAgentService'])->name('updateAgentService');
    Route::get('/update-service-details', [AgentServiceController::class, 'createServiceDetails'])->name('createServiceDetails');
    Route::put('/update-service-details/{agentservices}', [AgentServiceController::class, 'updateServiceDetails'])->name('updateServiceDetails');
});

Route::middleware(['auth', 'user-access:1'])->group(function()
{
    Route::get('/home-admin', [HomeController::class, 'indexAdmin'])->name('indexAdmin');
    Route::get('/show-confirm-agent/{user}', [AgentServiceController::class, 'showConfirmAgent'])->name('showConfirmAgent');
    Route::get('/show-confirm-agent-admin', [AgentServiceController::class, 'showConfirmAgentOnNav'])->name('showConfirmAgentOnNav');
    Route::get('/manage-customer-concern', [ContactUsController::class, 'index'])->name('showCustomerConcern');
    Route::put('/update-concern-status/{id}', [ContactUsController::class, 'update'])->name('updateConcernStatus');
    Route::get('/manage-website', [HomeController::class, 'showManageWebsite'])->name('showManageWebsite');
    Route::put('/update-service/{id}', [ServiceController::class, 'updateService'])->name('updateService');
    Route::put('/update-pricing-plan/{id}', [PricingPlanController::class, 'updatePricingPlan'])->name('updatePricingPlan');
    Route::put('/update-rewards/{id}', [RewardController::class, 'updateReward'])->name('updateReward');
    Route::post('/store-service', [ServiceController::class, 'storeService'])->name('storeService');
    Route::post('/store-pricing-plan', [PricingPlanController::class, 'storePricingPlan'])->name('storePricingPlan');
    Route::post('/store-rewards', [RewardController::class, 'storeReward'])->name('storeReward');
});
