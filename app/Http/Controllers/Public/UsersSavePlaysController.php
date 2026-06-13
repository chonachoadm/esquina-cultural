<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Play;

class UsersSavePlaysController extends Controller
{
    public function savePlay(Play $play)
    {
        auth()->user()
            ->savedPlays()
            ->syncWithoutDetaching([$play->id]);

        return back()->with('success', 'Obra agregada a "Guardados".');
    }

    public function destroyPlay(Play $play)
    {
        auth()->user()
            ->savedPlays()
            ->detach($play->id);

        return back()->with('success', 'Obra quitada de "Guardados".');
    }
}
