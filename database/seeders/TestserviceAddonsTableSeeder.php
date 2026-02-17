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
            2 => 
            array (
                'id' => 3,
                'fee' => '20.00',
                'name' => 'Additional fee for every tonne thereafter in excess of 1 tonne',
                'description' => 'n/a',
                'is_additional' => 1,
                'is_active' => 1,
                'typeable_id' => 200,
                'typeable_type' => 'App\\Models\\Testservice',
                'agency_id' => 14,
                'added_by' => 2,
                'created_at' => '2026-02-16 09:02:52',
                'updated_at' => '2026-02-16 09:02:52',
            ),
            3 => 
            array (
                'id' => 4,
                'fee' => '500.00',
                'name' => 'Additional fee per Test points',
                'description' => 'n/a',
                'is_additional' => 1,
                'is_active' => 1,
                'typeable_id' => 201,
                'typeable_type' => 'App\\Models\\Testservice',
                'agency_id' => 14,
                'added_by' => 2,
                'created_at' => '2026-02-16 09:37:34',
                'updated_at' => '2026-02-16 09:37:34',
            ),
            4 => 
            array (
                'id' => 5,
                'fee' => '1750.00',
                'name' => 'Additional fee per Channel',
                'description' => 'n/a',
                'is_additional' => 1,
                'is_active' => 1,
                'typeable_id' => 201,
                'typeable_type' => 'App\\Models\\Testservice',
                'agency_id' => 14,
                'added_by' => 2,
                'created_at' => '2026-02-16 09:38:06',
                'updated_at' => '2026-02-16 09:38:06',
            ),
        ));
        
        
    }
}