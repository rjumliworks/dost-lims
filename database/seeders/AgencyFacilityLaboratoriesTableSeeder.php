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
                'facility_id' => 1,
                'laboratory_id' => 1,
                'created_at' => '2026-01-24 22:21:18',
                'updated_at' => '2026-01-24 22:21:18',
            ),
            1 => 
            array (
                'id' => 2,
                'facility_id' => 1,
                'laboratory_id' => 2,
                'created_at' => '2026-01-24 22:21:18',
                'updated_at' => '2026-01-24 22:21:18',
            ),
            2 => 
            array (
                'id' => 3,
                'facility_id' => 1,
                'laboratory_id' => 3,
                'created_at' => '2026-01-24 22:21:18',
                'updated_at' => '2026-01-24 22:21:18',
            ),
            3 => 
            array (
                'id' => 4,
                'facility_id' => 1,
                'laboratory_id' => 4,
                'created_at' => '2026-01-24 22:21:18',
                'updated_at' => '2026-01-24 22:21:18',
            ),
        ));
        
        
    }
}