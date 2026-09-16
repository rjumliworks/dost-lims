<?php

namespace App\Services\Major\Tsr;

use App\Models\Tsr;
use App\Models\TsrSample;
use App\Models\TsrReport;

class ReportGenerateClass
{
    public function generate($id): bool
    {
        $tsr = Tsr::where('id', $id)
            ->with('services.service')
            ->with('received:id', 'received.profile:id,firstname,middlename,lastname,user_id')
            ->with('agency', 'laboratory:id,name', 'status:id,name,color,others')
            ->with('customer:id,name_id,name,is_main')
            ->with('customer.customer_name:id,name,has_branches')
            ->with('customer.wallet')
            ->with(
                'customer.address:address,customer_id,region_code,province_code,district_code,municipality_code,barangay_code',
                'customer.address.region:code,name,region',
                'customer.address.province:code,name',
                'customer.address.municipality:code,name',
                'customer.address.barangay:code,name',
                'customer.address.district:code,name'
            )
            ->with('conforme:id,name,contact_no')
            ->with('customer.contact:id,email,contact_no,customer_id')
            ->with(
                'payment:tsr_id,id,total,subtotal,discount,or_number,is_paid,is_free,paid_at,status_id,discount_id,collection_id,payment_id',
                'payment.status:id,name,color,others',
                'payment.collection:id,name',
                'payment.type:id,name',
                'payment.discounted:id,name,value'
            )
            ->first();

        if (!$tsr) {
            return false;
        }

        $samples = TsrSample::with(
            'samplename',
            'sampletype',
            'analyses.status',
            'analyses.testservice.method.method',
            'analyses.testservice.testname',
            'analyses.addfee.service'
        )
            ->where('tsr_id', $id)
            ->get();

        $groupedData = [];
        $groupedRefunded = [];

        foreach ($samples as $row) {

            $sampleCode = $row->code;
            $sampleOther = $row->name;
            $sampleName = $row->samplename->name ?? null;
            $sampleType = $row->sampletype->name ?? null;

            $activeIndex = 0;
            $refundedIndex = 0;

            foreach ($row->analyses as $index => $analysis) {

                $fees = null;

                if ($analysis->addfee->count()) {
                    foreach ($analysis->addfee as $item) {
                        $fees[] = [
                            'name' => $item->service->name ?? null,
                            'fee' => $item->service->fee ?? null,
                            'quantity' => $item->quantity,
                            'total' => $analysis->total,
                        ];
                    }
                }

                $testName = $analysis->testservice->testname->name ?? null;
                $testMethod = $analysis->testservice->method->method->name ?? null;
                $testMethodShort = $analysis->testservice->method->method->short ?? null;

                $key = "{$sampleCode}_{$testName}_{$testMethod}";

                if (($analysis->status->name ?? null) === 'Refunded') {

                    if (!isset($groupedRefunded[$key])) {

                        $groupedRefunded[$key] = [
                            'samplecode' => $refundedIndex == 0 ? $sampleCode : '',
                            'samplename' => $refundedIndex == 0 ? $sampleName : '-',
                            'sampletype' => $refundedIndex == 0 ? $sampleType : '-',
                            'sampleother' => $sampleOther,
                            'testname' => $testName,
                            'method' => $testMethod,
                            'methodShort' => $testMethodShort,
                            'count' => 0,
                            'fee' => $analysis->fee,
                            'additional' => $fees,
                        ];
                    }

                    $groupedRefunded[$key]['count']++;
                    $refundedIndex++;

                } else {

                    if (!isset($groupedData[$key])) {

                        $groupedData[$key] = [
                            'samplecode' => $activeIndex == 0 ? $sampleCode : '',
                            'samplename' => $activeIndex == 0 ? $sampleName : '-',
                            'sampletype' => $activeIndex == 0 ? $sampleType : '-',
                            'sampleother' => $sampleOther,
                            'testname' => $testName,
                            'method' => $testMethod,
                            'methodShort' => $testMethodShort,
                            'count' => 0,
                            'fee' => $analysis->fee,
                            'additional' => $fees,
                        ];
                    }

                    $groupedData[$key]['count']++;
                    $activeIndex++;
                }
            }
        }

        $services = null;

        if ($tsr->services->count()) {
            foreach ($tsr->services as $item) {
                $services[] = [
                    'name' => $item->service->name ?? null,
                    'description' => $item->service->description ?? null,
                    'quantity' => $item->quantity,
                    'fee' => $item->fee,
                    'total' => $item->total,
                ];
            }
        }

        $samples = array_values($groupedData);
        $refunded = array_values($groupedRefunded);

        $descs = TsrSample::where('tsr_id', $id)->get();

        $address = $tsr->customer->address;

        $addressParts = [
            'street' => $address->address ?? null,
            'barangay' => $address->barangay->name ?? null,
            'municipality' => $address->municipality->name ?? null,
            'district' => $address->district->name ?? null,
            'province' => $address->province->name ?? null,
            'region' => $address->region->name ?? null,
        ];

        $information = [
            'code' => $tsr->code,
            'services' => $services,
            'date' => $tsr->created_at,
            'laboratory_id' => $tsr->laboratory_id,
            'due_at' => $tsr->due_at,
            'receiver' => ($tsr->received->profile->firstname ?? '') . ' ' .
                substr($tsr->received->profile->middlename ?? '', 0, 1) . '. ' .
                ($tsr->received->profile->lastname ?? ''),
            'customer' => [
                'name' => $tsr->customer->is_main
                    ? ($tsr->customer->customer_name->name ?? null)
                    : ($tsr->customer->customer_name->name ?? null) . ' - ' . $tsr->customer->name,
                'address_parts' => $addressParts,
                'contact_no' => $tsr->customer->contact->contact_no ?? null,
                'email' => $tsr->customer->contact->email ?? null,
                'conforme' => [
                    'name' => $tsr->conforme->name ?? null,
                    'contact_no' => $tsr->conforme->contact_no ?? null,
                ],
            ],
            'payment' => [
                'subtotal' => $tsr->payment->subtotal,
                'discount' => $tsr->payment->discount,
                'total' => $tsr->payment->total,
                'discounted' => optional($tsr->payment->discounted)->name,
            ],
            'samples' => $samples,
            'refunded' => $refunded,
            'descriptions' => $descs,
        ];

        TsrReport::updateOrCreate(
            ['tsr_id' => $id],
            [
                'information' => json_encode($information),
                'secret_key' => TsrReport::where('tsr_id', $id)->value('secret_key') ?? $this->generatePasskey(),
            ]
        );

        return true;
    }

    private function generatePasskey($length = 8)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $passkey = '';

        for ($i = 0; $i < $length; $i++) {
            $passkey .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $passkey;
    }
}
