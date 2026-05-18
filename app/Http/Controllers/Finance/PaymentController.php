<?php

namespace App\Http\Controllers\Finance;

use Carbon\Carbon;
use Hashids\Hashids;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function createQrph(Request $request)
    {
        $baseAmount = $request->amount * 100;
        $feeRate = 0.025;
        $fee = round($baseAmount * $feeRate);

        $totalAmount = $baseAmount + $fee;

        /*
        |--------------------------------------------------------------------------
        | STEP 1: CREATE PAYMENT INTENT
        |--------------------------------------------------------------------------
        */

        $intentResponse = Http::withBasicAuth(
            config('services.paymongo.secret'),
            ''
        )->post('https://api.paymongo.com/v1/payment_intents', [
            'data' => [
                'attributes' => [
                    'amount' => $totalAmount,
                    'currency' => 'PHP',
                    'capture_type' => 'automatic',

                    'payment_method_allowed' => [
                        'qrph',
                    ],
                ]
            ]
        ]);

        $intent = $intentResponse->json();

        $intentId = $intent['data']['id'];
       

       

        /*
        |--------------------------------------------------------------------------
        | STEP 2: CREATE PAYMENT METHOD
        |--------------------------------------------------------------------------
        */

        $methodResponse = Http::withBasicAuth(
            config('services.paymongo.secret'),
            ''
        )->post('https://api.paymongo.com/v1/payment_methods', [
            'data' => [
                'attributes' => [
                    'type' => 'qrph',
                ]
            ]
        ]);

        $method = $methodResponse->json();

        $methodId = $method['data']['id'];

        /*
        |--------------------------------------------------------------------------
        | STEP 3: ATTACH PAYMENT METHOD
        |--------------------------------------------------------------------------
        */

        $attachResponse = Http::withBasicAuth(
            config('services.paymongo.secret'),
            ''
        )->post(
            "https://api.paymongo.com/v1/payment_intents/{$intentId}/attach",
            [
                'data' => [
                    'attributes' => [
                        'payment_method' => $methodId,
                    ]
                ]
            ]
        );

        $attach = $attachResponse->json();

        /*
        |--------------------------------------------------------------------------
        | GET QR / NEXT ACTION
        |--------------------------------------------------------------------------
        */

        $nextAction = $attach['data']['attributes']['next_action'] ?? null;

        $hashids = new Hashids('krad', 10);
        $id = $hashids->decode($request->code)[0] ?? null;

        Payment::create([
            'method' => 'qrph',
            'payment_intent_id' => $intentId,
            'qr_id' => $attach['data']['attributes']['next_action'] ? $attach['data']['attributes']['next_action']['code']['id'] : null,
            'expires_at' => $attach['data']['attributes']['next_action'] ?  Carbon::parse($attach['data']['attributes']['next_action']['code']['expires_at']) : null,
            'subtotal' => $request->amount,
            'fee' => $fee,
            'total' => $request->amount + $fee,
            'amount' => $totalAmount,
            'status' => 'pending',
            'tsr_id' => $id
        ]);


        return response()->json([
            'payment_intent_id' => $intentId,

            'status' =>
                $attach['data']['attributes']['status'] ?? null,

            'next_action' => $nextAction,
        ]);
    }

    public function status($id)
    {
        $response = Http::withBasicAuth(
            config('services.paymongo.secret'),
            ''
        )->get(
            "https://api.paymongo.com/v1/payment_intents/{$id}"
        );

        $data = $response->json();

        return response()->json([
            'status' =>
                $data['data']['attributes']['status']
        ]);
    }

    public function qr($id)
    {
        $response = Http::withBasicAuth(
            config('services.paymongo.secret'),
            ''
        )->get(
            "https://api.paymongo.com/v1/payment_intents/{$id}"
        );

        $data = $response->json();

        return response()->json([
           'status' => $data['data']['attributes']['status'],
           'qr' => $data['data']['attributes']['next_action']['code']['image_url'] ?? null,
           'expires_at' => $data['data']['attributes']['next_action']['code']['expires_at'] ?? null,
        ]);
    }

    public function webhook(Request $request)
    {
        $payload = $request->all();

        $eventType = $payload['data']['attributes']['type'] ?? null;

        if ($eventType === 'payment.paid') {

            $payment =
                $payload['data']['attributes']['data'];

            // update your order here
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function checkout(Request $request)
    {
        // $amount = $request->amount * 100; // centavos

        $baseAmount = $request->amount * 100;

        $feeRate = 0.025;
        $fee = round($baseAmount * $feeRate);

        $totalAmount = $baseAmount + $fee;

        $response = Http::withBasicAuth(
            config('services.paymongo.secret'),
            ''
        )->post('https://api.paymongo.com/v1/checkout_sessions', [
            'data' => [
                'attributes' => [
                    'line_items' => [
                        [
                            'name' => 'System Payment',
                            'quantity' => 1,
                            'amount' => $totalAmount,
                            'currency' => 'PHP',
                        ]
                    ],
                    'payment_method_types' => [
                        'gcash',
                        'qrph'
                    ],
                    'success_url' => route('customer.payment.success'),
                    'cancel_url' => route('customer.payment.cancel'),
                ]
            ]
        ]);

        $checkout = $response->json();
        $checkoutId = $checkout['data']['id'];

        $hashids = new Hashids('krad', 10);
        $id = $hashids->decode($request->code)[0] ?? null;

        Payment::create([
            'checkout_session_id' => $checkoutId,
            'subtotal' => $request->amount,
            'fee' => $fee,
            'total' => $request->amount + $fee,
            'amount' => $totalAmount,
            'status' => 'pending',
            'tsr_id' => $id
        ]);

      

        return response()->json([
            'checkout_url' => $checkout['data']['attributes']['checkout_url']
        ]);
    }

    public function success()
    {
        return inertia('Finance/Payment/Success');
    }

    public function cancel()
    {
        return inertia('Finance/Payment/Cancel');
    }
}
