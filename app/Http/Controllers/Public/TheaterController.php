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

        $imageName = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/theaters', 'public');
            $imageName = basename($imagePath);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'capacity' => 'required|integer|min:1',
        ], [
            'name.required' => 'Este campo no puede quedar vacío.',
            'name.max' => 'El nombre no puede superar los 255 caracteres.',
            'bio.max' => 'La biografía no puede superar los 500 caracteres.',
            'address.required' => 'Este campo no puede quedar vacío.',
            'capacity.required' => 'Este campo no puede quedar vacío.',
            'capacity.min' => 'La capacidad de la sala no puede ser menos que 1.',
        ]);

        $theater = Theater::create([
            'user_id' => $user->id,
            'name' => $validatedData['name'],
            'bio' => $validatedData['bio'],
            'address' => $validatedData['address'],
            'latitude' => $validatedData['latitude'],
            'longitude' => $validatedData['longitude'],
            'max_capacity' => $validatedData['capacity'],
            'verification_status' => 'pending',
            'image' => $imageName,
        ]);

        if ($user->isAdmin()) {
            return redirect()->route('theaterConfirmation');
        }
        $user->update([
            'role' => 2,
        ]);


        return redirect()->route('theaterConfirmation');
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
        $theater = Theater::where('id', $id)->first();

        return view('public-area.theaters.edit', compact('theater'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'capacity' => 'required|integer|min:1',
        ], [
            'name.required' => 'Este campo no puede quedar vacío.',
            'name.max' => 'El nombre no puede superar los 255 caracteres.',
            'bio.max' => 'La biografía no puede superar los 500 caracteres.',
            'address.required' => 'Este campo no puede quedar vacío.',
            'capacity.required' => 'Este campo no puede quedar vacío.',
            'capacity.min' => 'La capacidad de la sala no puede ser menos que 1.',
        ]);

        $theater = Theater::where('id', $id)->first();

        $imageName = $theater->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/theaters', 'public');
            $imageName = basename($imagePath);
        }

        $theater->update([
            'name' => $validatedData['name'],
            'bio' => $validatedData['bio'],
            'address' => $validatedData['address'],
            'latitude' => $validatedData['latitude'],
            'longitude' => $validatedData['longitude'],
            'capacity' => $validatedData['capacity'],
            'verification_status' => 'pending',
            'image' => $imageName,
        ]);

        return redirect()->route('profile')->with('message', 'El administrador revisará los cambios hechos, te avisaremos cuando se verifique o se rechace la información del teatro.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $theater = Theater::where('id', $id)->first();

        $theater->update([
            'verification_status' => 'deleted'
        ]);
        $theater->delete();

        return redirect()->route('profile')->with('success', 'Teatro eliminado correctamente');
    }

    public function showTheaterConfirmation()
    {
        return view('public-area.theaters.confirmation');
    }
}
