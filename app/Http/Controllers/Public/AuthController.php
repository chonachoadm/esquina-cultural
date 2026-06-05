<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('billboard');
        }
        return back()->withErrors([
        'email' => 'Credenciales incorrectas.',
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 3,
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/profiles', 'public');
        }
        $imageName = basename($imagePath);

        $user->profile()->create([
            'bio' => $request->bio,
            'image' => $imageName,
        ]);

        return redirect('/login');

    }

    public function showLogin()
    {
        return view('auth.login');
    }
    
    public function showRegister()
    {
        return view('auth.register');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
