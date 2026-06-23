<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Play;
use App\Models\Theater;

class LandingController extends Controller
{
    public function __invoke()
    {
        $theaters = Theater::where('verification_status', 'verified')->take(3)->get();
        $plays = Play::with('performances')            
            ->where('status', 'verified')
            ->whereHas('performances', function ($query) {
                $query->where('start_time', '>', now());
            })
            ->whereHas('theater', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->take(3)->get();
        return view('public-area.landing', compact('plays', 'theaters'));
    }
}
