<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SampleTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sample_types')->delete();
        
        \DB::table('sample_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Raw Natural Rubber',
                'is_active' => 1,
                'category_id' => 1,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 11:20:59',
                'updated_at' => '2026-02-12 11:20:59',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Meat',
                'is_active' => 1,
                'category_id' => 2,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:03:47',
                'updated_at' => '2026-02-12 13:03:47',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Fish',
                'is_active' => 1,
                'category_id' => 2,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:07:52',
                'updated_at' => '2026-02-12 13:07:52',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Crustacean',
                'is_active' => 1,
                'category_id' => 2,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:09:58',
                'updated_at' => '2026-02-12 13:09:58',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Mollusk',
                'is_active' => 1,
                'category_id' => 2,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:12:00',
                'updated_at' => '2026-02-12 13:12:00',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Echinoderms',
                'is_active' => 1,
                'category_id' => 2,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:14:57',
                'updated_at' => '2026-02-12 13:14:57',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Algae and Seaweeds',
                'is_active' => 1,
                'category_id' => 2,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:16:16',
                'updated_at' => '2026-02-12 13:16:16',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Dairy and Dairy-Based Products',
                'is_active' => 1,
                'category_id' => 2,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:17:47',
                'updated_at' => '2026-02-12 13:17:47',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Insect-Based  and other Exotic Food',
                'is_active' => 1,
                'category_id' => 2,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:18:46',
                'updated_at' => '2026-02-12 13:18:46',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Animal Fats and Oils',
                'is_active' => 1,
                'category_id' => 2,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:21:03',
                'updated_at' => '2026-02-12 13:21:03',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Eggs and Egg Products',
                'is_active' => 1,
                'category_id' => 2,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:22:14',
                'updated_at' => '2026-02-12 13:22:14',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Complete, Plant-Based, Animal-Based',
                'is_active' => 1,
                'category_id' => 3,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:23:11',
                'updated_at' => '2026-02-12 13:23:11',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Cereal and Cereal-Based Products',
                'is_active' => 1,
                'category_id' => 4,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:26:18',
                'updated_at' => '2026-02-12 13:26:18',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Fruits and Vegetables',
                'is_active' => 1,
                'category_id' => 4,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:27:39',
                'updated_at' => '2026-02-12 13:27:39',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Nuts and Oilseeds',
                'is_active' => 1,
                'category_id' => 4,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:29:55',
                'updated_at' => '2026-02-12 13:29:55',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Plant-Based Oils and Fats',
                'is_active' => 1,
                'category_id' => 4,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:31:01',
                'updated_at' => '2026-02-12 13:31:01',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Cacao and Cacao Products',
                'is_active' => 1,
                'category_id' => 4,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:31:37',
                'updated_at' => '2026-02-12 13:31:37',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Sugars and Sweeteners',
                'is_active' => 1,
                'category_id' => 4,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:32:36',
                'updated_at' => '2026-02-12 13:32:36',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Spices and Seasonings',
                'is_active' => 1,
                'category_id' => 5,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:34:03',
                'updated_at' => '2026-02-12 13:34:03',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Condimentd and Sauces',
                'is_active' => 1,
                'category_id' => 5,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:35:42',
                'updated_at' => '2026-02-12 13:35:42',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Mineral-Based Food Products',
                'is_active' => 1,
                'category_id' => 5,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:39:09',
                'updated_at' => '2026-02-12 13:39:09',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Non-Dairy and Non-Alcoholic',
                'is_active' => 1,
                'category_id' => 6,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:40:15',
                'updated_at' => '2026-02-12 13:40:15',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'Alcoholic Beverage',
                'is_active' => 1,
                'category_id' => 6,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:41:46',
                'updated_at' => '2026-02-12 13:41:46',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Dairy–Based Beverage',
                'is_active' => 1,
                'category_id' => 6,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:43:17',
                'updated_at' => '2026-02-12 13:43:17',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'Brewed Products',
                'is_active' => 1,
                'category_id' => 6,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:44:48',
                'updated_at' => '2026-02-12 13:44:48',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'Water-Based Beverages',
                'is_active' => 1,
                'category_id' => 6,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:46:12',
                'updated_at' => '2026-02-12 13:46:12',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'Drinking/Potable Water',
                'is_active' => 1,
                'category_id' => 7,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:47:22',
                'updated_at' => '2026-02-12 13:47:22',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'Process Water',
                'is_active' => 1,
                'category_id' => 7,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:48:43',
                'updated_at' => '2026-02-12 13:48:43',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'Wastewater',
                'is_active' => 1,
                'category_id' => 7,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:49:49',
                'updated_at' => '2026-02-12 13:49:49',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'Environmental Water',
                'is_active' => 1,
                'category_id' => 7,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:51:13',
                'updated_at' => '2026-02-12 13:51:13',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'Fuel and Energy Materials',
                'is_active' => 1,
                'category_id' => 8,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:54:03',
                'updated_at' => '2026-02-12 13:54:03',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'Plant and Plant Extracts',
                'is_active' => 1,
                'category_id' => 8,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:54:46',
                'updated_at' => '2026-02-12 13:54:46',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'Fertilizers and Soil Amendments',
                'is_active' => 1,
                'category_id' => 8,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:56:51',
                'updated_at' => '2026-02-12 13:56:51',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'Industrial and Consumer Chemical Products',
                'is_active' => 1,
                'category_id' => 8,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:57:47',
                'updated_at' => '2026-02-12 13:57:47',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'Food',
                'is_active' => 1,
                'category_id' => 9,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 14:01:21',
                'updated_at' => '2026-02-12 14:01:21',
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'Test Weight',
                'is_active' => 1,
                'category_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:30:32',
                'updated_at' => '2026-02-13 16:30:32',
            ),
            36 => 
            array (
                'id' => 37,
            'name' => 'Non-Automatic Weighing Instrument (NAWI)',
                'is_active' => 1,
                'category_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:33:08',
                'updated_at' => '2026-02-13 16:33:08',
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'Contact Thermometer',
                'is_active' => 1,
                'category_id' => 11,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:36:28',
                'updated_at' => '2026-02-13 16:36:28',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'Non-Contact Thermometer',
                'is_active' => 1,
                'category_id' => 11,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:39:30',
                'updated_at' => '2026-02-13 16:39:30',
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'Climatic Chamber',
                'is_active' => 1,
                'category_id' => 11,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:40:21',
                'updated_at' => '2026-02-13 16:40:21',
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'Thermo-Hygrometer',
                'is_active' => 1,
                'category_id' => 12,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:42:36',
                'updated_at' => '2026-02-13 16:42:36',
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'Thermometer',
                'is_active' => 1,
                'category_id' => 12,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:43:17',
                'updated_at' => '2026-02-13 16:43:17',
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'Hygrometer',
                'is_active' => 1,
                'category_id' => 12,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:43:59',
                'updated_at' => '2026-02-13 16:43:59',
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'Plastic and Glassware',
                'is_active' => 1,
                'category_id' => 13,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:44:41',
                'updated_at' => '2026-02-13 16:44:41',
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'Piston Operated Volumetric Apparatus',
                'is_active' => 1,
                'category_id' => 13,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:47:51',
                'updated_at' => '2026-02-13 16:47:51',
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'Test Measure',
                'is_active' => 1,
                'category_id' => 13,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:49:07',
                'updated_at' => '2026-02-13 16:49:07',
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'Proving Tank',
                'is_active' => 1,
                'category_id' => 13,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:49:30',
                'updated_at' => '2026-02-13 16:49:30',
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'Road Tanker',
                'is_active' => 1,
                'category_id' => 13,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:49:57',
                'updated_at' => '2026-02-13 16:49:57',
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'Fuel Dispenser',
                'is_active' => 1,
                'category_id' => 13,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:50:53',
                'updated_at' => '2026-02-13 16:50:53',
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'Positive Pressure Gauge',
                'is_active' => 1,
                'category_id' => 14,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:51:46',
                'updated_at' => '2026-02-13 16:51:46',
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'Negative Pressure Gauge',
                'is_active' => 1,
                'category_id' => 14,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:53:08',
                'updated_at' => '2026-02-13 16:53:08',
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'Sphygmomanometer',
                'is_active' => 1,
                'category_id' => 14,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:54:12',
                'updated_at' => '2026-02-13 16:54:12',
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'Electrical Multimeter',
                'is_active' => 1,
                'category_id' => 15,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:54:40',
                'updated_at' => '2026-02-13 16:54:40',
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'pH Meter',
                'is_active' => 1,
                'category_id' => 15,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:56:20',
                'updated_at' => '2026-02-13 16:56:20',
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'Tachometer',
                'is_active' => 1,
                'category_id' => 15,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:56:49',
                'updated_at' => '2026-02-13 16:56:49',
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'Rule',
                'is_active' => 1,
                'category_id' => 16,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:57:25',
                'updated_at' => '2026-02-13 16:57:25',
            ),
            56 => 
            array (
                'id' => 57,
                'name' => 'External Micrometer',
                'is_active' => 1,
                'category_id' => 16,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:58:34',
                'updated_at' => '2026-02-13 16:58:34',
            ),
            57 => 
            array (
                'id' => 58,
                'name' => 'Caliper',
                'is_active' => 1,
                'category_id' => 16,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 17:05:14',
                'updated_at' => '2026-02-13 17:05:14',
            ),
        ));
        
        
    }
}