<?php

namespace App\Http\Controllers\Finance;

use Carbon\Carbon;
use Hashids\Hashids;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Tsr;
use App\Models\Payment;
use App\Http\Resources\Public\Customer\TsrResource;

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

        if($data['data']['attributes']['status'] == 'succeeded'){
            $date = $data['data']['attributes']['payments'][0]['attributes']['paid_at'];
            $payment = Payment::where('payment_intent_id', $id)->first();
            $payment->update([
                'status' => 'paid',
                'reference' => $data['data']['attributes']['payments'][0]['id'],
                'paid_at' => Carbon::createFromTimestamp($date),
            ]);
            $payment->tsr->payment->update([
                'is_paid' => 1,
                'collection_id' => 54,
                'payment_id' => 22,
                'status_id' => 7,
                'paid_at' => Carbon::createFromTimestamp($date),
            ]);
            $payment->tsr->update([
                'status_id' => 3,
            ]);

            $tsr = Tsr::with('payment.status','onlinepayment','status','samples.report.signatory','samples.samplename','samples.analyses')
            ->withCount([
                'samples as total_report_count' => function ($query) {
                    $query->select(\DB::raw('COUNT(DISTINCT tsr_sample_reports.code)'))
                        ->join('tsr_sample_reports', 'tsr_sample_reports.sample_id', '=', 'tsr_samples.id');
                },
                'samples as completed_report_count' => function ($query) {
                    $query->select(\DB::raw('COUNT(DISTINCT tsr_sample_reports.code)'))
                        ->join('tsr_sample_reports', 'tsr_sample_reports.sample_id', '=', 'tsr_samples.id')
                        ->join('tsr_sample_report_signatories', 'tsr_sample_report_signatories.report_id', '=', 'tsr_sample_reports.id')
                        ->where('tsr_sample_report_signatories.status_id', 42);
                }
            ])
            ->where('id',$payment->tsr_id)
            ->first();
        }else{
            $tsr = null;
        }

        return response()->json([
            'status' => $data['data']['attributes']['status'],
            'tsr' => $tsr
        ]);
    }

    public function payments($id)
    {
        $response = Http::withBasicAuth(
            config('services.paymongo.secret'),
            ''
        )->get(
            "https://api.paymongo.com/v1/payment_intents/{$id}"
        );

        $data = $response->json();

        return response()->json([
            'data' => $data
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
        $date = $data['data']['attributes']['payments'][0]['attributes']['paid_at'];
        if($data['data']['attributes']['status'] == 'succeeded'){
            $payment = Payment::where('payment_intent_id', $id)->first();
            $payment->update([
                'status' => 'paid',
                'paid_at' => Carbon::createFromTimestamp($date),
            ]);
            $payment->tsr->payment->update([
                'is_paid' => 1,
                'collection_id' => 54,
                'payment_id' => 22,
                'status_id' => 7,
                'paid_at' => Carbon::createFromTimestamp($date),
            ]);
            $payment->tsr->update([
                'status_id' => 3,
            ]);
        }

        return response()->json([
            'data' => $data['data'],
           'status' => $data['data']['attributes']['status'],
           'qr' => $data['data']['attributes']['next_action']['code']['image_url'] ?? null,
           'expires_at' => $data['data']['attributes']['next_action']['code']['expires_at'] ?? null,
        ]);
    }

    public function update($status,$id){

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
