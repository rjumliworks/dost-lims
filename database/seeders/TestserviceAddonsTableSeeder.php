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
                'old_id' => 1,
                'is_additional' => 0,
                'is_active' => 1,
                'typeable_id' => 3,
                'typeable_type' => 'App\\Models\\ListLaboratory',
                'agency_id' => 14,
                'added_by' => 1,
                'created_at' => '2026-03-15 06:32:18',
                'updated_at' => '2026-03-15 06:32:18',
            ),
            1 => 
            array (
                'id' => 2,
                'fee' => '2000.00',
                'name' => 'On-site Calibration',
                'description' => 'Within 50 km radius from the laboratory',
                'old_id' => 2,
                'is_additional' => 0,
                'is_active' => 1,
                'typeable_id' => 3,
                'typeable_type' => 'App\\Models\\ListLaboratory',
                'agency_id' => 14,
                'added_by' => 1,
                'created_at' => '2026-03-15 06:32:18',
                'updated_at' => '2026-03-15 06:32:18',
            ),
            2 => 
            array (
                'id' => 50,
                'fee' => '20.00',
                'name' => 'Additional fee for every tonne thereafter in excess of 1 tonne',
                'description' => 'n/a',
                'old_id' => 3,
                'is_additional' => 0,
                'is_active' => 1,
                'typeable_id' => 170,
                'typeable_type' => 'App\\Models\\Testservice',
                'agency_id' => 14,
                'added_by' => 1,
                'created_at' => '2024-08-14 18:41:18',
                'updated_at' => '2024-08-14 18:41:18',
            ),
            3 => 
            array (
                'id' => 51,
                'fee' => '500.00',
                'name' => 'Additional fee per test point',
                'description' => 'n/a',
                'old_id' => 4,
                'is_additional' => 0,
                'is_active' => 1,
                'typeable_id' => 205,
                'typeable_type' => 'App\\Models\\Testservice',
                'agency_id' => 14,
                'added_by' => 1,
                'created_at' => '2024-08-14 19:10:18',
                'updated_at' => '2024-08-14 19:10:18',
            ),
            4 => 
            array (
                'id' => 52,
                'fee' => '500.00',
                'name' => 'Additional fee per test point',
                'description' => 'n/a',
                'old_id' => 6,
                'is_additional' => 0,
                'is_active' => 1,
                'typeable_id' => 168,
                'typeable_type' => 'App\\Models\\Testservice',
                'agency_id' => 14,
                'added_by' => 1,
                'created_at' => '2024-08-14 19:20:30',
                'updated_at' => '2024-08-14 19:20:30',
            ),
            5 => 
            array (
                'id' => 53,
                'fee' => '650.00',
                'name' => 'Additional fee per test point',
                'description' => 'n/a',
                'old_id' => 7,
                'is_additional' => 0,
                'is_active' => 1,
                'typeable_id' => 167,
                'typeable_type' => 'App\\Models\\Testservice',
                'agency_id' => 14,
                'added_by' => 1,
                'created_at' => '2024-08-14 19:20:48',
                'updated_at' => '2024-08-14 19:20:48',
            ),
            6 => 
            array (
                'id' => 54,
                'fee' => '500.00',
                'name' => 'Additional fee per test point',
                'description' => 'n/a',
                'old_id' => 8,
                'is_additional' => 0,
                'is_active' => 1,
                'typeable_id' => 208,
                'typeable_type' => 'App\\Models\\Testservice',
                'agency_id' => 14,
                'added_by' => 1,
                'created_at' => '2024-08-14 19:31:41',
                'updated_at' => '2024-08-14 19:31:41',
            ),
            7 => 
            array (
                'id' => 55,
                'fee' => '350.00',
                'name' => 'Additional fee per succeeding range',
                'description' => 'n/a',
                'old_id' => 9,
                'is_additional' => 0,
                'is_active' => 1,
                'typeable_id' => 207,
                'typeable_type' => 'App\\Models\\Testservice',
                'agency_id' => 14,
                'added_by' => 1,
                'created_at' => '2024-08-14 19:33:48',
                'updated_at' => '2024-08-14 19:33:48',
            ),
            8 => 
            array (
                'id' => 56,
                'fee' => '350.00',
                'name' => 'Additional fee per succeeding range',
                'description' => 'n/a',
                'old_id' => 11,
                'is_additional' => 0,
                'is_active' => 1,
                'typeable_id' => 165,
                'typeable_type' => 'App\\Models\\Testservice',
                'agency_id' => 14,
                'added_by' => 1,
                'created_at' => '2024-08-14 19:34:52',
                'updated_at' => '2024-08-14 19:34:52',
            ),
            9 => 
            array (
                'id' => 57,
                'fee' => '300.00',
                'name' => 'Additional fee per succeeding range',
                'description' => 'n/a',
                'old_id' => 12,
                'is_additional' => 0,
                'is_active' => 1,
                'typeable_id' => 166,
                'typeable_type' => 'App\\Models\\Testservice',
                'agency_id' => 14,
                'added_by' => 1,
                'created_at' => '2024-08-14 19:35:04',
                'updated_at' => '2024-08-14 19:35:04',
            ),
            10 => 
            array (
                'id' => 58,
                'fee' => '300.00',
                'name' => 'Additional One Test Point',
                'description' => 'n/a',
                'old_id' => 18,
                'is_additional' => 0,
                'is_active' => 1,
                'typeable_id' => 215,
                'typeable_type' => 'App\\Models\\Testservice',
                'agency_id' => 14,
                'added_by' => 1,
                'created_at' => '2025-02-12 22:41:20',
                'updated_at' => '2025-02-12 22:41:20',
            ),
            11 => 
            array (
                'id' => 59,
                'fee' => '850.00',
                'name' => 'Ammonia-Nitrogen',
                'description' => 'n/a',
                'old_id' => 19,
                'is_additional' => 0,
                'is_active' => 1,
                'typeable_id' => 76,
                'typeable_type' => 'App\\Models\\Testservice',
                'agency_id' => 14,
                'added_by' => 1,
                'created_at' => '2025-06-12 08:25:16',
                'updated_at' => '2025-06-12 08:25:16',
            ),
        ));
        
        
    }
}