<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SampleCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sample_categories')->delete();
        
        \DB::table('sample_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Rubber',
                'is_active' => 1,
                'laboratory_id' => 4,
                'agency_id' => 14,
                'user_id' => 5,
                'created_at' => '2026-02-03 09:14:07',
                'updated_at' => '2026-02-03 09:14:07',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Mass',
                'is_active' => 1,
                'laboratory_id' => 3,
                'agency_id' => 14,
                'user_id' => 5,
                'created_at' => '2026-02-03 09:18:03',
                'updated_at' => '2026-02-03 09:18:03',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Temperature',
                'is_active' => 1,
                'laboratory_id' => 3,
                'agency_id' => 14,
                'user_id' => 5,
                'created_at' => '2026-02-03 09:25:41',
                'updated_at' => '2026-02-03 09:25:41',
            ),
        ));
        
        
    }
}