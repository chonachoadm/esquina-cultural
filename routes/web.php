<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PlayController;


Route::get('/', function () {
    return view('layouts.app');
});

Route::resource('/users', UserController::class);


Route::resource('/plays', PlayController::class);

Route::get('/api/users/search', function (Request $request) {
    $query = $request->get('q');
    
    return User::where('name', 'like', "%{$query}%")
        ->with('profile') // Load the profile relationship
        ->limit(10)
        ->get()
        ->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                // Use your asset path logic here
                'avatar' => $user->profile?->image 
                    ? asset('storage/images/profiles/' . $user->profile->image) 
                    : 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $user->name,
            ];
        });
});