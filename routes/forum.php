<?php

use App\Forum\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('forum')->name('forum.')->group(function(){
   Route::get('/', [CategoryController::class, 'index'])->name('index');
});
