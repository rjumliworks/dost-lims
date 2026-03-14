<?php

namespace App\Exports;

use App\Models\Testservice;
use App\Models\SampleName;
use App\Models\SampleType;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TestServiceExport implements FromView
{
    protected $laboratory;

    function __construct($laboratory) {
        $this->laboratory = $laboratory;
    }

    public function view(): View
    {
        $lists = Testservice::where('laboratory_id',$this->laboratory)
        ->with('status')
        ->with([
            'samples.sampleable' => function ($morph) {
                $morph->morphWith([
                    SampleName::class => ['type.category'],
                    SampleType::class => ['category']
                ]);
            }
        ])
        ->with('testname','agency.member','agency.address.region','laboratory')
        ->with('method.method','method.reference')
        ->get();

        $services = [];

        foreach ($lists as $row) {

            $category = null;
            $type = null;
            $names = [];

            foreach ($row->samples as $tsSample) {

                $sample = $tsSample->sampleable;

                if ($sample instanceof SampleName) {
                    $category = $sample->type?->category?->name ?? $category;
                    $type     = $sample->type?->name ?? $type;

                    if ($sample->name) {
                        $names[] = $sample->name;
                    }

                } elseif ($sample instanceof SampleType) {

                    $category = $sample->category?->name ?? $category;
                    $type     = $sample->name ?? $type;
                }
            }

            $services[] = [
                'category'     => $category,
                'type'         => $type,
                'name'         => implode(', ', array_unique($names)), // names as comma-separated
                "testname"     => $row->testname->name ?? null,
                "method_code"  => $row->method->method->short ?? null,
                "method"       => $row->method->method->name ?? null,
                "reference"    => $row->method->reference->name ?? null,
                "fee"          => $row->method->fee ?? null,
                "status"       => $row->status->name ?? null,
                "availability" => $row->is_active
            ];
        }

        return view('exports.testservices', [
            'lists' => $services
        ]);
    }
}