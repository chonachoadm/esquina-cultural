<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $users = User::with('profile')->get();
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $profileData = [
            'bio' => $request->bio,
        ];
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/profiles', 'public');
            $profileData['image'] = basename($imagePath);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        $user->profile()->update($profileData);

        return redirect()->route('users.show', $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }
}
