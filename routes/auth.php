<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/auth/redirect', function () {
    return Socialite::driver('laravelpassport')->redirect();
});

Route::get('/auth/callback', function (Illuminate\Http\Request $request) {
    $user = Socialite::driver('laravelpassport')->user();
    dd($request, $user);
});
