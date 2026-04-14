<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Supplier;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateEquipments extends Command
{
    protected $signature = 'migrate:equipments';
    protected $description = 'Migrate equipments from old DB including encrypted fields';
    

    public function handle()
    {
        $this->info("Starting customer migration...");

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $tables = [
            'equipment',
            'equipment_infos',
            'equipment_logs'
        ];
        foreach ($tables as $table) {
            DB::table($table)->truncate();
            $this->info("Truncated {$table}");
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $equipments = DB::connection('old_db')
            ->table('equipment')
            ->orderBy('id')->get();

        foreach ($equipments as $equipment) {
            $e = DB::table('equipment')->insertGetId([
                'code' => $equipment->code,
                'name' => $equipment->name,
                'maintenance_plan' => $equipment->maintenance_plan,
                'maintenance_due' => $equipment->maintenance_due,
                'calibration_program' => $equipment->calibration_program,
                'calibration_due' => $equipment->calibration_due,
                'calibration_testpoints' => $equipment->calibration_testpoints,
                'status_id' => $equipment->status_id,
                'laboratory_id' => $equipment->laboratory_id,
                'agency_id' => 14,
                'old_id' => $equipment->id,
                'created_at' => $equipment->created_at,
                'updated_at' => $equipment->updated_at
            ]);

            if($e){
                $info = DB::connection('old_db')
                ->table('equipment_infos')
                ->where('equipment_id',$equipment->id)
                ->first();
                
                DB::table('equipment_infos')->insert([
                    'manufacturer' => $info->manufacturer,
                    'model' => $info->model,
                    'serial_no' => $info->serial_no,
                    'others' => $info->others,
                    'price' => $info->price,
                    'supplier_id' => Supplier::where('id', $info->supplier_id)->value('id'),
                    'user_id' => User::where('old_id', $info->user_id)->value('id') ?? 1,
                    'equipment_id' => $e,
                    'created_at'=>$info->created_at,
                    'updated_at'=>$info->updated_at
                ]);

                $logs = DB::connection('old_db')
                ->table('equipment_logs')
                ->where('equipment_id',$equipment->id)
                ->orderBy('id','ASC')
                ->get();
                foreach($logs as $log){
                    DB::table('equipment_logs')->insert([
                        'is_calibrated' => $log->is_calibrated,
                        'note' => $log->note,
                        'next_date' => $log->next_date,
                        'date' => $log->date,
                        'user_id' => User::where('old_id', $log->user_id)->value('id') ?? 1,
                        'equipment_id' => $e,
                        'created_at'=>$log->created_at,
                        'updated_at'=>$log->updated_at
                    ]);
                }
            }
            $this->info("Migrated equipment ID {$equipment->id}");
        }
        $this->info("Equipment migration completed successfully.");
    }
}
