<?php

namespace App\Http\Controllers;

use App\Models\Theater;
use App\Models\User;
use App\Http\Requests\StoreTheaterRequest;
use App\Http\Requests\UpdateTheaterRequest;

class TheaterController extends Controller
{
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

        $theater = Theater::create([
            'user_id' => $request->user,
            'name' => $request->name,
            'bio' => $request->bio,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'max_capacity' => $request->capacity,
            'verification_status' => 'verified',
            ]);


        return redirect()->route('theaters.index');
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
        $theater->update([
            'user_id' => $request->user,
            'name' => $request->name,
            'bio' => $request->bio,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'max_capacity' => $request->capacity,
        ]);

        return redirect()->route('theaters.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Theater $theater)
    {
        $theater->delete();

        return redirect()->route('theaters.index');
    }
}
