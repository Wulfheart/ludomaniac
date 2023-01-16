<?php

use App\Forum\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('auth.')->group(function(){
    Route::get('/login', \App\Auth\Livewire\Login::class)->name('login');
});
