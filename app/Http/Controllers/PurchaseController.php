<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\User;
use App\Models\Play;
use App\Models\Performance;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::all();
        return view('admin.purchases.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $performances = Performance::all();
        $users = User::all();
        $plays = Play::all();
        return view('admin.purchases.create', compact('users', 'plays', 'performances'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseRequest $request)
    {
        $play = Play::where('id', $request->play)->first();
        $totalAmount = $request->ticket_amount * $play->ticket_price;

        Purchase::create([
            'user_id' => $request->user,
            'performance_id' => $request->performance,
            'ticket_amount' => $request->ticket_amount,
            'total_amount' => $totalAmount,
            'payment_status' => $request->payment_status,
            'payment_gateway_id' => fake()->numerify('###########'),
        ]);

        return redirect()->route('purchases.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        return view('admin.purchases.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        $performances = Performance::all();
        $users = User::all();
        $plays = Play::all();
        return view('admin.purchases.edit', compact('purchase', 'users', 'plays', 'performances'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {

        $play = Play::where('id', $request->play)->first();
        $totalAmount = $request->ticket_amount * $play->ticket_price;

        $purchase->update([
            'user_id' => $request->user,
            'performance_id' => $request->performance,
            'ticket_amount' => $request->ticket_amount,
            'total_amount' => $totalAmount,
            'payment_status' => $request->payment_status,
        ]);
        
        return redirect()->route('purchases.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return redirect()->route('purchases.index');
    }
}
