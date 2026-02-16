<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostWebController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::resource('posts', PostWebController::class);
    
    Route::resource('categories', CategoryController::class);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('posts', [PostWebController::class, 'index'])->name('posts.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';