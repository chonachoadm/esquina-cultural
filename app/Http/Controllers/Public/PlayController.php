<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Theater;
use App\Models\Play;
use App\Models\Comment;
use App\Models\Performance;

class PlayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plays = Play::with('performances')
            ->where('status', 'verified')
            ->whereHas('performances', function ($query) {
                $query->where('start_time', '>', now());
            })
            ->whereHas('theater', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->get();

        return view('public-area.plays.index', compact('plays'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();

        if(!$user->hasMercadoPagoConnected()) {
            return redirect()->route('mercadopago.connect')->with('info', 'Tenés que enlazar tu cuenta de MercadoPago para poder publicar una obra');
        }
        $theaters = Theater::where('verification_status', 'verified')->get();
        return view('public-area.plays.create', compact('theaters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if(!$user->hasMercadoPagoConnected()) {
            return redirect()
                ->route('mercadopago.connect')
                ->with('messsage', 'Tenés que enlazar tu cuenta de MercadoPago para publicar una obra');
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            'theater_id' => 'required|integer|exists:theaters,id',
            'ticket_price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'staff_ids' => 'nullable|array',
            'staff_ids.*' => 'integer|exists:users,id',
            'staff_roles' => 'nullable|array',
            'staff_roles.*' => 'nullable|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after:start_date',
            'day_times'   => 'required|array|min:1',
            'day_times.*' => 'required|date_format:H:i',
        ], [
            'title.required' => 'Este campo no puede quedar vacío.',
            'title.max' => 'El título no puede superar los 255 caracteres.',
            'desc.required' => 'Este campo no puede quedar vacío.',
            'image.image' => 'El archivo debe ser una imagen válida.',
            'image.mimes' => 'Los formatos de imagen aceptados son: .jpeg, .png, .jpg, .gif y .webp.',
            'theater.required' => 'Tenés que seleccionar un teatro.',
            'theater.integer' => 'Este teatro no es válido.',
            'theater.exists' => 'Este teatro no está registrado en nuestra plataforma.',
            'ticket_price.required' => 'El precio de la entrada es obligatorio.',
            'ticket_price.numeric' => 'El precio debe ser un número válido.',
            'ticket_price.min' => 'El precio no puede ser negativo.',
            'duration.min' => 'La duración debe ser al menos 1 minuto.',   
            'staff_ids.array' => 'Los integrantes del elenco deben ser seleccionados correctamente.',
            'staff_ids.*.integer' => 'Uno de los integrantes seleccionados no es válido.',
            'staff_ids.*.exists' => 'Uno de los integrantes seleccionados no existe en el sistema.',
            'staff_roles.array' => 'Los roles deben estar en formato correcto.',
            'staff_roles.*.string' => 'Cada rol debe ser un texto válido.',
            'staff_roles.*.max' => 'El rol no puede exceder 255 caracteres.',
            'start_date.required' => 'Es necesario seleccionar la fecha de la primera función.',
            'start_date.after_or_equal' => 'La fecha no puede ser previa a hoy.',
            'end_date.required' => 'Es necesario seleccionar la fecha de la última función.',
            'end_date.after' => 'La última función debe ser posterior a la primera función.',
            'day_times.required' => 'Debes seleccionar al menos un día de función.',
            'day_times.*.date_format' => 'El formato de hora no es válido.',
        ]);

        $imageName = null;
        if (isset($validatedData['image'])) {
            $imagePath = $validatedData['image']->store('images/plays', 'public');
            $imageName = basename($imagePath);
        }

        $play = Play::create([
            'user_id' => $user->id,
            'title' => $validatedData['title'],
            'description' => $validatedData['desc'],
            'cover_photo' => $imageName,
            'theater_id' => $validatedData['theater_id'],
            'ticket_price' => $validatedData['ticket_price'],
            'duration' => $validatedData['duration'],
            'is_published' => false,
        ]);

        $staffIds = $validatedData['staff_ids'] ?? [];
        $staffRoles = $validatedData['staff_roles'] ?? [];
        
        foreach ($staffIds as $userId) {
            $play->users()->attach($userId, [
                'role' => $staffRoles[$userId] ?? null
            ]);
        }

        $start = \Carbon\Carbon::parse($validatedData['start_date']);
        $end = \Carbon\Carbon::parse($validatedData['end_date']);
        $performances = [];
        foreach ($validatedData['day_times'] as $dayOfWeek => $time) {
            $current = $start->copy();

            while ($current->lte($end)) {
                if ($current->dayOfWeek == $dayOfWeek) {
                    $performances[] = [
                        'play_id' => $play->id,
                        'start_time' => $current->format('Y-m-d') . ' ' . $time . ':00',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                $current->addDay();
            }
        }
        Performance::insert($performances);

        return redirect()->route('billboard')->with('success', 'Obra enviada a revisión.');
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
    return view('public-area.plays.show', compact('play'));
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

    public function check(Play $play)
    {

        return view('public-area.theaters.pending-play-show', compact('play'));
    }
    public function verify(Play $play)
    {
        $play->update([
            'status' => 'verified',
        ]);
        $teatro = $play->theater;

        return redirect()->route('teatros.show', compact('teatro'))->with('success', 'Obra verificada.');
    }

    public function reject(Play $play)
    {
        $play->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Obra rechazada.');
    }
}
