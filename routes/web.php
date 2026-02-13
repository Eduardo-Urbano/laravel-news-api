<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostWebController;
use App\Http\Controllers\CategoryController; // Web controller
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', [PostWebController::class, 'index'])->name('posts.index');


Route::middleware('auth')->group(function () {
    // Rotas de Posts
    Route::get('/posts/create', [PostWebController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostWebController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostWebController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostWebController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostWebController::class, 'destroy'])->name('posts.destroy');
    
    // Rotas de Categorias (WEB)
    Route::resource('categories', CategoryController::class);
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Perfil (simplifiquei as rotas duplicadas)
    Route::get('/profile', function () {
        return view('profile.edit', ['user' => auth()->user()]);
    })->name('profile.edit');
    
    Route::patch('/profile', function (Request $request) {
        // Lógica para atualizar perfil
        return redirect()->back();
    })->name('profile.update');
    
    Route::delete('/profile', function (Request $request) {
        $user = $request->user();
        Auth::logout();
        $user->delete();
        return redirect('/')->with('status', 'Conta deletada com sucesso.');
    })->name('profile.destroy');
    Route::get('/posts/{post}', [PostWebController::class, 'show'])->name('posts.show');
});


require __DIR__.'/auth.php';