<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Play;
use App\Models\Theater;
use App\Models\User;
use App\Models\Performance;
use App\Http\Requests\StorePlayRequest;
use App\Http\Requests\UpdatePlayInfoRequest;
use App\Http\Requests\UpdatePlayPerformancesRequest;
use App\Http\Requests\UpdatePlayStaffRequest;
use App\Services\ImageUploadService;

class PlayController extends Controller
{
    public function __construct(protected ImageUploadService $imageUploader)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plays = Play::all();
        return view('admin.plays.index', compact('plays'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $theaters = Theater::all();
        $users = User::all();
        return view('admin.plays.create', compact('theaters', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlayRequest $request)
    {
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = $this->imageUploader->storeBannerImage($request->file('image'), 'images/plays');
        }

        $play = Play::create([
            'title' => $request->title,
            'description' => $request->desc,
            'cover_photo' => $imageName,
            'theater_id' => $request->theater,
            'ticket_price' => $request->ticket_price,
            'duration' => $request->duration,
            'is_published' => false,
        ]);

        $staffIds = $request->input('staff_ids', []);
        $staffRoles = $request->input('staff_roles', []);

        foreach ($staffIds as $userId) {
            $play->users()->attach($userId, [
                'role' => $staffRoles[$userId] ?? null
            ]);
        }
        $start = \Carbon\Carbon::parse($request->start_date);
        $end = \Carbon\Carbon::parse($request->end_date);
        $performances = [];
        foreach ($request->day_times as $dayOfWeek => $time) {
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

        return redirect()->route('plays.index')->with('success', 'Obra creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Play $play)
    {
        $play->load([
            'theater',
            'performances' => function ($query) {
                $query->orderBy('start_time', 'asc');
            }
        ]);
        return view('admin.plays.show', compact('play'));
    }

    /**
     * Show the form for editing play information.
     */
    public function editInfo(Play $play)
    {
        $theaters = Theater::all();
        $play->load('theater');
        return view('admin.plays.edit-info', compact('play', 'theaters'));
    }

    /**
     * Update play information in storage.
     */
    public function updateInfo(UpdatePlayInfoRequest $request, Play $play)
    {
        $imageName = $play->cover_photo;
        if ($request->hasFile('image')) {
            $imageName = $this->imageUploader->storeBannerImage($request->file('image'), 'images/plays');
        }

        $play->update([
            'title' => $request->title,
            'description' => $request->desc,
            'cover_photo' => $imageName,
            'theater_id' => $request->theater,
            'ticket_price' => $request->ticket_price,
            'duration' => $request->duration,
        ]);

        return redirect()->route('plays.show', $play)->with('success', 'Información actualizada correctamente.');
    }

    /**
     * Show the form for editing play performances.
     */
    public function editPerformances(Play $play)
    {
        $play->load([
            'performances' => function ($query) {
                $query->orderBy('start_time', 'asc');
            }
        ]);
        return view('admin.plays.edit-performances', compact('play'));
    }

    /**
     * Update play performances in storage.
     */
    public function updatePerformances(UpdatePlayPerformancesRequest $request, Play $play)
    {
        $performances = [];
        $newPerformances = $request->input('new_performances', []);

        foreach ($newPerformances as $startTime) {
            $performances[] = [
                'play_id' => $play->id,
                'start_time' => $startTime,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($performances)) {
            Performance::insert($performances);
        }

        return redirect()->route('plays.show', $play)->with('success', 'Funciones actualizadas correctamente.');
    }

    /**
     * Show the form for editing play staff.
     */
    public function editStaff(Play $play)
    {
        $users = User::all();
        $play->load('users');
        return view('admin.plays.edit-staff', compact('play', 'users'));
    }

    /**
     * Update play staff in storage.
     */
    public function updateStaff(UpdatePlayStaffRequest $request, Play $play)
    {
        $syncData = [];
        $staffIds = array_merge(
            $request->input('staff_ids', []),
            $request->input('new_staff_ids', [])
        );

        $staffRoles = $request->input('staff_roles', []);

        foreach ($staffIds as $userId) {
            $syncData[$userId] = ['role' => $staffRoles[$userId] ?? null];
        }

        $play->users()->sync($syncData);

        return redirect()->route('plays.show', $play)->with('success', 'Integrantes actualizados correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Play $play)
    {
        $play->delete();
        return redirect()->route('plays.index')->with('success', 'Obra eliminada correctamente.');
    }


    public function verify(Play $play)
    {
        $play->update([
            'status' => 'verified',
        ]);

        return redirect()->route('plays.index')->with('success', 'Obra verificada.');
    }

    public function reject(Play $play)
    {
        $play->update([
            'status' => 'rejected',
        ]);

        return redirect()->route('plays.index')->with('success', 'Obra rechazada.');
    }


}
