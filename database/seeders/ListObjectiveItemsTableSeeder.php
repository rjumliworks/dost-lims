<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListObjectiveItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('list_objective_items')->delete();
        
        \DB::table('list_objective_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'RSTL Consultancy',
                'objective_id' => 18,
                'created_at' => '2026-07-01 13:50:31',
                'updated_at' => '2026-07-01 13:50:31',
            ),
            1 => 
            array (
                'id' => 2,
            'name' => 'RSTL (Non-Paying)',
                'objective_id' => 18,
                'created_at' => '2026-07-01 13:50:31',
                'updated_at' => '2026-07-01 13:50:31',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'RSTL Consultancy',
                'objective_id' => 19,
                'created_at' => '2026-07-01 13:50:31',
                'updated_at' => '2026-07-01 13:50:31',
            ),
            3 => 
            array (
                'id' => 4,
            'name' => 'RSTL (Non-Paying)',
                'objective_id' => 19,
                'created_at' => '2026-07-01 13:50:31',
                'updated_at' => '2026-07-01 13:50:31',
            ),
        ));
        
        
    }
}