<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostWebController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::resource('posts', PostWebController::class);
    Route::resource('categories', CategoryController::class);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('posts', [PostWebController::class, 'index'])
    ->name('posts.index');

    Route::get('/profile', function () {
        return view('profile.edit', ['user' => auth()->user()]);
    })->name('profile.edit');

    Route::patch('/profile', function () {
        return redirect()->back();
    })->name('profile.update');

    Route::delete('/profile', function (Request $request) {
        $user = $request->user();
        Auth::logout();
        $user->delete();
        return redirect('/')->with('status', 'Conta deletada com sucesso.');
    })->name('profile.destroy');
});

require __DIR__.'/auth.php';