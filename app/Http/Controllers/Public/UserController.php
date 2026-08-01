<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\ImageUploadService;

class UserController extends Controller
{
    public function __construct(protected ImageUploadService $imageUploader)
    {
    }

    public function edit(User $user)
    {
        if (Auth::user()->id == $user->id) {
            return view('public-area.users.edit', compact('user'));
        }
        return redirect()->route('billboard')->with('error', 'No podés acceder a esa sección.');
    }

    public function update(Request $request, User $user)
    {
        $profileData = [
            'bio' => $request->bio,
        ];
        if ($request->hasFile('image')) {
            $profileData['image'] = $this->imageUploader->storeProfileImage($request->file('image'));
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        $user->profile()->update($profileData);

        return redirect()->route('profile')->with('success', 'Tu información se actualizó correctamente.');
    }

    public function show(User $user)
    {
        if($user === Auth::user()){
            return view('profile');
        }
        return view('public-area.users.user-profile', compact('user'));
    }

    public function destroy(Request $request)
    {
        Auth::user()->delete();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('billboard')->with('success', 'Tu cuenta ha sido eliminada exitósamente.');
    }
}
