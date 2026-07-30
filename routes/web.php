<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\TestMail;

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Public\UserController as PublicUserController;
use App\Http\Controllers\Admin\PlayController as AdminPlayController;
use App\Http\Controllers\Public\PlayController as PublicPlayController;
use App\Http\Controllers\Admin\PerformanceController;
use App\Http\Controllers\Public\AuthController;
use App\Http\Controllers\Public\CommentController;
use App\Http\Controllers\Admin\PurchaseController as AdminPurchaseController;
use App\Http\Controllers\Public\PurchaseController as PublicPurchaseController;
use App\Http\Controllers\Admin\TheaterController as AdminTheaterController;
use App\Http\Controllers\Public\TheaterController as PublicTheaterController;
use App\Http\Controllers\Public\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Public\UsersSavePlaysController;
use App\Http\Controllers\Public\LandingController;
use App\Http\Controllers\Public\MercadoPagoController;
use App\Http\Controllers\Public\PaymentController;
use App\Http\Controllers\Public\TicketController;

// Ruta de la landing
Route::get('/', LandingController::class)->name('landing');

// Rutas de autenticación
Route::get('/ingresar', [AuthController::class, 'showAuth'])->name('login');
Route::post('/ingresar', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::post('/entradas/escanear', [TicketController::class, 'scan'])->name('tickets.scan');


Route::middleware('auth')->group(function() {
    Route::get('/perfil', [ProfileController::class, 'index'])->name('profile');
    Route::get('/perfil/ajustes', [ProfileController::class, 'settings'])->name('settings');
    Route::get('perfil/{user}/obrasguardadas', [ProfileController::class, 'showSavedPlays'])->name('showSavedPlays');
    Route::delete('/perfil/eliminar', [PublicUserController::class, 'destroy'])->name('public.user.delete');
    Route::get('perfil/{user}/editar', [PublicUserController::class, 'edit'])->name('public.user.edit');
    Route::put('perfil/{user}/editar', [PublicUserController::class, 'update'])->name('public.user.update');

    Route::get('/perfil/entradas/{ticket}', [TicketController::class, 'show'])->name('tickets.show');

    Route::get('/entradas/escanear', [TicketController::class, 'scanner'])->name('tickets.scanner');

    
    Route::get('/obra/crear', [PublicPlayController::class, 'create'])->name('obras.create');
    Route::post('/obra/crear', [PublicPlayController::class, 'store'])->name('obras.store');
    Route::delete('/obra/eliminar/{play}', [PublicPlayController::class, 'destroy'])->name('obras.destroy');
    Route::post('/obras/{play}/guardar', [UsersSavePlaysController::class, 'savePlay'])->name('save.play');
    Route::post('/obras/{play}/eliminar', [UsersSavePlaysController::class, 'destroyPlay'])->name('unsave.play');
    
    Route::get('/teatros/confirmacion', [PublicTheaterController::class, 'showTheaterConfirmation'])->name('theaterConfirmation');
    Route::resource('/teatros', PublicTheaterController::class)->except(['index', 'show']);

    Route::get('/mercadopago/conectar', [MercadoPagoController::class, 'connect'])->name('mercadopago.connect');
    Route::get('/mercadopago/callback', [MercadoPagoController::class, 'callback'])->name('mercadopago.callback');

    Route::get('/obras/{play}/revisar', [PublicPlayController::class, 'check'])->name('obras.check');
    Route::post('/obras/{play}/verificar', [PublicPlayController::class, 'verify'])->name('obras.verify');
    Route::post('/obras/{play}/rechazar', [PublicPlayController::class, 'reject'])->name('obras.reject');
});

// Rutas de cartelera
Route::get('/cartelera', [PublicPlayController::class, 'index'])->name('billboard');
Route::get('/obra/{play}', [PublicPlayController::class, 'show'])->name('obras.show');

// Rutas de compra de entrada
Route::get('/obra/{play}/compra', [PublicPurchaseController::class, 'create'])->name('compra.create');
Route::post('/obra/{play}/compra', [PublicPurchaseController::class, 'store'])->name('compra.store');
Route::get('/compra/{purchase}/checkout', [PublicPurchaseController::class, 'showCheckout'])->name('compra.checkout');
Route::get('/payment/{purchase}/checkout',[PaymentController::class, 'checkout'])->name('payment.checkout');
Route::get('/payment/success',[PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/failure',[PaymentController::class, 'failure'])->name('payment.failure');
Route::get('/payment/pending',[PaymentController::class, 'pending'])->name('payment.pending');
Route::post('/payment/webhook',[PaymentController::class, 'webhook'])->name('payment.webhook');

// Rutas públicas de teatros
Route::resource('/teatros', PublicTheaterController::class)->only(['index', 'show']);

// Rutas de comentarios
Route::post('/obra/{play}/comentario', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/obra/comentario/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

// Rutas de usuarios
Route::get('/usuario/{user}/perfil', [PublicUserController::class, 'show'])->name('user.profile');
    

// Rutas de resource ADMIN
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::resource('/users', AdminUserController::class);
    Route::resource('/plays', AdminPlayController::class)->except(['edit', 'update']);
    Route::resource('/performances', PerformanceController::class);
    Route::resource('/purchases', AdminPurchaseController::class);
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



use Illuminate\Support\Facades\DB;

Route::get('/check-purchase-user-column', function () {
    return DB::select("SHOW COLUMNS FROM purchases WHERE Field = 'user_id'");
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