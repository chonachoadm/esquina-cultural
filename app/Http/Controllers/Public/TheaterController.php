<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Theater;

class TheaterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $theaters = Theater::where('verification_status', 'verified')->get();

        return view('public-area.theaters.index', compact('theaters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        return view('public-area.theaters.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $theater = Theater::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'bio' => $request->bio,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'max_capacity' => $request->capacity,
            'verification_status' => 'pending',
            ]);

        $user->update([
            'role' => 2,
        ]);


        return redirect()->route('profile');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $theater = Theater::where('id', $id)->first();

        return view('public-area.theaters.show', compact('theater'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
