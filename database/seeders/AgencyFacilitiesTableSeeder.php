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
            1 => 
            array (
                'id' => 2,
                'name' => 'ZDN Satellite Laboratory',
                'short' => 'ZDN',
                'is_regional' => 0,
                'is_separated' => 0,
                'is_psto' => 1,
                'is_active' => 1,
                'address' => 'Upper Turno',
                'longitude' => '122.218344',
                'latitude' => '11.729967',
                'barangay_code' => '097202020',
                'municipality_code' => '097202000',
                'province_code' => '097200000',
                'region_code' => '090000000',
                'agency_id' => 14,
                'created_at' => '2026-07-16 17:27:03',
                'updated_at' => '2026-07-16 17:27:03',
            ),
        ));


    }
}
