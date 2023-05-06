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
    $trail->parent('home');
    $trail->push(ucwords($user->fullname), route('home.showServiceProvider'));
});