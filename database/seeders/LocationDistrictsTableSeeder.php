<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LocationDistrictsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('location_districts')->delete();
        
        \DB::table('location_districts')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => '097332100',
                'name' => '1st',
                'district' => NULL,
                'municipality_code' => '097332000',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => '097332101',
                'name' => '2nd',
                'district' => NULL,
                'municipality_code' => '097332000',
            ),
        ));
        
        
    }
}