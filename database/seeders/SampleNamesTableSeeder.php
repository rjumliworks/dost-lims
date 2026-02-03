<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SampleNamesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sample_names')->delete();
        
        \DB::table('sample_names')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Raw Natural Rubber',
                'is_active' => 1,
                'type_id' => 1,
                'user_id' => 5,
                'agency_id' => 14,
                'created_at' => '2026-02-03 09:16:41',
                'updated_at' => '2026-02-03 09:16:41',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Spring Scale',
                'is_active' => 1,
                'type_id' => 2,
                'user_id' => 5,
                'agency_id' => 14,
                'created_at' => '2026-02-03 09:18:58',
                'updated_at' => '2026-02-03 09:18:58',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Beam Balance',
                'is_active' => 1,
                'type_id' => 2,
                'user_id' => 5,
                'agency_id' => 14,
                'created_at' => '2026-02-03 09:19:25',
                'updated_at' => '2026-02-03 09:19:25',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Mechanical Scale with Counter Poise Weights',
                'is_active' => 1,
                'type_id' => 2,
                'user_id' => 5,
                'agency_id' => 14,
                'created_at' => '2026-02-03 09:19:54',
                'updated_at' => '2026-02-03 09:19:54',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Bathroom Scale',
                'is_active' => 1,
                'type_id' => 2,
                'user_id' => 5,
                'agency_id' => 14,
                'created_at' => '2026-02-03 09:20:14',
                'updated_at' => '2026-02-03 09:20:14',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Analytical Balance',
                'is_active' => 1,
                'type_id' => 2,
                'user_id' => 5,
                'agency_id' => 14,
                'created_at' => '2026-02-03 09:20:34',
                'updated_at' => '2026-02-03 09:20:34',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Digital Scale',
                'is_active' => 1,
                'type_id' => 2,
                'user_id' => 5,
                'agency_id' => 14,
                'created_at' => '2026-02-03 09:20:50',
                'updated_at' => '2026-02-03 09:20:50',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Top Loading Balance',
                'is_active' => 1,
                'type_id' => 2,
                'user_id' => 5,
                'agency_id' => 14,
                'created_at' => '2026-02-03 09:21:05',
                'updated_at' => '2026-02-03 09:21:05',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Mass Comparator',
                'is_active' => 1,
                'type_id' => 2,
                'user_id' => 5,
                'agency_id' => 14,
                'created_at' => '2026-02-03 09:21:28',
                'updated_at' => '2026-02-03 09:21:28',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Truck Scale',
                'is_active' => 1,
                'type_id' => 2,
                'user_id' => 5,
                'agency_id' => 14,
                'created_at' => '2026-02-03 09:21:46',
                'updated_at' => '2026-02-03 09:21:46',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Test Weight',
                'is_active' => 1,
                'type_id' => 3,
                'user_id' => 5,
                'agency_id' => 14,
                'created_at' => '2026-02-03 09:22:14',
                'updated_at' => '2026-02-03 09:22:14',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Mass Standard',
                'is_active' => 1,
                'type_id' => 3,
                'user_id' => 5,
                'agency_id' => 14,
                'created_at' => '2026-02-03 09:22:31',
                'updated_at' => '2026-02-03 09:22:31',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Liquid-in-Glass',
                'is_active' => 1,
                'type_id' => 4,
                'user_id' => 5,
                'agency_id' => 14,
                'created_at' => '2026-02-03 09:26:42',
                'updated_at' => '2026-02-03 09:26:42',
            ),
        ));
        
        
    }
}