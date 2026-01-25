<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AgencyDiscountsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('agency_discounts')->delete();
        
        \DB::table('agency_discounts')->insert(array (
            0 => 
            array (
                'id' => 1,
                'discount_id' => 1,
                'agency_id' => 14,
                'is_occasional' => 0,
                'is_active' => 1,
                'created_at' => '2026-01-24 22:22:26',
                'updated_at' => '2026-01-24 22:22:26',
            ),
            1 => 
            array (
                'id' => 2,
                'discount_id' => 2,
                'agency_id' => 14,
                'is_occasional' => 0,
                'is_active' => 1,
                'created_at' => '2026-01-24 22:22:26',
                'updated_at' => '2026-01-24 22:22:26',
            ),
            2 => 
            array (
                'id' => 3,
                'discount_id' => 3,
                'agency_id' => 14,
                'is_occasional' => 0,
                'is_active' => 1,
                'created_at' => '2026-01-24 22:22:26',
                'updated_at' => '2026-01-24 22:22:26',
            ),
            3 => 
            array (
                'id' => 4,
                'discount_id' => 4,
                'agency_id' => 14,
                'is_occasional' => 0,
                'is_active' => 1,
                'created_at' => '2026-01-24 22:22:26',
                'updated_at' => '2026-01-24 22:22:26',
            ),
        ));
        
        
    }
}