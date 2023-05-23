<?php

use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Illuminate\Support\Facades\Auth;

Breadcrumbs::for('home', function(BreadcrumbTrail $trail){
    if(Auth::user()->user_type == 3){
        $trail->push('Home', route('home.index'));
    }
    if(Auth::user()->user_type == 2){
        $trail->push('Home', route('home.indexAgent'));
    }
    if(Auth::user()->user_type == 1 ){
        $trail->push('Home', route('home.indexAdmin'));
    }
});

Breadcrumbs::for('edit-profile', function(BreadcrumbTrail $trail){
    $trail->parent('home');
    $trail->push('Edit Profile', route('home.showEditProfile'));
});

Breadcrumbs::for('my-wallet', function(BreadcrumbTrail $trail){
    $trail->parent('home');
    $trail->push('My Wallet', route('home.showWallet'));
});

Breadcrumbs::for('service-provider', function(BreadcrumbTrail $trail){
    $trail->parent('home');
    $trail->push('Service Provider', route('home.showServiceProvider'));
});

Breadcrumbs::for('employee-profile', function(BreadcrumbTrail $trail, User $user){
    $trail->parent('service-provider');
    $trail->push(ucwords($user->fullname), route('home.showServiceProvider'));
});

Breadcrumbs::for('service-address', function(BreadcrumbTrail $trail){
    $trail->parent('home');
    $trail->push('Add Service Address', route('home.showServiceAddress'));
});

Breadcrumbs::for('awards', function(BreadcrumbTrail $trail){
    $trail->parent('home');
    $trail->push('Awards and Discounts', route('home.showRewards'));
});

Breadcrumbs::for('transaction-history', function(BreadcrumbTrail $trail){
    $trail->parent('home');
    $trail->push('My transactions', route('home.showTransactionHistory'));
});

Breadcrumbs::for('faqs', function(BreadcrumbTrail $trail){
    $trail->parent('home');
    $trail->push('FaQs', route('home.showFaqs'));
});

Breadcrumbs::for('agenda', function(BreadcrumbTrail $trail){
    $trail->parent('home');
    $trail->push('Agenda', route('home.showAgenda'));
});

Breadcrumbs::for('pricing-plan', function(BreadcrumbTrail $trail, User $user){
    $trail->parent('home');
    $trail->push('Pricing Plan', route('home.showPricingPlan', ['user' => $user]));
});
