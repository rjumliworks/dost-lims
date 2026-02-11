<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AgencyFacilitiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('agency_facilities')->delete();
        
        \DB::table('agency_facilities')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Regional Standards and Testing Laboratories',
                'short' => 'RSTL',
                'is_regional' => 1,
                'is_separated' => 0,
                'is_psto' => 0,
                'is_active' => 1,
                'address' => 'Pettit Barracks',
                'longitude' => '122.079735',
                'latitude' => '6.903356',
                'barangay_code' => '097332064',
                'municipality_code' => '097332000',
                'province_code' => '097300000',
                'region_code' => '090000000',
                'agency_id' => 14,
                'created_at' => '2026-02-11 15:02:16',
                'updated_at' => '2026-02-11 15:02:16',
            ),
        ));
        
        
    }
}