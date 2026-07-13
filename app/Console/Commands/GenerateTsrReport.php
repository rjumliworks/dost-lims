<?php

namespace App\Console\Commands;

use App\Models\Tsr;
use App\Models\TsrSample;
use App\Models\TsrReport;
use Illuminate\Console\Command;

class GenerateTsrReport extends Command
{
    protected $signature = 'report {id}';
    protected $description = 'Command description';

    public function handle()
    {
        $id = $this->argument('id');

        if ($id) {
            $this->generate($id);
            $this->info("TSR {$id} generated.");
            return Command::SUCCESS;
        }

        // Generate all TSRs
        Tsr::chunk(100, function ($tsrs) {
            foreach ($tsrs as $tsr) {
                $this->generate($tsr->id);
                $this->line("Generated TSR {$tsr->id}");
            }
        });

        $this->info('All TSR reports generated.');

        return Command::SUCCESS;
    }

    private function generate($id)
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
            $this->error("TSR {$id} not found.");
            return;
        }

        $samples = TsrSample::with(
            'samplename',
            'sampletype',
            'analyses.testservice.method.method',
            'analyses.testservice.testname',
            'analyses.addfee.service'
        )
            ->where('tsr_id', $id)
            ->get();

        $groupedData = [];

        foreach ($samples as $row) {

            $sampleCode = $row->code;
            $sampleOther = $row->name;
            $sampleName = $row->samplename->name;
            $sampleType = $row->sampletype->name;

            foreach ($row->analyses as $index => $analysis) {

                $testName = $analysis->testservice->testname->name;
                $testMethod = $analysis->testservice->method->method->name;
                $testMethodShort = $analysis->testservice->method->method->short;

                $key = "{$sampleCode}_{$testName}_{$testMethod}";

                if (!isset($groupedData[$key])) {

                    $fees = null;

                    if ($analysis->addfee->count()) {
                        foreach ($analysis->addfee as $item) {
                            $fees[] = [
                                'name' => $item->service->name,
                                'fee' => $item->service->fee,
                                'quantity' => $item->quantity,
                                'total' => $analysis->total,
                            ];
                        }
                    }

                    $groupedData[$key] = [
                        'samplecode' => $index == 0 ? $sampleCode : '',
                        'samplename' => $index == 0 ? $sampleName : '-',
                        'sampletype' => $index == 0 ? $sampleType : '-',
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

        $descs = TsrSample::where('tsr_id', $id)->get();

        $address = $tsr->customer->address;

        $d = !empty($address->address) ? $address->address . ', ' : '';

        if (in_array($address->municipality->name, ['Zamboanga City', 'Isabela City'])) {
            $a = $address->municipality->name;
        } elseif ($address->municipality->name == 'Iloilo City') {
            $a = $address->district->name . ', ' . $address->municipality->name;
        } elseif ($address->province->name == 'Sulu') {
            $a = $address->municipality->name . ', ' . $address->province->name;
        } else {
            $a = $address->municipality->name . ', ' . $address->province->name;
        }

        $information = [
            'code' => $tsr->code,
            'services' => $services,
            'date' => $tsr->created_at,
            'laboratory_id' => $tsr->laboratory_id,
            'due_at' => $tsr->due_at,
            'receiver' => $tsr->received->profile->firstname . ' ' .
                substr($tsr->received->profile->middlename, 0, 1) . '. ' .
                $tsr->received->profile->lastname,
            'customer' => [
                'name' => $tsr->customer->is_main
                    ? $tsr->customer->customer_name->name
                    : $tsr->customer->customer_name->name . ' - ' . $tsr->customer->name,
                'address1' => $d . $address->barangay->name . ', ' . $a,
                'address2' => $address->barangay->name . ', ' . $a,
                'contact_no' => $tsr->customer->contact->contact_no,
                'email' => $tsr->customer->contact->email,
                'conforme' => [
                    'name' => $tsr->conforme->name,
                    'contact_no' => $tsr->conforme->contact_no,
                ],
            ],
            'payment' => [
                'subtotal' => $tsr->payment->subtotal,
                'discount' => $tsr->payment->discount,
                'total' => $tsr->payment->total,
                'discounted' => optional($tsr->payment->discounted)->name,
            ],
            'samples' => array_values($groupedData),
            'descriptions' => $descs,
        ];

        TsrReport::updateOrCreate(
            ['tsr_id' => $id],
            [
                'information' => json_encode($information),
                'secret_key' => TsrReport::where('tsr_id', $id)->value('secret_key') ?? $this->generatePasskey(),
            ]
        );
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
