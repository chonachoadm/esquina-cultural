<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Play;
use App\Models\Performance;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Guest;

class PurchaseController extends Controller
{
    public function create(Play $play)
    {

        return view('public-area.purchase-process.purchase-form', compact('play'));
    }

    public function store(Request $request, Play $play)
    {
        $validatedData = $request->validate([
            'performance_id' => 'required|exists:performances,id', 
            'name' => 'required|string|max:255', 
            'email' => 'required|email|max:255', 
            'ticket_amount' => 'required|integer|min:1|max:10', 
            ],
            [ 
                'performance_id.required' => 'Este campo no puede quedar vacío.', 
                'performance_id.exists' => 'Debe seleccionarse una función existente.', 
                'name.required' => 'Este campo no puede quedar vacío.', 
                'name.max' => 'El nombre no puede superar los 255 caracteres.', 
                'email.required' => 'Este campo no puede quedar vacío.', 
                'ticket_amount.required' => 'Este campo no puede quedar vacío.', 
                'ticket_amount.min' => 'Debe haber al menos 1 entrada por compra.', 
                'ticket_amount.max' => 'No podés comprar más de 10 entradas a la vez.', 
            ]);
        $subtotal = $validatedData['ticket_amount'] * $play->ticket_price;
        $feeRate = 10;
        $feeAmount = $feeRate * $subtotal / 100;
        $totalAmount = $subtotal + $feeAmount;

        $performance = Performance::where('id', $validatedData['performance_id'])->first();
        
        
        if($validatedData['ticket_amount'] > $performance->available_tickets) {
            return back()->withInput()->with('error', 'Quedan ' . $performance->available_tickets . ' para esa función.');
        };

        $user = auth()->user();

        if($user) {
            $purchase = Purchase::create([
                'user_id' => $user->id,
                'guest_id' => null,
                'performance_id' => $validatedData['performance_id'],
                'ticket_amount' => $validatedData['ticket_amount'],
                'subtotal' => $subtotal,
                'platform_fee_rate' => $feeRate,
                'platform_fee_amount' => $feeAmount,
                'total_amount' => $totalAmount,
                'status' => 'pending',
            ]);
        } else {
                $guest = Guest::firstOrCreate(
                    [
                        'email' => $validatedData['email'],
                    ],
                    [
                        'name' => $validatedData['name'],
                    ]
                );

                $purchase = Purchase::create([
                    'user_id' => null,
                    'guest_id' => $guest->id,
                    'performance_id' => $validatedData['performance_id'],
                    'ticket_amount' => $validatedData['ticket_amount'],
                    'subtotal' => $subtotal,
                    'platform_fee_rate' => $feeRate,
                    'platform_fee_amount' => $feeAmount,
                    'total_amount' => $totalAmount,
                    'status' => 'pending',                
                ]);
            };

        return redirect()->route('compra.checkout', compact('purchase'));
    }

    public function showCheckout(Purchase $purchase)
    {
        $play = Play::where('id', $purchase->performance->play->id)->first();
        $subtotal = $purchase->ticket_amount * $play->ticket_price;
        $feeRate = 10;
        $feeAmount = $feeRate * $subtotal / 100;
     
        return view('public-area.purchase-process.purchase-checkout', compact('purchase', 'play', 'subtotal', 'feeAmount'));
    }
}
