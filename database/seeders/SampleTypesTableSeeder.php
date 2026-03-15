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
            0 => array (
                'id' => 1,
                'name' => 'n/a',
                'is_active' => 1,
                'category_id' => 1,
                'user_id' => 1,
                'agency_id' => 14,
                'created_at' => '2026-02-12 11:20:59',
                'updated_at' => '2026-02-12 11:20:59',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Raw Natural Rubber',
                'is_active' => 1,
                'category_id' => 2,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 11:20:59',
                'updated_at' => '2026-02-12 11:20:59',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Meat',
                'is_active' => 1,
                'category_id' => 3,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:03:47',
                'updated_at' => '2026-02-12 13:03:47',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Fish',
                'is_active' => 1,
                'category_id' => 3,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:07:52',
                'updated_at' => '2026-02-12 13:07:52',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Crustacean',
                'is_active' => 1,
                'category_id' => 3,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:09:58',
                'updated_at' => '2026-02-12 13:09:58',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Mollusk',
                'is_active' => 1,
                'category_id' => 3,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:12:00',
                'updated_at' => '2026-02-12 13:12:00',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Echinoderms',
                'is_active' => 1,
                'category_id' => 3,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:14:57',
                'updated_at' => '2026-02-12 13:14:57',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Algae and Seaweeds',
                'is_active' => 1,
                'category_id' => 3,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:16:16',
                'updated_at' => '2026-02-12 13:16:16',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Dairy and Dairy-Based Products',
                'is_active' => 1,
                'category_id' => 3,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:17:47',
                'updated_at' => '2026-02-12 13:17:47',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Insect-Based  and other Exotic Food',
                'is_active' => 1,
                'category_id' => 3,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:18:46',
                'updated_at' => '2026-02-12 13:18:46',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Animal Fats and Oils',
                'is_active' => 1,
                'category_id' => 3,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:21:03',
                'updated_at' => '2026-02-12 13:21:03',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Eggs and Egg Products',
                'is_active' => 1,
                'category_id' => 3,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:22:14',
                'updated_at' => '2026-02-12 13:22:14',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Complete, Plant-Based, Animal-Based',
                'is_active' => 1,
                'category_id' => 4,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:23:11',
                'updated_at' => '2026-02-12 13:23:11',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Cereal and Cereal-Based Products',
                'is_active' => 1,
                'category_id' => 5,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:26:18',
                'updated_at' => '2026-02-12 13:26:18',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Fruits and Vegetables',
                'is_active' => 1,
                'category_id' => 5,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:27:39',
                'updated_at' => '2026-02-12 13:27:39',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Nuts and Oilseeds',
                'is_active' => 1,
                'category_id' => 5,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:29:55',
                'updated_at' => '2026-02-12 13:29:55',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Plant-Based Oils and Fats',
                'is_active' => 1,
                'category_id' => 5,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:31:01',
                'updated_at' => '2026-02-12 13:31:01',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Cacao and Cacao Products',
                'is_active' => 1,
                'category_id' => 5,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:31:37',
                'updated_at' => '2026-02-12 13:31:37',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Sugars and Sweeteners',
                'is_active' => 1,
                'category_id' => 5,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:32:36',
                'updated_at' => '2026-02-12 13:32:36',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Spices and Seasonings',
                'is_active' => 1,
                'category_id' => 6,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:34:03',
                'updated_at' => '2026-02-12 13:34:03',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Condimentd and Sauces',
                'is_active' => 1,
                'category_id' => 6,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:35:42',
                'updated_at' => '2026-02-12 13:35:42',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Mineral-Based Food Products',
                'is_active' => 1,
                'category_id' => 6,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:39:09',
                'updated_at' => '2026-02-12 13:39:09',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'Non-Dairy and Non-Alcoholic',
                'is_active' => 1,
                'category_id' => 7,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:40:15',
                'updated_at' => '2026-02-12 13:40:15',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Alcoholic Beverage',
                'is_active' => 1,
                'category_id' => 7,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:41:46',
                'updated_at' => '2026-02-12 13:41:46',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'Dairy–Based Beverage',
                'is_active' => 1,
                'category_id' => 7,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:43:17',
                'updated_at' => '2026-02-12 13:43:17',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'Brewed Products',
                'is_active' => 1,
                'category_id' => 7,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:44:48',
                'updated_at' => '2026-02-12 13:44:48',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'Water-Based Beverages',
                'is_active' => 1,
                'category_id' => 7,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:46:12',
                'updated_at' => '2026-02-12 13:46:12',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'Drinking/Potable Water',
                'is_active' => 1,
                'category_id' => 8,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:47:22',
                'updated_at' => '2026-02-12 13:47:22',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'Process Water',
                'is_active' => 1,
                'category_id' => 8,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:48:43',
                'updated_at' => '2026-02-12 13:48:43',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'Wastewater',
                'is_active' => 1,
                'category_id' => 8,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:49:49',
                'updated_at' => '2026-02-12 13:49:49',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'Environmental Water',
                'is_active' => 1,
                'category_id' => 8,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:51:13',
                'updated_at' => '2026-02-12 13:51:13',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'Fuel and Energy Materials',
                'is_active' => 1,
                'category_id' => 9,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:54:03',
                'updated_at' => '2026-02-12 13:54:03',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'Plant and Plant Extracts',
                'is_active' => 1,
                'category_id' => 9,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:54:46',
                'updated_at' => '2026-02-12 13:54:46',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'Fertilizers and Soil Amendments',
                'is_active' => 1,
                'category_id' => 9,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:56:51',
                'updated_at' => '2026-02-12 13:56:51',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'Industrial and Consumer Chemical Products',
                'is_active' => 1,
                'category_id' => 9,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 13:57:47',
                'updated_at' => '2026-02-12 13:57:47',
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'Food',
                'is_active' => 1,
                'category_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-12 14:01:21',
                'updated_at' => '2026-02-12 14:01:21',
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'Test Weight',
                'is_active' => 1,
                'category_id' => 11,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:30:32',
                'updated_at' => '2026-02-13 16:30:32',
            ),
            37 => 
            array (
                'id' => 38,
            'name' => 'Non-Automatic Weighing Instrument (NAWI)',
                'is_active' => 1,
                'category_id' => 11,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:33:08',
                'updated_at' => '2026-02-13 16:33:08',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'Contact Thermometer',
                'is_active' => 1,
                'category_id' => 12,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:36:28',
                'updated_at' => '2026-02-13 16:36:28',
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'Non-Contact Thermometer',
                'is_active' => 1,
                'category_id' => 12,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:39:30',
                'updated_at' => '2026-02-13 16:39:30',
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'Climatic Chamber',
                'is_active' => 1,
                'category_id' => 12,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:40:21',
                'updated_at' => '2026-02-13 16:40:21',
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'Thermo-Hygrometer',
                'is_active' => 1,
                'category_id' => 13,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:42:36',
                'updated_at' => '2026-02-13 16:42:36',
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'Thermometer',
                'is_active' => 1,
                'category_id' => 13,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:43:17',
                'updated_at' => '2026-02-13 16:43:17',
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'Hygrometer',
                'is_active' => 1,
                'category_id' => 13,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:43:59',
                'updated_at' => '2026-02-13 16:43:59',
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'Plastic and Glassware',
                'is_active' => 1,
                'category_id' => 14,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:44:41',
                'updated_at' => '2026-02-13 16:44:41',
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'Piston Operated Volumetric Apparatus',
                'is_active' => 1,
                'category_id' => 14,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:47:51',
                'updated_at' => '2026-02-13 16:47:51',
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'Test Measure',
                'is_active' => 1,
                'category_id' => 14,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:49:07',
                'updated_at' => '2026-02-13 16:49:07',
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'Proving Tank',
                'is_active' => 1,
                'category_id' => 14,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:49:30',
                'updated_at' => '2026-02-13 16:49:30',
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'Road Tanker',
                'is_active' => 1,
                'category_id' => 14,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:49:57',
                'updated_at' => '2026-02-13 16:49:57',
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'Fuel Dispenser',
                'is_active' => 1,
                'category_id' => 14,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:50:53',
                'updated_at' => '2026-02-13 16:50:53',
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'Positive Pressure Gauge',
                'is_active' => 1,
                'category_id' => 15,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:51:46',
                'updated_at' => '2026-02-13 16:51:46',
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'Negative Pressure Gauge',
                'is_active' => 1,
                'category_id' => 15,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:53:08',
                'updated_at' => '2026-02-13 16:53:08',
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'Sphygmomanometer',
                'is_active' => 1,
                'category_id' => 15,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:54:12',
                'updated_at' => '2026-02-13 16:54:12',
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'Electrical Multimeter',
                'is_active' => 1,
                'category_id' => 16,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:54:40',
                'updated_at' => '2026-02-13 16:54:40',
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'pH Meter',
                'is_active' => 1,
                'category_id' => 16,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:56:20',
                'updated_at' => '2026-02-13 16:56:20',
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'Tachometer',
                'is_active' => 1,
                'category_id' => 16,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:56:49',
                'updated_at' => '2026-02-13 16:56:49',
            ),
            56 => 
            array (
                'id' => 57,
                'name' => 'Rule',
                'is_active' => 1,
                'category_id' => 17,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:57:25',
                'updated_at' => '2026-02-13 16:57:25',
            ),
            57 => 
            array (
                'id' => 58,
                'name' => 'External Micrometer',
                'is_active' => 1,
                'category_id' => 17,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 16:58:34',
                'updated_at' => '2026-02-13 16:58:34',
            ),
            58 => 
            array (
                'id' => 59,
                'name' => 'Caliper',
                'is_active' => 1,
                'category_id' => 17,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-02-13 17:05:14',
                'updated_at' => '2026-02-13 17:05:14',
            ),
            59 => 
            array (
                'id' => 60,
                'name' => 'Milk and Dairy',
                'is_active' => 1,
                'category_id' => 18,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-03-14 14:41:07',
                'updated_at' => '2026-03-14 14:41:07',
            ),
            60 => 
            array (
                'id' => 61,
                'name' => 'Cereal and Cereal/Legume-Based Products',
                'is_active' => 1,
                'category_id' => 18,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-03-14 14:47:33',
                'updated_at' => '2026-03-14 14:47:33',
            ),
            61 => 
            array (
                'id' => 62,
                'name' => 'Pasta Products & Noddles Uncooked',
                'is_active' => 1,
                'category_id' => 18,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-03-14 14:49:32',
                'updated_at' => '2026-03-14 14:49:32',
            ),
            62 => 
            array (
                'id' => 63,
                'name' => 'Bakery Products',
                'is_active' => 1,
                'category_id' => 18,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-03-14 14:50:21',
                'updated_at' => '2026-03-14 14:50:21',
            ),
            63 => 
            array (
                'id' => 64,
                'name' => 'Ready-to-Eat Savories',
                'is_active' => 1,
                'category_id' => 18,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-03-14 14:51:12',
                'updated_at' => '2026-03-14 14:51:12',
            ),
            64 => 
            array (
                'id' => 65,
                'name' => 'Meat and Poultry Products',
                'is_active' => 1,
                'category_id' => 18,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-03-14 14:51:49',
                'updated_at' => '2026-03-14 14:51:49',
            ),
            65 => 
            array (
                'id' => 66,
                'name' => 'Fish and Other Seafood Products',
                'is_active' => 1,
                'category_id' => 18,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-03-14 14:52:59',
                'updated_at' => '2026-03-14 14:52:59',
            ),
            66 => 
            array (
                'id' => 67,
                'name' => 'Spices, Soups, Salads and Proteins Products',
                'is_active' => 1,
                'category_id' => 18,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-03-14 14:54:13',
                'updated_at' => '2026-03-14 14:54:13',
            ),
            67 => 
            array (
                'id' => 68,
                'name' => 'Fats, Oils and Fat Emulsion',
                'is_active' => 1,
                'category_id' => 18,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-03-14 14:55:03',
                'updated_at' => '2026-03-14 14:55:03',
            ),
            68 => 
            array (
                'id' => 69,
                'name' => 'Edible Ices, Including Sherbet and Sorbet',
                'is_active' => 1,
                'category_id' => 18,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-03-14 14:55:47',
                'updated_at' => '2026-03-14 14:55:47',
            ),
            69 => 
            array (
                'id' => 70,
                'name' => 'Confectionaries',
                'is_active' => 1,
                'category_id' => 18,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-03-14 14:56:38',
                'updated_at' => '2026-03-14 14:56:38',
            ),
            70 => 
            array (
                'id' => 71,
                'name' => 'Fruits and Vegetables, Nuts and Seeds',
                'is_active' => 1,
                'category_id' => 18,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-03-14 14:57:45',
                'updated_at' => '2026-03-14 14:57:45',
            ),
            71 => 
            array (
                'id' => 72,
                'name' => 'Food for Infants and Young Children',
                'is_active' => 1,
                'category_id' => 18,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-03-14 14:58:48',
                'updated_at' => '2026-03-14 14:58:48',
            ),
            72 => 
            array (
                'id' => 73,
                'name' => 'Animal and Marine Protein Source',
                'is_active' => 1,
                'category_id' => 18,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-03-14 14:59:45',
                'updated_at' => '2026-03-14 14:59:45',
            ),
            73 => 
            array (
                'id' => 74,
                'name' => 'Beverages',
                'is_active' => 1,
                'category_id' => 18,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-03-14 15:00:33',
                'updated_at' => '2026-03-14 15:00:33',
            ),
            74 => 
            array (
                'id' => 75,
                'name' => 'Water',
                'is_active' => 1,
                'category_id' => 19,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-03-14 15:01:32',
                'updated_at' => '2026-03-14 15:01:32',
            ),
            75 => 
            array (
                'id' => 76,
                'name' => 'Swab',
                'is_active' => 1,
                'category_id' => 19,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-03-14 15:02:19',
                'updated_at' => '2026-03-14 15:02:19',
            ),
            76 => 
            array (
                'id' => 77,
                'name' => 'Air Sample',
                'is_active' => 1,
                'category_id' => 19,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-03-14 15:02:47',
                'updated_at' => '2026-03-14 15:02:47',
            ),
            77 => 
            array (
                'id' => 78,
                'name' => 'Plant Extracts',
                'is_active' => 1,
                'category_id' => 20,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-03-14 15:03:07',
                'updated_at' => '2026-03-14 15:03:07',
            ),
        ));
        
        
    }
}