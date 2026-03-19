<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TargetsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('targets')->delete();
        
        \DB::table('targets')->insert(array (
            0 => 
            array (
                'id' => 1,
                'year' => '2025',
                'data' => '[]',
                'is_completed' => 1,
                'agency_id' => 14,
                'created_at' => '2025-01-01 14:38:06',
                'updated_at' => '2025-01-01 14:38:06',
            ),
            1 => 
            array (
                'id' => 2,
                'year' => '2026',
                'data' => '[]',
                'is_completed' => 0,
                'agency_id' => 14,
                'created_at' => '2025-01-01 14:38:06',
                'updated_at' => '2025-01-01 14:38:06',
            ),
        ));
        
        
    }
}