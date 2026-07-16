<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class EgovPayService
{
    protected Client $client;
    protected string $token;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://pgi-ws.egovpay.gov.ph/api/v1/',
            'timeout'  => 30,
        ]);

        $this->token = config('services.egovpay.token');
    }

    public function createTransaction(array $data): array
    {
        try {
            $response = $this->client->post('transaction', [
                'headers' => [
                    'X-eGovPay-Token' => 'test_'.$this->token,
                    'Content-Type' => 'application/json; charset=utf-8',
                ],
                'json' => $data,
            ]);

            return [
                'success' => true,
                'status'  => $response->getStatusCode(),
                'data'    => json_decode($response->getBody()->getContents(), true),
            ];
        } catch (RequestException $e) {
            return [
                'success' => false,
                'status'  => optional($e->getResponse())->getStatusCode(),
                'message' => $e->getMessage(),
                'data'    => $e->hasResponse()
                    ? json_decode($e->getResponse()->getBody()->getContents(), true)
                    : null,
            ];
        }
    }

    public function generateDigest(string $txnid, string|float $amount): string
    {
       
        return hash_hmac(
            'sha256',
            "{$amount}|{$txnid}",
            config('services.egovpay.token')
        );
    }

    public function generateLandbankQr(
        string $merchantPaymentChannelUuid,
        string $transactionUuid
    ): array {

        try {
            $response = $this->client->request('POST', 'https://pgi-ws.egovpay.gov.ph/channels/landbank-qr', [
                'multipart' => [
                    [
                        'name' => 'merchant_payment_channel_uuid',
                        'contents' => $merchantPaymentChannelUuid,
                    ],
                    [
                        'name' => 'transaction_uuid',
                        'contents' => $transactionUuid,
                    ],
                ],
            ]);
            return [
                'success' => true,
                'status'  => $response->getStatusCode(),
                'data'    => json_decode($response->getBody()->getContents(), true),
            ];
        } catch (RequestException $e) {
            return [
                'success' => false,
                'status'  => optional($e->getResponse())->getStatusCode(),
                'message' => $e->getMessage(),
                'data'    => $e->hasResponse()
                    ? json_decode($e->getResponse()->getBody()->getContents(), true)
                    : null,
            ];
        }
    }

}

// https://pgi-ws.egovpay.gov.ph/channels/lb/transaction/

// c4d78d4011451ab4644fbb9a85f25af95e0b242c483316b3dc66632bd98e45b9