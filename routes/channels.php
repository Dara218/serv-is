<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
    // return Auth::check();
    // return true;
});

Broadcast::channel('chat.{id}', function ($user, $id) {
    // Add your authentication logic here
    // Return true if the user is authenticated and allowed to access the private channel
    // Return false if the user is not authenticated or not allowed to access the private channel

    // return $user->id === $id;
    // Auth::check();

    // return $user->username === $id;
    return true;
});

