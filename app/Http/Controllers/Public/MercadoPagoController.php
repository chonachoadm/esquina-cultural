<?php

namespace App\Http\Controllers\Public;

use App\Services\MercadoPagoOAuthService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MercadoPagoController extends Controller
{

    public function __construct(private MercadoPagoOAuthService $mercadoPagoOAuthService)
    {

    }

    public function connect()
    {
        $url = $this->mercadoPagoOAuthService->getAuthorizationUrl();

        return redirect($url);
    }

    public function callback(Request $request)
    {
        $code = $request->query('code');

        if (!$code) {
            return redirect()->route('obras.create')->with('error', 'No se pudo conectar Mercado Pago');
        }

        $tokens = $this->mercadoPagoOAuthService->getAccessToken($code);

        $user = auth()->user();

        $user->update([
            'mercadopago_user_id' => $tokens['user_id'],
            'mercadopago_access_token' => $tokens['access_token'],
            'mercadopago_refresh_token' => $tokens['refresh_token'],
            'mercadopago_connected_at' => now(),
        ]);

        return redirect()->route('obras.create')->with('success', 'Cuenta de Mercado Pago conectada correctamente');
    }
}
