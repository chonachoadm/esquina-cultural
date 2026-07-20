<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MercadoPagoOAuthService
{
    public function getAuthorizationUrl()
    {
        $params = [
            'client_id' => config('services.mercadopago.client_id'),
            'response_type' => 'code',
            'platform_id' => 'mp',
            'redirect_uri' => config('services.mercadopago.redirect_uri'),
        ];

        return 'https://auth.mercadopago.com/authorization?' . http_build_query($params);
    }


    public function getAccessToken($code)
    {
        $params = [
            'client_id' => config('services.mercadopago.client_id'),
            'client_secret' => config('services.mercadopago.client_secret'),
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => config('services.mercadopago.redirect_uri'),
        ];

        if (config('services.mercadopago.test_mode', false)) {
            $params['test_token'] = 'true';
        }
        $response = Http::asForm()->post(
            'https://api.mercadopago.com/oauth/token',
            $params
        );

        if ($response->failed()) {
            throw new \Exception(
                'Error al obtener token de Mercado Pago: ' . $response->body()
            );
        }

        return $response->json();
    }
}