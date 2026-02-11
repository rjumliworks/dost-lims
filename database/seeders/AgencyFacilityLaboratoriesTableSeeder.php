<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AgencyFacilityLaboratoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('agency_facility_laboratories')->delete();
        
        \DB::table('agency_facility_laboratories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'laboratory_id' => 1,
                'facility_id' => 1,
                'created_at' => '2026-02-11 15:21:37',
                'updated_at' => '2026-02-11 15:21:37',
            ),
            1 => 
            array (
                'id' => 2,
                'laboratory_id' => 2,
                'facility_id' => 1,
                'created_at' => '2026-02-11 15:21:40',
                'updated_at' => '2026-02-11 15:21:40',
            ),
            2 => 
            array (
                'id' => 3,
                'laboratory_id' => 3,
                'facility_id' => 1,
                'created_at' => '2026-02-11 15:21:44',
                'updated_at' => '2026-02-11 15:21:44',
            ),
            3 => 
            array (
                'id' => 4,
                'laboratory_id' => 4,
                'facility_id' => 1,
                'created_at' => '2026-02-11 15:21:47',
                'updated_at' => '2026-02-11 15:21:47',
            ),
        ));
        
        
    }
}