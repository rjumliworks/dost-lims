<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        $amount = $request->amount * 100; // centavos

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
                            'amount' => $amount,
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

        Payment::create([
            'checkout_session_id' => $checkoutId,
            'amount' => $amount,
            'status' => 'pending'
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
