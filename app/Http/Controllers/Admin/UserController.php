<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\ImageUploadService;

class UserController extends Controller
{
    public function __construct(protected ImageUploadService $imageUploader)
    {
    }

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
    public function store(StoreUserRequest $request)
    {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 3,
            ]);

            $imageName = null;
            if ($request->hasFile('image')) {
                $imageName = $this->imageUploader->storeProfileImage($request->file('image'));
            }

            $user->profile()->create([
                'bio' => $request->bio,
                'image' => $imageName,
            ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
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
    public function update(UpdateUserRequest $request, User $user)
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

        return redirect()->route('users.show', $user)->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado.');
    }
}
