<?php

namespace App\Services;

use App\Models\Purchase;
use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Resources\Payment;

class MercadoPagoService
{
    public function createPreference(Purchase $purchase)
    {
        try {
            $seller = $purchase->performance->play->user;

            if (!$seller->mercadopago_access_token) {
                throw new \Exception('El creador no tiene Mercado Pago conectado');
            }

            MercadoPagoConfig::setAccessToken(
                $seller->mercadopago_access_token
            );
            $client = new PreferenceClient();
            $preference = $client->create([
                'items' => [
                    [
                        'title' => $purchase->performance->play->title,
                        'quantity' => (int) $purchase->ticket_amount,
                        'unit_price' => (float) $purchase->performance->play->ticket_price + ($purchase->platform_fee_amount / $purchase->ticket_amount),
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
                'notification_url' => route('payment.webhook'),

                'auto_return' => 'approved',
            ]);

            return $preference;
        } catch (\MercadoPago\Exceptions\MPApiException $e) {
            \Log::error('Mercado Pago preference error', [
                'message' => $e->getMessage(),
                'body' => $e->getApiResponse()?->getContent(),
                'status' => $e->getApiResponse()?->getStatusCode(),
                'token_used' => substr($seller->mercadopago_access_token, 0, 20) . '***',
                'seller_id' => $seller->id,
            ]);

            throw new \RuntimeException('No se pudo crear la preferencia de pago');
        }
    }

    public function verifyWebhookSignature(Request $request): bool
    {
        $secret = config('services.mercadopago.webhook_secret');
        $xSignature = $request->header('x-signature');
        $xRequestId = $request->header('x-request-id');

        if (!$secret || !$xSignature || !$xRequestId) {
            return false;
        }

        $ts = null;
        $hash = null;

        foreach (explode(',', $xSignature) as $part) {
            $part = trim($part);
            if (str_starts_with($part, 'ts=')) {
                $ts = substr($part, 3);
            } elseif (str_starts_with($part, 'v1=')) {
                $hash = substr($part, 3);
            }
        }

        if (!$ts || !$hash) {
            return false;
        }

        $dataId = strtolower((string) ($request->query('data_id') ?? $request->query('id', '')));
        $manifest = "id:{$dataId};request-id:{$xRequestId};ts:{$ts};";
        $computedHash = hash_hmac('sha256', $manifest, $secret);

        return hash_equals($computedHash, $hash);
    }

    public function getPaymentDetails(int|string $paymentId): Payment
    {
        MercadoPagoConfig::setAccessToken(
            config('services.mercadopago.access_token')
        );

        $client = new PaymentClient();

        return $client->get((int) $paymentId);
    }
}