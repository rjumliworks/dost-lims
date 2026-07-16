<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Services\EgovPayService;


class EgovPayController extends Controller
{
    public function pay1(EgovPayService $egovPay){
      
        $txnid = 'TESTREF123';
        $amount = '1000';
        $digest = $egovPay->generateDigest($txnid, $amount);
        $response = $egovPay->createTransaction([
            'txnid' => 'TESTREF123',
            'amount' => '1000',
            'items' => [
                [
                    'name' => 'Item #1',
                    'amount' => '1000',
                ],
            ],
            'callback_url' => route('customer.egovpay.callback'),
            'digest' => $digest,
            'expires_at' => '2027-07-14 23:59:59',
            'link_expires_at' => '2027-07-14 23:59:59',
            'name' => 'TEST',
            'mobile' => '09XXXXXXXXX',
            'email' => 'your@email.com',
        ]);
        if ($response['success']) {
    return response()->json([
        'url' => $response['data']['data']['url']
    ]);
}

return response()->json([
    'message' => 'Unable to create payment.'
], 422);
    }

     public function pay(EgovPayService $egovPay, Request $request)
    {
        $txnid = $request->txn_id;
        $amount = $request->total;
        
        $payment = Payment::where('tsr_id',$request->tsr_id)->first();
        if($payment){
            return response()->json([
                'uuid' => $payment->uuid
            ]);
        }else{
            $digest = $egovPay->generateDigest($txnid, $amount);
            $response = $egovPay->createTransaction([
                'txnid' => $request->txn_id,
                'amount' => $request->total,
                'items' => [
                    [
                        'name' => 'Item #1',
                        'amount' => $request->total,
                    ],
                ],
                'callback_url' => route('customer.egovpay.callback'),
                'digest' => $digest,
                'expires_at' => '2027-07-14 23:59:59',
                'link_expires_at' => '2027-07-14 23:59:59',
                'name' => 'TEST',
                'mobile' => '09XXXXXXXXX',
                'email' => 'your@email.com',
            ]);
            $fee = 0;
            Payment::create([
                'method' => 'qrph',
                'uuid' => $response['data']['data']['uuid'],
                'refno' => $response['data']['data']['channel']['refno'],
                'txnid' => $request->txn_id,
                'subtotal' => $request->total,
                'fee' => $fee,
                'total' => $request->total + $fee,
                'amount' => $request->total + $fee,
                'status' => 'pending',
                'tsr_id' => $request->tsr_id
            ]);

            if ($response['success']) {
                return response()->json([
                    'uuid' => $response['data']['data']['uuid']
                ]);
            }

            return response()->json([
                'message' => 'Unable to create payment.'
            ], 422);
        }
    }

    public function qr(EgovPayService $egovPay, string $transactionUuid){
        $response = $egovPay->generateLandbankQr(
            'a223537e-e39e-4040-8704-6de81c0b6ad3',
            $transactionUuid
        );

           return response()->json([
                    'qr' => $response['data']['qr_url']
                ]);
    }

    public function callback(Request $request)
    {
        \Log::info('eGovPay Callback', $request->all());

        // Verify and update payment status

        return response()->json([
            'success' => true,
        ]);
    }

     public function success()
    {
        return view('payments.success');
    }

    public function failed()
    {
        return view('payments.failed');
    }
}
