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
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Public\UsersSavePlaysController;
use App\Http\Controllers\Public\LandingController;

// Ruta de la landing
Route::get('/', LandingController::class)->name('landing');

// Rutas de autenticación
Route::get('/ingresar', [AuthController::class, 'showAuth'])->name('login');
Route::post('/ingresar', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// Rutas de cartelera
Route::get('/cartelera', [PublicPlayController::class, 'index'])->name('billboard');
Route::get('/obra/{play}', [PublicPlayController::class, 'show'])->name('obras.show');

// Rutas públicas de teatros

// Rutas de comentarios
Route::post('/obra/{play}/comentario', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/obra/comentario/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

// Rutas de usuario autenticado
Route::middleware('auth')->group(function() {
    Route::get('/perfil', [ProfileController::class, 'index'])->name('profile');
    Route::get('/perfil/ajustes', [ProfileController::class, 'settings'])->name('settings');
    Route::get('perfil/{user}/obrasguardadas', [ProfileController::class, 'showSavedPlays'])->name('showSavedPlays');
    Route::delete('/perfil/eliminar', [PublicUserController::class, 'destroy'])->name('public.user.delete');
    Route::get('perfil/{user}/editar', [PublicUserController::class, 'edit'])->name('public.user.edit');
    Route::put('perfil/{user}/editar', [PublicUserController::class, 'update'])->name('public.user.update');

    Route::post('/obras/{play}/guardar', [UsersSavePlaysController::class, 'savePlay'])->name('save.play');
    Route::post('/obras/{play}/eliminar', [UsersSavePlaysController::class, 'destroyPlay'])->name('unsave.play');
    
    Route::get('/teatros/confirmacion', [PublicTheaterController::class, 'showTheaterConfirmation'])->name('theaterConfirmation');
    Route::resource('/teatros', PublicTheaterController::class)->except(['index', 'show']);

});
    
    Route::resource('/teatros', PublicTheaterController::class)->only(['index', 'show']);

// Rutas de resource ADMIN
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::resource('/users', AdminUserController::class);
    Route::resource('/plays', AdminPlayController::class)->except(['edit', 'update']);
    Route::resource('/performances', PerformanceController::class);
    Route::resource('/purchases', PurchaseController::class);
    Route::resource('/theaters', AdminTheaterController::class);
    Route::post('/theaters/{theater}/verify', [AdminTheaterController::class, 'verify'])->name('theaters.verify');
    Route::post('/theaters/{theater}/reject', [AdminTheaterController::class, 'reject'])->name('theaters.reject');
    Route::post('/plays/{play}/verify', [AdminPlayController::class, 'verify'])->name('plays.verify');
    Route::post('/plays/{play}/reject', [AdminPlayController::class, 'reject'])->name('plays.reject');

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