<?php

use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Illuminate\Support\Facades\Auth;

Breadcrumbs::for('home', function(BreadcrumbTrail $trail){
    if(Auth::user()->user_type == 3){
        $trail->push('Home', route('index'));
    }
    if(Auth::user()->user_type == 2){
        $trail->push('Home', route('homeAgent'));
    }
    if(Auth::user()->user_type == 1 ){
        $trail->push('Home', route('homeAdmin'));
    }
});

Breadcrumbs::for('edit-profile', function(BreadcrumbTrail $trail){
    $trail->parent('home');
    $trail->push('Edit Profile', route('showEditProfile'));
});

Breadcrumbs::for('my-wallet', function(BreadcrumbTrail $trail){
    $trail->parent('home');
    $trail->push('My Wallet', route('showWallet'));
});

Breadcrumbs::for('service-provider', function(BreadcrumbTrail $trail){
    $trail->parent('home');
    $trail->push('Service Provider', route('showServiceProvider'));
});

Breadcrumbs::for('employee-profile', function(BreadcrumbTrail $trail, User $user){
    $trail->parent('service-provider');
    $trail->push(ucwords($user->fullname), route('showServiceProvider'));
});

Breadcrumbs::for('service-address', function(BreadcrumbTrail $trail){
    $trail->parent('home');
    $trail->push('Add Service Address', route('showServiceAddress'));
});

Breadcrumbs::for('awards', function(BreadcrumbTrail $trail){
    $trail->parent('home');
    $trail->push('Awards and Discounts', route('showRewards'));
});

Breadcrumbs::for('transaction-history', function(BreadcrumbTrail $trail){
    $trail->parent('home');
    $trail->push('My transactions', route('showTransactionHistory'));
});

Breadcrumbs::for('faqs', function(BreadcrumbTrail $trail){
    $trail->parent('home');
    $trail->push('FaQs', route('showFaqs'));
});

Breadcrumbs::for('agenda', function(BreadcrumbTrail $trail){
    $trail->parent('home');
    $trail->push('Agenda', route('showAgenda'));
});

Breadcrumbs::for('pricing-plan', function(BreadcrumbTrail $trail, User $user){
    $trail->parent('home');
    $trail->push('Pricing Plan', route('showPricingPlan', ['user' => $user]));
});

Breadcrumbs::for('update-service-details', function(BreadcrumbTrail $trail){
    $trail->parent('home');
    $trail->push('Update Service Details', route('createServiceDetails'));
});
