<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SampleTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sample_types')->delete();
        
        \DB::table('sample_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Raw Natural Rubber',
                'is_active' => 1,
                'category_id' => 1,
                'user_id' => 5,
                'agency_id' => 14,
                'created_at' => '2026-02-03 09:16:31',
                'updated_at' => '2026-02-03 09:16:31',
            ),
            1 => 
            array (
                'id' => 2,
            'name' => 'Non-Automatic Weighing Instrument (NAWI)',
                'is_active' => 1,
                'category_id' => 2,
                'user_id' => 5,
                'agency_id' => 14,
                'created_at' => '2026-02-03 09:18:29',
                'updated_at' => '2026-02-03 09:18:29',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Test Weight',
                'is_active' => 1,
                'category_id' => 2,
                'user_id' => 5,
                'agency_id' => 14,
                'created_at' => '2026-02-03 09:22:08',
                'updated_at' => '2026-02-03 09:22:08',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Contact Thermometer',
                'is_active' => 1,
                'category_id' => 3,
                'user_id' => 5,
                'agency_id' => 14,
                'created_at' => '2026-02-03 09:26:00',
                'updated_at' => '2026-02-03 09:26:00',
            ),
        ));
        
        
    }
}