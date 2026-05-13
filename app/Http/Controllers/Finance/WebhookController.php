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
            $payment->update([
                'status' => 'paid'
            ]);
        }
    }

    return response()->json(['ok' => true]);
}
}
