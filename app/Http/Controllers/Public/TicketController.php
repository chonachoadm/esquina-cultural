<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreTicketRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        abort_if($ticket->user_id !== auth()->id(), 403);
        $ticket->load(['purchase', 'performance.play']);

        return view('public-area.tickets.show', compact('ticket'));
    }

    /**
     * Show the QR scanner page for theater owners.
     */
    public function scanner()
    {
        abort_unless(
            auth()->user()->theater && auth()->user()->theater->verification_status === 'verified',
            403
        );

        return view('public-area.tickets.scan');
    }

    /**
     * Validate a scanned ticket code.
     */
    public function scan(Request $request)
    {
        $request->validate([
            'ticket_code' => 'required|string',
        ]);

        $ticket = Ticket::where('ticket_code', $request->ticket_code)->first();

        if (!$ticket) {
            return redirect()->route('profile')->with('error', 'Entrada no encontrada.');
        }
            
            $ticket->load(['purchase', 'user', 'guest', 'performance.play.theater']);
            
        if ($ticket->performance->play->theater->user_id !== auth()->id()) {
            return redirect()->route('profile')->with('error', 'Esta entrada no es para este teatro.');
        }
            
        if ($ticket->status === 'missed') {
            return redirect()->route('profile')->with('error', 'Esta función ya pasó.');
        }
            
        if ($ticket->is_scanned) {
            return redirect()->route('profile')->with('error', 'Esta entrada ya fue escaneada.');
        }

        $ticket->update([
            'is_scanned' => true,
            'status' => 'used',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Ticket validado correctamente',
            'play_title' => $ticket->performance->play->title,
            'buyer_name' => $ticket->user->name ?? $ticket->guest->name,
            'ticket_amount' => $ticket->purchase->ticket_amount,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
