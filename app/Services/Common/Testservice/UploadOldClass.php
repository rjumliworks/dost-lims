namespace App\Services\Common\Testservice;

use App\Imports\TestImport;
use App\Models\Testservice;
use App\Models\TestserviceName;
use App\Models\TestserviceList;
use App\Models\TestserviceMethod;
use App\Models\SampleType;
use App\Models\SampleName;
use Maatwebsite\Excel\Facades\Excel;

class UploadOldClass
{
    public function preview($request){
        $data =  Excel::toCollection(new TestImport,$request->import_file);
        $rows = $data[0]; 
        foreach($rows as $row){ 
            // if($row[0] != 'Sample Type'){
            //     $information[] = [
            //         'types' => explode(', ', $row[2]),
            //         'testname' => $row[3],
            //         'code' => $row[4],
            //         'method' => $row[5],
            //         'reference' => $row[6],
            //         'fee' => str_replace(['₱', ','], '', $row[7])
            //     ];
            // }

            if($row[2] != 'Testname'){
                $information[] = [
                    'old_id' => $row[0],
                    'testname' => $row[2],
                    'code' => $row[3],
                    'method' => $row[4],
                    'reference' => $row[5],
                    'fee' => str_replace(['₱', ','], '', $row[6])
                ];
            }
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
            'duplicate' => [],
            'unknown' => []
        ];
        $index= 0;
        $rows = $request->lists;

        foreach ($rows as $index => $row) {
            $oldId = $row['old_id'];
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
                        'agency_id' => auth()->user()->profile->agency_id
                    ],[
                        'laboratory_id' => $request->laboratory_id,
                    ]
                );
        
                $method = TestserviceName::firstOrCreate(
                    [
                        'name' => $methodName,
                        'type_id' => 28,
                        'agency_id' => auth()->user()->profile->agency_id
                    ],[
                        'short' => $methodCode,
                        'laboratory_id' => $request->laboratory_id,
                    ]
                );

                $reference = TestserviceName::firstOrCreate([
                    'name' => $referenceName,
                    'type_id' => 29,
                    'agency_id' => auth()->user()->profile->agency_id
                ],[
                    'laboratory_id' => $request->laboratory_id,
                ]);

                $methodCombo = TestserviceMethod::firstOrCreate(
                    [
                        'method_id' => $method->id,
                        'reference_id' => $reference->id,
                        'agency_id' => auth()->user()->profile->agency_id,
                        'fee' => $fee,
                    ],
                    [
                        'laboratory_id' => $request->laboratory_id,
                        'added_by' => auth()->id(),
                    ]
                );

                // Check if this testservice already exists
                // $existing = Testservice::where([
                //     'testname_id' => $parameter->id,
                //     'method_id' => $methodCombo->id,
                //     'laboratory_id' => $request->laboratory_id
                // ])->first();

                // if ($existing) {
                //     foreach ($row['types'] as $name) {
                //         $sampleRecord = SampleName::where('name', $name)->first();

                //         if ($sampleRecord) {
                //             // Laravel automatically sets sampleable_id and sampleable_type here
                //             $sampleRecord->services()->create([
                //                 'testservice_id' => $existing->id
                //             ]);
                //         }else{
                //             $results['unknown'][] = $name;
                //         }
                //     }
                //     $results['duplicate'][] = [
                //         'row' => $index + 1,
                //         'data' => $row,
                //     ];
                //     continue;
                // }
                //Add old services
                $service = Testservice::FirstOrCreate([
                    'testname_id' => $parameter->id,
                    'method_id' => $methodCombo->id,
                    'agency_id' => auth()->user()->profile->agency_id,
                ],[
                    'is_new' => 0,
                    'is_active' => 0,
                    'laboratory_id' => $request->laboratory_id,
                    'old_id' => $oldId,
                    'status_id' => 33
                ]);
                if($service){
                    TestserviceList::create([
                        'old_id' => $oldId,
                        'testservice_id' => $service->id
                    ]);
                }

                // Create new testservice
                // $service = Testservice::create([
                //     'testname_id' => $parameter->id,
                //     'method_id' => $methodCombo->id,
                //     'laboratory_id' => $request->laboratory_id,
                //     'status_id' => 32
                // ]);
                // if($service){
                //     foreach ($row['types'] as $name) {
                //         $sampleRecord = SampleName::where('name', $name)->first();

                //         if ($sampleRecord) {
                //             // Laravel automatically sets sampleable_id and sampleable_type here
                //             $sampleRecord->services()->create([
                //                 'testservice_id' => $service->id
                //             ]);
                //         }else{
                //             $results['unknown'][] = $name;
                //         }
                //     }
                // }

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