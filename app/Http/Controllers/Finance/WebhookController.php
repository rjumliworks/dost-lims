<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();

        $type = $payload['data']['attributes']['type'] ?? null;

        if ($type === 'checkout_session.payment.paid') {

            // 🔥 SAFE extraction (handles PayMongo variations)
            $data = $payload['data']['attributes']['data'] ?? [];

            $checkoutId =
                $data['id']
                ?? $payload['data']['id']
                ?? null;

            if (!$checkoutId) {
                return response()->json(['error' => 'No checkout id']);
            }

            $payment = Payment::where('checkout_session_id', $checkoutId)->first();

            if ($payment) {
                $paymentIntentId = $data['attributes']['payment_intent_id'] ?? $data['payment_intent_id'] ?? null;
                $method = data_get($data, 'attributes.payments.0.attributes.source.type') ?? data_get($data, 'attributes.payment_method_used') ?? null;
                $amount = data_get($data, 'attributes.payments.0.attributes.amount') ?? null;
                $amount = $amount ? ($amount / 100) : $payment->amount;

                $payment->update([
                    'status' => 'paid',
                    'payment_intent_id' => $paymentIntentId,
                    'method' => $method,
                    'payload' => json_encode($payload),
                    'paid_at' => now(), 
                ]);

                $payment->tsr->payment->update([
                    'is_paid' => 1,
                    'collection_id' => 54,
                    'payment_id' => 22,
                    'status_id' => 7,
                    'paid_at' => now(), 
                ]);
            }
        }

        return response()->json(['ok' => true]);
    }
}
