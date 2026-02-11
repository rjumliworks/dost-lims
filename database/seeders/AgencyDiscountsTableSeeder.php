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
                'created_at' => '2026-02-11 15:02:31',
                'updated_at' => '2026-02-11 15:02:31',
            ),
            1 => 
            array (
                'id' => 2,
                'discount_id' => 2,
                'agency_id' => 14,
                'is_occasional' => 0,
                'is_active' => 1,
                'created_at' => '2026-02-11 15:02:41',
                'updated_at' => '2026-02-11 15:02:41',
            ),
            2 => 
            array (
                'id' => 3,
                'discount_id' => 3,
                'agency_id' => 14,
                'is_occasional' => 0,
                'is_active' => 1,
                'created_at' => '2026-02-11 15:02:48',
                'updated_at' => '2026-02-11 15:02:48',
            ),
            3 => 
            array (
                'id' => 4,
                'discount_id' => 4,
                'agency_id' => 14,
                'is_occasional' => 0,
                'is_active' => 1,
                'created_at' => '2026-02-11 15:02:56',
                'updated_at' => '2026-02-11 15:02:56',
            ),
            4 => 
            array (
                'id' => 5,
                'discount_id' => 13,
                'agency_id' => 14,
                'is_occasional' => 0,
                'is_active' => 1,
                'created_at' => '2026-02-11 15:05:20',
                'updated_at' => '2026-02-11 15:05:20',
            ),
            5 => 
            array (
                'id' => 6,
                'discount_id' => 8,
                'agency_id' => 14,
                'is_occasional' => 0,
                'is_active' => 1,
                'created_at' => '2026-02-11 15:05:30',
                'updated_at' => '2026-02-11 15:05:30',
            ),
            6 => 
            array (
                'id' => 7,
                'discount_id' => 5,
                'agency_id' => 14,
                'is_occasional' => 0,
                'is_active' => 1,
                'created_at' => '2026-02-11 15:05:38',
                'updated_at' => '2026-02-11 15:05:38',
            ),
            7 => 
            array (
                'id' => 8,
                'discount_id' => 7,
                'agency_id' => 14,
                'is_occasional' => 0,
                'is_active' => 1,
                'created_at' => '2026-02-11 15:05:44',
                'updated_at' => '2026-02-11 15:05:44',
            ),
            8 => 
            array (
                'id' => 9,
                'discount_id' => 10,
                'agency_id' => 14,
                'is_occasional' => 0,
                'is_active' => 1,
                'created_at' => '2026-02-11 15:05:55',
                'updated_at' => '2026-02-11 15:05:55',
            ),
            9 => 
            array (
                'id' => 10,
                'discount_id' => 11,
                'agency_id' => 14,
                'is_occasional' => 0,
                'is_active' => 1,
                'created_at' => '2026-02-11 15:06:03',
                'updated_at' => '2026-02-11 15:06:03',
            ),
            10 => 
            array (
                'id' => 11,
                'discount_id' => 12,
                'agency_id' => 14,
                'is_occasional' => 0,
                'is_active' => 1,
                'created_at' => '2026-02-11 15:06:13',
                'updated_at' => '2026-02-11 15:06:13',
            ),
            11 => 
            array (
                'id' => 12,
                'discount_id' => 9,
                'agency_id' => 14,
                'is_occasional' => 1,
                'is_active' => 0,
                'created_at' => '2026-02-11 15:14:54',
                'updated_at' => '2026-02-11 15:14:54',
            ),
        ));
        
        
    }
}