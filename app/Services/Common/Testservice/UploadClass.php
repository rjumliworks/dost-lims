<?php

namespace App\Services\Common\Testservice;

use App\Imports\TestImport;
use App\Models\Testservice;
use App\Models\TestserviceName;
use App\Models\TestserviceMethod;
use Maatwebsite\Excel\Facades\Excel;

class UploadClass
{
    public function preview($request){
        $data =  Excel::toCollection(new TestImport,$request->import_file);
        $rows = $data[0]; 
        foreach($rows as $row){ 
            if($row[0] != 'Sample Type'){
                $information[] = [
                     '1' => $row[0],
                      '2' => $row[1],
                       '3' => ($row[2] == '') ? $row[2] : $sampletype,
                    'testname' => $row[3],
                    'code' => $row[4],
                    'method' => $row[5],
                    'reference' => $row[6],
                    'fee' => str_replace(['₱', ','], '', $row[7])
                ];
            }
            $sampletype = $row[2];
        }
        return $information;
    }

    public function save($request){

        if (empty($request->laboratory_id)) {
            return [
                'success' => [],
                'failed' => [],
                'duplicate' => [],
                'error' => 'Both laboratory_id and agency_id are required.',
            ];
        }

        ini_set('max_execution_time', 0);
        set_time_limit(0);
        $results = [
            'success' => [],
            'failed' => [],
            'duplicate' => []
        ];
        $index= 0;
        $rows = $request->lists;

        foreach ($rows as $index => $row) {
            $testName = $row['testname'];
            $methodCode = $row['code'];
            $methodName = $row['method'];
            $referenceName = $row['reference'];
            $fee = $row['fee'];

            try {
                $parameter = TestserviceName::firstOrCreate(
                    [
                        'name' => $testName,
                        'type_id' => 31,
                        'laboratory_id' => $request->laboratory_id,
                    ]
                );
        
                $method = TestserviceName::firstOrCreate(
                    [
                        'name' => $methodName,
                        'short' => $methodCode,
                        'type_id' => 28,
                        'laboratory_id' => $request->laboratory_id,
                    ]
                );

                $reference = TestserviceName::firstOrCreate([
                    'name' => $referenceName,
                    'type_id' => 29,
                    'laboratory_id' => $request->laboratory_id,
                ]);

                $methodCombo = TestserviceMethod::firstOrCreate(
    [
        'method_id' => $method->id,
        'reference_id' => $reference->id,
        'agency_id' => auth()->user()->profile->agency_id,
    ],
    [
        'laboratory_id' => $request->laboratory_id,
        'fee' => $fee,
        'added_by' => auth()->id(),
    ]
);

                // Check if this testservice already exists
                $existing = Testservice::where([
                    'testname_id' => $parameter->id,
                    'method_id' => $methodCombo->id,
                    'laboratory_id' => $request->laboratory_id
                ])->first();

                if ($existing) {
                    $results['duplicate'][] = [
                        'row' => $index + 1,
                        'data' => $row,
                    ];
                    continue;
                }

                // Create new testservice
                Testservice::create([
                    'testname_id' => $parameter->id,
                    'method_id' => $methodCombo->id,
                    'laboratory_id' => $request->laboratory_id,
                    'status_id' => 32
                ]);

                $results['success'][] = [
                    'row' => $index + 1,
                    'data' => '-',
                ];

            } catch (\Exception $e) {
                $results['failed'][] = [
                    'row' => $index + 1,
                    'data' => '-',
                    'error' => $e->getMessage(),
                ];
            }
        }
    
        return $results;
    }
}
