<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use App\Models\AgencyFacility;
use App\Models\Tsr;
use App\Models\TsrSampleReport;
use App\Models\User;
use App\Models\Customer;
use App\Models\CustomerConforme;
use App\Models\TestserviceList;
use App\Models\TestserviceAddon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateTsrs extends Command
{
    protected $signature = 'migrate:tsrs';
    protected $description = 'Migrate old LIMS data';
    
    public function handle()
    {
        $this->info('Starting migration...');

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $tables = [
            'tsr_analyses',
            'tsr_samples',
            'tsr_remarks',
            'tsr_sample_reports',
            'tsr_sample_disposals',
            'tsr_sample_report_lists',
            'tsr_sample_report_signatories',
            'tsr_payments',
            'tsr_payment_deductions',
            'tsr_releases',
            'tsr_referrals',
            'tsr_services',
            'tsr_reports',
            'tsrs',
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
            $this->info("Truncated {$table}");
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $tsrMap = [];
        $sampleMap = [];

        DB::connection('old_db')
        ->table('tsrs as t')
        ->where('t.agency_id', 11)
        ->where('code','!=', null)
        ->whereIn('t.status_id', [2,3,4])
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('tsr_payments as p')
                ->whereRaw('p.tsr_id = t.id')
                ->where('p.is_child', 1);
        })
        // ->whereYear('t.created_at',2026)
        ->orderBy('t.id')
        ->chunk(200, function ($tsrs) use (&$tsrMap, &$sampleMap) {

            foreach ($tsrs as $tsr) {

                DB::beginTransaction();

                try {

                    /*
                    |--------------------------------------------------------------------------
                    | TSR
                    |--------------------------------------------------------------------------
                    */

                    $conforme = DB::connection('old_db')
                        ->table('customer_conformes')
                        ->where('id', $tsr->conforme_id)
                        ->first();

                    if($conforme){
                         $conforme_new = DB::table('customer_conformes')
                        ->where('old_id', $tsr->conforme_id)
                        ->first();
                        if($conforme_new){
                            $newConformeId = $conforme_new->id;
                        }else{
                            $hash_name = hash('sha256', Crypt::decryptString($conforme->name));
                            $check = CustomerConforme::where('name_hash',$hash_name)->first();
                            if($check){
                                $newConformeId = $check->id;
                            }else{
                                $newConformeId = DB::table('customer_conformes')->insertGetId([
                                    'customer_id' => Customer::where('old_id', $tsr->customer_id)->value('id'),
                                    'old_id' => $tsr->conforme_id,
                                    'name' => $conforme->name ?: 'None',
                                    'name_hash' => $hash_name,
                                    'contact_no' => $conforme->contact_no,
                                    'created_at' => $conforme->created_at,
                                    'updated_at' => $conforme->updated_at
                                ]);
                            }
                            
                        }
                    }
                    $customerId = Customer::where('old_id', $tsr->customer_id)->value('id');
                    $customer = Customer::find($customerId);

                    $hasAnyTsr = Tsr::where('customer_id', $customerId)->exists();
                    $hasRecentTsr = Tsr::where('customer_id', $customerId)
                    ->where('created_at', '>=', Carbon::now()->subYears(2))
                    ->exists();

                    $is_first = 0;
                    $is_new = $customer->is_new;
                    if ($customer->is_new == 0) {
                        $is_first = 0;
                        $is_new = 0;
                    } else {

                        if (!$hasAnyTsr) {
                            $is_first = 1;
                            $is_new = 1;
                        } elseif (!$hasRecentTsr) {
                            $is_first = 1;
                            $is_new = 1;
                        } else {
                            $is_first = 0;
                            $is_new = 0;
                        }
                    }

                    $customer->update([
                        'is_new' => $is_new
                    ]);

                    $newTsrId = DB::table('tsrs')->insertGetId([
                        'code' => $tsr->code,
                        'old_id' => $tsr->id,
                        'agency_id' => 11,
                        'laboratory_id' => $tsr->laboratory_id,
                        'purpose_id' => $tsr->purpose_id ?? 1,
                        'status_id' => $tsr->status_id,
                        'facility_id' => AgencyFacility::where('old_id', $tsr->facility_id)->value('id'),
                        'customer_id' => Customer::where('old_id', $tsr->customer_id)->value('id') ?? 30,
                        'conforme_id' => $newConformeId,
                        'received_by' => User::where('old_id', $tsr->received_by)->value('id') ?? 30,
                        'release_id' => 16, //
                        'is_referral' => $tsr->is_referral,
                        'is_first' => $is_first,
                        'is_onsite' => $tsr->is_onsite,
                        'due_at' => $tsr->due_at,
                        'created_at' => $tsr->created_at,
                        'updated_at' => $tsr->updated_at
                    ]);

                    $tsrMap[$tsr->id] = $newTsrId;


                    $remark = DB::connection('old_db')
                        ->table('tsr_remarks')
                        ->where('remarkable_type', 'App\Models\Tsr')->where('remarkable_id', $tsr->id)
                        ->first();
                        if($remark){
                            DB::table('tsr_remarks')->insert([
                                'amount'=> $remark->amount,
                                'reason'=> $remark->reason,
                                'type_id' => $remark->type_id,
                                'user_id'=> User::where('old_id', $remark->user_id)->value('id') ?? 30,
                                'remarkable_id'=> $newTsrId,
                                'remarkable_type'=> 'App\Models\Tsr',
                                'created_at'=> $remark->created_at,
                                'updated_at'=> $remark->updated_at
                            ]);
                        }
                    

                    /*
                    |--------------------------------------------------------------------------
                    | SAMPLES
                    |--------------------------------------------------------------------------
                    */

                    $samples = DB::connection('old_db')
                    ->table('tsr_samples')
                    ->where('tsr_id',$tsr->id)
                    ->get();
                    $parts = explode('-', $tsr->code);       // ["R9", "032026", "CHE", "0112"]
                    $numberBlock = $parts[1] ?? '';          // "032026"
                    $year = substr($numberBlock, -4); 
                    foreach ($samples as $sample) {

                        // Old sample codes aren't guaranteed unique across TSRs (the old system
                        // reused the same running number for different requests in the same year),
                        // but the new schema enforces a unique code. Disambiguate on collision.
                        $baseSampleCode = $sample->code.'-'.$year.'R9';
                        $sampleCode = $baseSampleCode;
                        $dupCount = 1;
                        while (DB::table('tsr_samples')->where('code', $sampleCode)->exists()) {
                            $dupCount++;
                            $sampleCode = $baseSampleCode.'-'.$dupCount;
                        }

                        $newSampleId = DB::table('tsr_samples')->insertGetId([

                            'code'=>$sampleCode,
                            'name'=>$sample->name,
                            'customer_description'=>$sample->customer_description,
                            'description'=>$sample->description,
                            'is_completed'=>$sample->is_completed,
                            'is_disposed'=>$sample->is_disposed,
                            'samplename_id' => 1,
                            'sampletype_id' => 1,
                            'category_id' => 1,
                            'tsr_id'=>$newTsrId,
                            'completed_at'=>$sample->completed_at,
                            'created_at'=>$sample->created_at,
                            'updated_at'=>$sample->updated_at

                        ]);

                        $sampleMap[$sample->id] = $newSampleId;

                        /*
                        |--------------------------------------------------------------------------
                        | ANALYSES
                        |--------------------------------------------------------------------------
                        */

                        $analyses = DB::connection('old_db')
                        ->table('tsr_analyses')
                        ->where('sample_id',$sample->id)
                        ->get();

                        foreach ($analyses as $analysis) {

                            $testserviceId = DB::table('testservices')->where('old_id', $analysis->testservice_id)->value('id')
                                ?? TestserviceList::where('old_id', $analysis->testservice_id)->value('testservice_id');

                            if (! $testserviceId) {
                                $this->warn("Missing Testservice for old_id {$analysis->testservice_id} sample_id {$sample->id}");
                                continue;
                            }

                            $newAnalysisId = DB::table('tsr_analyses')->insertGetId([

                                'fee'=>$analysis->fee,
                                'status_id'=>$analysis->status_id,
                                'testservice_id'=> $testserviceId,
                                'sample_id'=>$newSampleId,
                                'started_by'=> User::where('old_id', $analysis->analyst_id)->value('id') ?? 30,
                                'start_at'=>$analysis->start_at,
                                'ended_by'=> User::where('old_id', $analysis->analyst_id)->value('id') ?? 30,
                                'end_at'=>$analysis->end_at,
                                'created_at'=>$analysis->created_at,
                                'updated_at'=>$analysis->updated_at

                            ]);

                            $remark = DB::connection('old_db')
                                ->table('tsr_remarks')
                                ->where('remarkable_type', 'App\Models\TsrAnalysis')->where('remarkable_id', $analysis->id)
                                ->first();
                            if($remark){
                                DB::table('tsr_remarks')->insert([
                                    'amount'=> $remark->amount,
                                    'reason'=> $remark->reason,
                                    'type_id' => $remark->type_id,
                                    'user_id'=> User::where('old_id', $remark->user_id)->value('id') ?? 30,
                                    'remarkable_id'=> $newAnalysisId,
                                    'remarkable_type'=> 'App\Models\TsrAnalysis',
                                    'created_at'=> $remark->created_at,
                                    'updated_at'=> $remark->updated_at
                                ]);
                            }
                        }

                        $disposal = DB::connection('old_db')
                        ->table('tsr_sample_disposals')
                        ->where('sample_id',$sample->id)
                        ->get();

                        if($disposal->count() > 0){

                            $disposal = $disposal->first();

                            DB::table('tsr_sample_disposals')->insert([
                                'user_id'=> User::where('old_id', $disposal->user_id)->value('id') ?? 30,
                                'disposal_id'=>$disposal->disposal_id,
                                'sample_id'=>$newSampleId,
                                'status_id'=>$disposal->status_id,
                                'disposed_at'=>$disposal->disposed_at,
                                'created_at'=>$disposal->created_at,
                                'updated_at'=>$disposal->updated_at

                            ]);

                        }

                        $report = DB::connection('old_db')
                            ->table('tsr_sample_reports')
                            ->where('sample_id',$sample->id)
                            ->first();

                        if($report){
                            $newReportId = DB::table('tsr_sample_reports')->insertGetId([
                                'old_id' => $report->id,
                                'code' => $report->code,
                                'passkey' => $report->passkey,
                                'information' => $report->information,
                                'attachment' => $report->attachment,
                                'user_id' => User::where('old_id', $report->user_id)->value('id') ?? 30,
                                'tm_id' => $report->tm_id,
                                'tsr_id' => $newTsrId,
                                'created_at' => $report->created_at,
                                'updated_at' => $report->updated_at
                            ]);

                            DB::table('tsr_sample_report_lists')->insert([
                                'report_id' => $newReportId,
                                'sample_id' => $newSampleId,
                                'created_at' => $report->created_at,
                                'updated_at' => $report->updated_at
                            ]);

                            DB::table('tsr_sample_report_signatories')->insert([
                                'report_id' => $newReportId,
                                'status_id' => 38,
                                'approved_by' => 3,
                                'created_at' => $report->created_at,
                                'updated_at' => $report->updated_at
                            ]);
                        }

                         $report1 = DB::connection('old_db')
                            ->table('tsr_sample_report_lists')
                            ->where('sample_id',$sample->id)
                            ->first();

                        if($report1){
                            DB::table('tsr_sample_report_lists')->insert([
                                'report_id' => TsrSampleReport::where('old_id', $report1->report_id)->value('id'),
                                'sample_id' => $newSampleId,
                                'created_at' => $report1->created_at,
                                'updated_at' => $report1->updated_at
                            ]);
                        }

                       

                        // $reports = DB::connection('old_db')
                        //     ->table('tsr_sample_reports')
                        //     ->where('sample_id',$sample->id)
                        //     ->get();

                        // if ($reports->count() > 0) {

                        //     foreach ($reports as $report) {

                        //         $newReportId = DB::table('tsr_sample_reports')->insertGetId([
                        //             'code' => $report->code,
                        //             'passkey' => $report->passkey,
                        //             'information' => $report->information,
                        //             'attachment' => $report->attachment,
                        //             'user_id' => User::where('old_id', $report->user_id)->value('id') ?? 1,
                        //             'tm_id' => $report->tm_id,
                        //             'sample_id' => $newSampleId,
                        //             'created_at' => $report->created_at,
                        //             'updated_at' => $report->updated_at
                        //         ]);

                        //         // ✅ get ALL lists related to THIS report
                        //         $lists = DB::connection('old_db')
                        //             ->table('tsr_sample_report_lists')
                        //             ->where('report_id', $report->id)
                        //             ->get();

                        //         foreach ($lists as $list) {
                        //             DB::table('tsr_sample_report_lists')->insert([
                        //                 'report_id' => $newReportId,
                        //                 'sample_id' => $list->sample_id,
                        //                 'created_at' => $list->created_at,
                        //                 'updated_at' => $list->updated_at
                        //             ]);
                        //         }

                        //     }
                        // }
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | PAYMENTS
                    |--------------------------------------------------------------------------
                    */

                    $payments = DB::connection('old_db')
                    ->table('tsr_payments')
                    ->where('tsr_id',$tsr->id)
                    ->get();

                    foreach ($payments as $payment) {

                        $paymentId = DB::table('tsr_payments')->insertGetId([

                            'total'=>$payment->total,
                            'subtotal'=>$payment->subtotal,
                            'discount'=>$payment->discount,
                            'or_number'=>$payment->or_number,
                            'is_paid'=>$payment->is_paid,
                            'is_free'=>$payment->is_free,
                            'is_child'=>$payment->is_child,
                            'has_deduction'=>$payment->has_deduction,
                            'discount_id'=>$payment->discount_id,
                            'payment_id'=>$payment->payment_id,
                            'collection_id'=>$payment->collection_id,
                            'status_id'=>$payment->status_id,
                            'tsr_id'=>$newTsrId,
                            'paid_at'=>$payment->paid_at

                        ]);



                    }

                    /*
                    |--------------------------------------------------------------------------
                    | SERVICES
                    |--------------------------------------------------------------------------
                    */

                    $services = DB::connection('old_db')
                    ->table('tsr_services')
                    ->where('typeable_id',$tsr->id)
                    ->where('typeable_type','App\Models\Tsr')
                    ->get();

                    foreach ($services as $service) {

                        $oldAddon = DB::connection('old_db')->table('testservice_addons')->where('id', $service->service_id)->first();
                        $addonText = strtolower(($oldAddon->name ?? '').' '.($oldAddon->description ?? ''));

                        // These fixed add-ons were wrongly tied to a Testservice (or lack an old_id
                        // mapping altogether) in the old system; they actually belong to the
                        // laboratory/agency, not a specific test. Resolve them by name instead.
                        if ($oldAddon && (str_contains($addonText, 'onsite') || str_contains($addonText, 'on-site'))) {
                            if (str_contains($addonText, '>') || str_contains($addonText, 'more than')) {
                                $serviceId = 1; // more than 50km
                            } elseif (str_contains($addonText, '<') || str_contains($addonText, 'within')) {
                                $serviceId = 2; // within 50km
                            } else {
                                $serviceId = null;
                            }
                        } elseif ($oldAddon && str_contains($addonText, 'laboratory facilities')) {
                            $serviceId = 3; // Use of Laboratory Facilities
                        } elseif ($oldAddon && str_contains($addonText, 'certified true copy')) {
                            $serviceId = 4; // Issuance of Certified True Copy
                        } elseif ($oldAddon && str_contains($addonText, 'reissuance')) {
                            $serviceId = 5; // Reissuance of Test Report
                        } elseif ($oldAddon && (str_contains($addonText, 'ammendment') || str_contains($addonText, 'amendment'))) {
                            $serviceId = 6; // Ammendment of Test Report
                        } else {
                            $tsrAddon = TestserviceAddon::where('old_id', $service->service_id)->first();
                            $serviceId = $tsrAddon?->id;
                        }

                        DB::table('tsr_services')->insert([
                            'fee'=> $service->fee,
                            'total' => $service->total,
                            'quantity' => $service->quantity,
                            'service_id'=> $serviceId,
                            'typeable_id'=> $newTsrId,
                            'typeable_type'=> 'App\Models\Tsr',
                            'is_additional'=> $service->is_additional,
                            'created_at'=> $service->created_at,
                            'updated_at'=> $service->updated_at
                        ]);

                    }

                    /*
                    |--------------------------------------------------------------------------
                    | REFERRALS
                    |--------------------------------------------------------------------------
                    */

                    $referrals = DB::connection('old_db')
                    ->table('tsr_referrals')
                    ->where('tsr_id',$tsr->id)
                    ->get();

                    foreach ($referrals as $referral) {

                        DB::table('tsr_referrals')->insert([

                            'is_psto'=>$referral->is_psto,
                            'province_code'=>$referral->province_code,
                            'agency_id'=>$referral->agency_id,
                            'tsr_id'=>$newTsrId,
                            'created_at'=>$referral->created_at,
                            'updated_at'=>$referral->updated_at

                        ]);

                    }

                    /*
                    |--------------------------------------------------------------------------
                    | RELEASES
                    |--------------------------------------------------------------------------
                    */

                    $releases = DB::connection('old_db')
                    ->table('tsr_releases')
                    ->where('tsr_id',$tsr->id)
                    ->get();

                    foreach ($releases as $release) {

                        DB::table('tsr_releases')->insert([

                            'released_at'=>$release->released_at,
                            'release_id'=> 16,
                            'status_id'=>$release->status_id,
                            'user_id'=> User::where('old_id', $release->user_id)->value('id') ?? 30,
                            'tsr_id'=>$newTsrId,
                            'created_at'=>$release->created_at,
                            'updated_at'=>$release->updated_at

                        ]);

                    }

                      /*
                    |--------------------------------------------------------------------------
                    | REPORT PRINTING
                    |--------------------------------------------------------------------------
                    */

                    $rep = DB::connection('old_db')
                    ->table('tsr_reports')
                    ->where('tsr_id',$tsr->id)
                    ->first();
                    if ($rep) {
                        DB::table('tsr_reports')->insertGetId([
                            'information' => $rep->information,
                            'secret_key' => $rep->secret_key,
                            'tsr_id' => $newTsrId,
                            'created_at' => $rep->created_at,
                            'updated_at' => $rep->updated_at
                        ]);
                    }

                    DB::commit();
                    

                } catch (\Exception $e) {

                    DB::rollBack();
                    $this->error($e->getMessage());

                }

            }

        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->info('TSR migration completed.');

        // Run finance (OP and OR) migration immediately so every migrated TSR
        // is guaranteed to have its finance data attached in the same pass.
        $this->call('migrate:finance');

        $this->info('Migration completed.');

    }
}