<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AgencyFacilitySignatoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('agency_facility_signatories')->delete();
        
        \DB::table('agency_facility_signatories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'accountant_id' => 20,
                'cashier_id' => 19,
                'facility_id' => 1,
                'created_at' => '2026-02-11 15:02:16',
                'updated_at' => '2026-02-12 08:34:14',
            ),
        ));
        
        
    }
}