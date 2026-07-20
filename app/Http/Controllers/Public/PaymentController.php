<?php

namespace App\Http\Controllers\Public;

use App\Services\MercadoPagoService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Purchase;

class PaymentController extends Controller
{
    public function __construct(private MercadoPagoService $mercadoPagoService) 
    {
        
    }

    public function checkout(Purchase $purchase)
    {
        $preference = $this->mercadoPagoService->createPreference($purchase);

        return redirect($preference->sandbox_init_point);
    }

    public function success(Request $request)
    {
        return response()->json(['status' => 'approved'], 200);
    }

    public function failure(Request $request)
    {
        \Log::error('Mercado Pago payment failure', [
            'query' => $request->all(),
        ]);

        return response()->json([
            'status' => 'failure',
            'message' => 'El pago no pudo completarse',
        ], 200);
    }

    public function pending(Request $request)
    {
        return response()->json(['status' => 'pending'], 200);
    }
}
