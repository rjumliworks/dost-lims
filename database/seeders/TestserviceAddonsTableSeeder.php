<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TestserviceAddonsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('testservice_addons')->delete();
        
        \DB::table('testservice_addons')->insert(array (
            0 => 
            array (
                'id' => 1,
                'fee' => '3000.00',
                'name' => 'On-site Calibration',
                'description' => 'More than 50 km radius from the laboratory',
                'is_additional' => 0,
                'is_active' => 1,
                'typeable_id' => 3,
                'typeable_type' => 'App\\Models\\ListLaboratory',
                'agency_id' => 14,
                'added_by' => 1,
                'created_at' => '2026-02-11 16:49:43',
                'updated_at' => '2026-02-11 16:49:43',
            ),
            1 => 
            array (
                'id' => 2,
                'fee' => '2000.00',
                'name' => 'On-site Calibration',
                'description' => 'Within 50 km radius from the laboratory',
                'is_additional' => 0,
                'is_active' => 1,
                'typeable_id' => 3,
                'typeable_type' => 'App\\Models\\ListLaboratory',
                'agency_id' => 14,
                'added_by' => 1,
                'created_at' => '2026-02-11 16:50:00',
                'updated_at' => '2026-02-11 16:50:00',
            ),
        ));
        
        
    }
}