<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SampleCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('sample_categories')->delete();

        \DB::table('sample_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'n/a',
                'is_active' => 0,
                'laboratory_id' => 1,
                'agency_id' => 14,
                'user_id' => 1,
                'created_at' => '2026-03-14 15:03:01',
                'updated_at' => '2026-03-14 15:03:01',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Rubber',
                'is_active' => 1,
                'laboratory_id' => 4,
                'agency_id' => 14,
                'user_id' => 2,
                'created_at' => '2026-02-12 11:20:49',
                'updated_at' => '2026-02-12 11:20:49',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Animal-Based Food Products',
                'is_active' => 1,
                'laboratory_id' => 1,
                'agency_id' => 14,
                'user_id' => 2,
                'created_at' => '2026-02-12 13:03:34',
                'updated_at' => '2026-02-12 13:03:34',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Animal Feeds and Feed Ingredients',
                'is_active' => 1,
                'laboratory_id' => 1,
                'agency_id' => 14,
                'user_id' => 2,
                'created_at' => '2026-02-12 13:23:02',
                'updated_at' => '2026-02-12 13:23:02',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Plant-Based Food Products',
                'is_active' => 1,
                'laboratory_id' => 1,
                'agency_id' => 14,
                'user_id' => 2,
                'created_at' => '2026-02-12 13:26:08',
                'updated_at' => '2026-02-12 13:26:08',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Other Food Products',
                'is_active' => 1,
                'laboratory_id' => 1,
                'agency_id' => 14,
                'user_id' => 2,
                'created_at' => '2026-02-12 13:33:53',
                'updated_at' => '2026-02-12 13:33:53',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Beverage',
                'is_active' => 1,
                'laboratory_id' => 1,
                'agency_id' => 14,
                'user_id' => 2,
                'created_at' => '2026-02-12 13:40:00',
                'updated_at' => '2026-02-12 13:40:00',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Environmental Matrices',
                'is_active' => 1,
                'laboratory_id' => 1,
                'agency_id' => 14,
                'user_id' => 2,
                'created_at' => '2026-02-12 13:47:13',
                'updated_at' => '2026-02-12 13:47:13',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Industrial and Natural Resource Products',
                'is_active' => 1,
                'laboratory_id' => 1,
                'agency_id' => 14,
                'user_id' => 2,
                'created_at' => '2026-02-12 13:53:55',
                'updated_at' => '2026-02-12 13:53:55',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Shelf-Life Studies',
                'is_active' => 1,
                'laboratory_id' => 1,
                'agency_id' => 14,
                'user_id' => 2,
                'created_at' => '2026-02-12 14:01:13',
                'updated_at' => '2026-02-12 14:01:13',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Mass',
                'is_active' => 1,
                'laboratory_id' => 3,
                'agency_id' => 14,
                'user_id' => 2,
                'created_at' => '2026-02-13 16:30:23',
                'updated_at' => '2026-02-13 16:30:23',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Temperature',
                'is_active' => 1,
                'laboratory_id' => 3,
                'agency_id' => 14,
                'user_id' => 2,
                'created_at' => '2026-02-13 16:36:16',
                'updated_at' => '2026-02-13 16:36:16',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Hygrometry',
                'is_active' => 1,
                'laboratory_id' => 3,
                'agency_id' => 14,
                'user_id' => 2,
                'created_at' => '2026-02-13 16:42:27',
                'updated_at' => '2026-02-13 16:42:27',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Volume',
                'is_active' => 1,
                'laboratory_id' => 3,
                'agency_id' => 14,
                'user_id' => 2,
                'created_at' => '2026-02-13 16:44:31',
                'updated_at' => '2026-02-13 16:44:31',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Pressure',
                'is_active' => 1,
                'laboratory_id' => 3,
                'agency_id' => 14,
                'user_id' => 2,
                'created_at' => '2026-02-13 16:51:25',
                'updated_at' => '2026-02-13 16:51:25',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Electrical',
                'is_active' => 1,
                'laboratory_id' => 3,
                'agency_id' => 14,
                'user_id' => 2,
                'created_at' => '2026-02-13 16:54:27',
                'updated_at' => '2026-02-13 16:54:27',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Length',
                'is_active' => 1,
                'laboratory_id' => 3,
                'agency_id' => 14,
                'user_id' => 2,
                'created_at' => '2026-02-13 16:57:17',
                'updated_at' => '2026-02-13 16:57:17',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Foods',
                'is_active' => 1,
                'laboratory_id' => 2,
                'agency_id' => 14,
                'user_id' => 2,
                'created_at' => '2026-03-14 14:40:54',
                'updated_at' => '2026-03-14 14:40:54',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Environmental Matrices',
                'is_active' => 1,
                'laboratory_id' => 2,
                'agency_id' => 14,
                'user_id' => 2,
                'created_at' => '2026-03-14 15:01:24',
                'updated_at' => '2026-03-14 15:01:24',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Industrial and Natural Resource Products',
                'is_active' => 1,
                'laboratory_id' => 2,
                'agency_id' => 14,
                'user_id' => 2,
                'created_at' => '2026-03-14 15:03:01',
                'updated_at' => '2026-03-14 15:03:01',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Enclosure',
                'is_active' => 1,
                'laboratory_id' => 3,
                'agency_id' => 14,
                'user_id' => 2,
                'created_at' => '2026-08-05 17:31:26',
                'updated_at' => '2026-08-05 17:31:26',
            ),
        ));


    }
}
