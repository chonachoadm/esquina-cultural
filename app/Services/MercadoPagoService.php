<?php

namespace App\Services;

use App\Models\Purchase;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

class MercadoPagoService
{
    public function createPreference(Purchase $purchase)
    {
        try {
            $seller = $purchase->performance->play->user;
            
            if (!$seller->mercadopago_access_token) {
                throw new \Exception('El creador no tiene Mercado Pago conectado');
                }
                
            // MercadoPagoConfig::setAccessToken(
            //     config('services.mercadopago.access_token')
            // );
            MercadoPagoConfig::setAccessToken(
                $seller->mercadopago_access_token
            );
            
            $client = new PreferenceClient();



            $preference = $client->create([
                'items' => [
                    [
                        'title' => $purchase->performance->play->title,
                        'quantity' => (int) $purchase->ticket_amount,
                        'unit_price' => (float) ($purchase->total_amount / $purchase->ticket_amount),
                        'currency_id' => 'ARS',
                        ]
                    ],
                'marketplace' => 'MP-MKT-' . config('services.mercadopago.client_id'),
                'marketplace_fee' => (float) $purchase->platform_fee_amount,
                'external_reference' => (string) $purchase->id,
                'back_urls' => [
                    'success' => route('payment.success'),
                    'failure' => route('payment.failure'),
                    'pending' => route('payment.pending'),
                ],

                'auto_return' => 'approved',
            ]);
                
            return $preference;
        } catch (\MercadoPago\Exceptions\MPApiException $e) {
            \Log::error('Mercado Pago preference error', [
                'message' => $e->getMessage(),
                'body' => $e->getApiResponse()?->getContent(),
                'status' => $e->getApiResponse()?->getStatusCode(),
                'token_used' => substr($seller->mercadopago_access_token, 0, 20) . '***', // primeros 20 chars del token
                'seller_id' => $seller->id,
            ]);

            throw new \RuntimeException('No se pudo crear la preferencia de pago');
        }
    }
}