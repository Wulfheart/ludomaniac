<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/auth/redirect', function () {
    return Socialite::driver('keycloak')->redirect();
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('keycloak')->user();
    dd($user);
});
