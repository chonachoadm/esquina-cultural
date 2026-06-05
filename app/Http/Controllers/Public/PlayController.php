<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Play;
use App\Models\Comment;

class PlayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plays = Play::all();
        return view('public-area.billboard.index', compact('plays'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Play $play)
    {
        $play->load([
        'theater', 
        'comments.user', 
        'performances' => function ($query) {
            $query->orderBy('start_time', 'asc');
        }
    ]);
    return view('public-area.billboard.show', compact('play'));
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
