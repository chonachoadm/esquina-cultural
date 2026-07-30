<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $savedPlays = auth()->user()->savedPlays()->get();
        $tickets = $user->tickets()->with('performance.play')->get()->sortBy(fn($ticket) => $ticket->performance->start_time);
        return view('public-area.users.profile', compact('user', 'savedPlays', 'tickets'));
    }

    public function settings()
    {
        return view('public-area.users.settings');
    }

    public function showSavedPlays()
    {
        return view('public-area.users.saved-plays');
    }
}
