<?php

namespace App\Http\Controllers\Public;

use App\Services\MercadoPagoService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

use App\Mail\PurchaseConfirmedMail;
use App\Models\Purchase;
use App\Models\Payment;
use App\Models\Ticket;

class PaymentController extends Controller
{
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
        return view('public-area.purchase-process.payment-success');
    }

    public function failure(Request $request)
    {
        return redirect()->route('billboard')->with('error', 'Ocurrió un error con el pago. Por favor intentalo de vuelta más tarde.');
    }

    public function pending(Request $request)
    {
        return redirect()->route('billboard')->with('message', 'Pago pendiente de confirmación. En cuanto se confirme, te llegará la entrada al correo.');
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

        $ticket = null;
        \DB::transaction(function () use ($mpPayment, $purchase, &$ticket) {

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

            if ($newStatus === 'confirmed') {
                $ticket = Ticket::firstOrCreate(
                    ['purchase_id' => $purchase->id],
                    [
                        'user_id' => $purchase->user_id,
                        'guest_id' => $purchase->guest_id,
                        'performance_id' => $purchase->performance_id,
                        'ticket_code' => (string) \Illuminate\Support\Str::uuid(),
                        'status' => 'active',
                    ]
                );
            }
        });

        if ($ticket) {
            $result = Builder::create()
                ->writer(new PngWriter())
                ->data($ticket->ticket_code)
                ->size(300)
                ->build();
            $path = 'tickets/qr_' . $ticket->id . '.png';
            Storage::disk(config('filesystems.uploads_disk', 'public'))->put($path, $result->getString());

            Mail::to($purchase->user?->email ?? $purchase->guest?->email)->send(new PurchaseConfirmedMail($ticket));
        }

        return response()->noContent();
    }
}
