<?php

namespace App\Http\Controllers\Public;

use App\Services\MercadoPagoService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Purchase;
use App\Models\Payment;

class PaymentController extends Controller
{
    /**
     * Mapea el status de un pago de Mercado Pago al status de la purchase.
     * Devuelve null si el status no es reconocido (no se toca la purchase).
     */
    private const STATUS_MAP = [
        'approved' => 'confirmed',
        'pending' => 'pending',
        'in_process' => 'pending',
        'authorized' => 'pending',
        'rejected' => 'cancelled',
        'cancelled' => 'cancelled',
        'refunded' => 'cancelled',
        'charged_back' => 'cancelled',
    ];

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

    public function webhook(Request $request)
    {
        if (!$this->mercadoPagoService->verifyWebhookSignature($request)) {
            \Log::warning('Mercado Pago webhook con firma inválida', [
                'query' => $request->query(),
                'headers' => [
                    'x-signature' => $request->header('x-signature'),
                    'x-request-id' => $request->header('x-request-id'),
                ],
            ]);

            return response()->json(['error' => 'Firma inválida'], 401);
        }

        $type = $request->query('type') ?? $request->input('topic');

        if ($type !== 'payment') {
            return response()->noContent();
        }

        $paymentId = $request->query('data_id') ?? $request->query('id');

        try {
            $mpPayment = $this->mercadoPagoService->getPaymentDetails($paymentId);
        } catch (\MercadoPago\Exceptions\MPApiException $e) {
            \Log::error('Mercado Pago webhook: error al consultar el pago', [
                'payment_id' => $paymentId,
                'message' => $e->getMessage(),
            ]);

            return response()->json(['error' => 'No se pudo consultar el pago'], 502);
        }

        $purchase = Purchase::find($mpPayment->external_reference);

        if (!$purchase) {
            \Log::warning('Mercado Pago webhook: purchase no encontrada', [
                'payment_id' => $mpPayment->id,
                'external_reference' => $mpPayment->external_reference,
            ]);

            return response()->noContent();
        }

        \DB::transaction(function () use ($mpPayment, $purchase) {
            Payment::updateOrCreate(
                [
                    'provider' => 'mercadopago',
                    'external_id' => $mpPayment->id,
                ],
                [
                    'purchase_id' => $purchase->id,
                    'status' => $mpPayment->status,
                    'amount' => $mpPayment->transaction_amount,
                    'metadata' => [
                        'status_detail' => $mpPayment->status_detail,
                        'payment_method_id' => $mpPayment->payment_method_id,
                        'payment_type_id' => $mpPayment->payment_type_id,
                    ],
                ]
            );

            $newStatus = self::STATUS_MAP[$mpPayment->status] ?? null;

            if ($newStatus && $purchase->status !== $newStatus) {
                $purchase->update(['status' => $newStatus]);
            }
        });

        return response()->noContent();
    }
}
