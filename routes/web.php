<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Public\UserController as PublicUserController;
use App\Http\Controllers\Admin\PlayController as AdminPlayController;
use App\Http\Controllers\Public\PlayController as PublicPlayController;
use App\Http\Controllers\Admin\PerformanceController;
use App\Http\Controllers\Public\AuthController;
use App\Http\Controllers\Public\CommentController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\TheaterController as AdminTheaterController;
use App\Http\Controllers\Public\TheaterController as PublicTheaterController;
use App\Http\Controllers\Public\ProfileController;

// Ruta al layout
Route::get('/', function () {
    return view('layouts.app');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('showRegister');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// Rutas de cartelera
Route::get('/cartelera', [PublicPlayController::class, 'index'])->name('billboard');
Route::get('/obra/{play}', [PublicPlayController::class, 'show'])->name('plays.show');

// Rutas de comentarios
Route::post('/obra/{play}/comentario', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/obra/comentario/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

// Rutas de perfil
Route::middleware('auth')->group(function() {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::delete('/profile/delete', [PublicUserController::class, 'destroy'])->name('public.user.delete');
    Route::get('edit/{user}/profile', [PublicUserController::class, 'edit'])->name('public.user.edit');
    Route::put('edit/{user}/profile', [PublicUserController::class, 'update'])->name('public.user.update');
    
    Route::resource('/teatros', PublicTheaterController::class);
});


// Rutas de resource ADMIN
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('/users', AdminUserController::class);
    Route::resource('/plays', AdminPlayController::class)->except(['edit', 'update']);
    Route::resource('/performances', PerformanceController::class);
    Route::resource('/purchases', PurchaseController::class);
    Route::resource('/theaters', AdminTheaterController::class);

    // Rutas de editar info de obra
    Route::get('/plays/{play}/edit-info', [AdminPlayController::class, 'editInfo'])->name('plays.edit-info');
    Route::put('/plays/{play}/info', [AdminPlayController::class, 'updateInfo'])->name('plays.update-info');
    
    // Rutas de editar funciones de obra
    Route::get('/plays/{play}/edit-performances', [AdminPlayController::class, 'editPerformances'])->name('plays.edit-performances');
    Route::put('/plays/{play}/performances', [AdminPlayController::class, 'updatePerformances'])->name('plays.update-performances');
    
    // Rutas de editar integrantes de obra
    Route::get('/plays/{play}/edit-staff', [AdminPlayController::class, 'editStaff'])->name('plays.edit-staff');
    Route::put('/plays/{play}/staff', [AdminPlayController::class, 'updateStaff'])->name('plays.update-staff');
});

// Ruta de Tom Select
Route::get('/api/users/search', function (Request $request) {
    $query = $request->get('q');
    
    return User::where('name', 'like', "%{$query}%")
        ->with('profile')
        ->limit(10)
        ->get()
        ->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'avatar' => $user->profile?->image 
                    ? asset('storage/images/profiles/' . $user->profile->image) 
                    : 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $user->name,
            ];
        });
});