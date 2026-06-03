<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PlayController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\TheaterController;

// Ruta al layout
Route::get('/', function () {
    return view('layouts.app');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('showRegister');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Rutas de resource
Route::resource('/users', UserController::class);
Route::resource('/plays', PlayController::class)->except(['edit', 'update']);
Route::resource('/performances', PerformanceController::class);
Route::resource('/purchases', PurchaseController::class);
Route::resource('/theaters', TheaterController::class);

// Rutas de editar info de obra
Route::get('/plays/{play}/edit-info', [PlayController::class, 'editInfo'])->name('plays.edit-info');
Route::put('/plays/{play}/info', [PlayController::class, 'updateInfo'])->name('plays.update-info');

// Rutas de editar funciones de obra
Route::get('/plays/{play}/edit-performances', [PlayController::class, 'editPerformances'])->name('plays.edit-performances');
Route::put('/plays/{play}/performances', [PlayController::class, 'updatePerformances'])->name('plays.update-performances');

// Rutas de editar integrantes de obra
Route::get('/plays/{play}/edit-staff', [PlayController::class, 'editStaff'])->name('plays.edit-staff');
Route::put('/plays/{play}/staff', [PlayController::class, 'updateStaff'])->name('plays.update-staff');

// Rutas de cartelera
Route::get('/cartelera', [PlayController::class, 'billboard'])->name('billboard');


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