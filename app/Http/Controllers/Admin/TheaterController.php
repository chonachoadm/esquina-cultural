<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Theater;
use App\Models\User;
use App\Http\Requests\StoreTheaterRequest;
use App\Http\Requests\UpdateTheaterRequest;
use App\Services\ImageUploadService;

class TheaterController extends Controller
{
    public function __construct(protected ImageUploadService $imageUploader)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $theaters = Theater::all();
        return view('admin.theaters.index', compact('theaters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.theaters.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTheaterRequest $request)
    {
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = $this->imageUploader->storeBannerImage($request->file('image'), 'images/theaters');
        }

        $theater = Theater::create([
            'user_id' => $request->user,
            'name' => $request->name,
            'bio' => $request->bio,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'max_capacity' => $request->capacity,
            'verification_status' => 'verified',
            'image' => $imageName,
        ]);

        $user = $theater->user;

        if ($user->isAdmin()) {
            return redirect()->route('theaters.index')->with('success', 'Teatro creado correctamente.');
        }
        $user->update([
            'role' => 2,
        ]);


        return redirect()->route('theaters.index')->with('success', 'Teatro creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Theater $theater)
    {
        return view('admin.theaters.show', compact('theater'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Theater $theater)
    {
        $users = User::all();
        return view('admin.theaters.edit', compact('theater', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTheaterRequest $request, Theater $theater)
    {


        $imageName = $theater->image;
        if ($request->hasFile('image')) {
            $imageName = $this->imageUploader->storeBannerImage($request->file('image'), 'images/theaters');
        }

        $theater->update([
            'user_id' => $request->user,
            'name' => $request->name,
            'bio' => $request->bio,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'max_capacity' => $request->capacity,
            'image' => $imageName,
        ]);

        return redirect()->route('theaters.index')->with('success', 'Teatro actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Theater $theater)
    {
        $theater->delete();

        return redirect()->route('theaters.index')->with('success', 'Teatro eliminado correctamente.');
    }

    public function verify(Theater $theater)
    {
        $theater->update([
            'verification_status' => 'verified',
        ]);

        return redirect()->route('theaters.index')->with('success', 'Teatro verificado.');
    }

    public function reject(Theater $theater)
    {
        $theater->update([
            'verification_status' => 'rejected',
        ]);

        return redirect()->route('theaters.index')->with('success', 'Teatro rechazado.');
    }
}
