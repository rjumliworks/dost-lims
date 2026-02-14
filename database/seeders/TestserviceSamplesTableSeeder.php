<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TestserviceSamplesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('testservice_samples')->delete();
        
        \DB::table('testservice_samples')->insert(array (
            0 => 
            array (
                'id' => 1,
                'sampleable_id' => 1,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 1,
                'added_by' => 2,
                'created_at' => '2026-02-12 11:34:59',
                'updated_at' => '2026-02-12 11:34:59',
            ),
            1 => 
            array (
                'id' => 2,
                'sampleable_id' => 1,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 2,
                'added_by' => 2,
                'created_at' => '2026-02-12 11:35:10',
                'updated_at' => '2026-02-12 11:35:10',
            ),
            2 => 
            array (
                'id' => 3,
                'sampleable_id' => 1,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 3,
                'added_by' => 2,
                'created_at' => '2026-02-12 11:35:21',
                'updated_at' => '2026-02-12 11:35:21',
            ),
            3 => 
            array (
                'id' => 4,
                'sampleable_id' => 1,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 7,
                'added_by' => 2,
                'created_at' => '2026-02-12 11:35:32',
                'updated_at' => '2026-02-12 11:35:32',
            ),
            4 => 
            array (
                'id' => 5,
                'sampleable_id' => 1,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 5,
                'added_by' => 2,
                'created_at' => '2026-02-12 11:35:43',
                'updated_at' => '2026-02-12 11:35:43',
            ),
            5 => 
            array (
                'id' => 6,
                'sampleable_id' => 1,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 6,
                'added_by' => 2,
                'created_at' => '2026-02-12 11:35:52',
                'updated_at' => '2026-02-12 11:35:52',
            ),
            6 => 
            array (
                'id' => 7,
                'sampleable_id' => 1,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 4,
                'added_by' => 2,
                'created_at' => '2026-02-12 11:36:00',
                'updated_at' => '2026-02-12 11:36:00',
            ),
            7 => 
            array (
                'id' => 8,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 8,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            8 => 
            array (
                'id' => 9,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 9,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            9 => 
            array (
                'id' => 10,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 10,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            10 => 
            array (
                'id' => 11,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 11,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            11 => 
            array (
                'id' => 12,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 12,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            12 => 
            array (
                'id' => 13,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 13,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            13 => 
            array (
                'id' => 14,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 14,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            14 => 
            array (
                'id' => 15,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 15,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            15 => 
            array (
                'id' => 16,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 16,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            16 => 
            array (
                'id' => 17,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 17,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            17 => 
            array (
                'id' => 18,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 18,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            18 => 
            array (
                'id' => 19,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 19,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            19 => 
            array (
                'id' => 20,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 20,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            20 => 
            array (
                'id' => 21,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 21,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            21 => 
            array (
                'id' => 22,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 22,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            22 => 
            array (
                'id' => 23,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 23,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            23 => 
            array (
                'id' => 24,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 24,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            24 => 
            array (
                'id' => 25,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 25,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            25 => 
            array (
                'id' => 26,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 26,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            26 => 
            array (
                'id' => 27,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 27,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            27 => 
            array (
                'id' => 28,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 28,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            28 => 
            array (
                'id' => 29,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 29,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            29 => 
            array (
                'id' => 30,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 30,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            30 => 
            array (
                'id' => 31,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 31,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            31 => 
            array (
                'id' => 32,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 32,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            32 => 
            array (
                'id' => 33,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 33,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            33 => 
            array (
                'id' => 34,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 34,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            34 => 
            array (
                'id' => 35,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 35,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            35 => 
            array (
                'id' => 36,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 36,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            36 => 
            array (
                'id' => 37,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 37,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            37 => 
            array (
                'id' => 38,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 38,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            38 => 
            array (
                'id' => 39,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 39,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            39 => 
            array (
                'id' => 40,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 40,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            40 => 
            array (
                'id' => 41,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 41,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            41 => 
            array (
                'id' => 42,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 42,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            42 => 
            array (
                'id' => 43,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 43,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            43 => 
            array (
                'id' => 44,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 44,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            44 => 
            array (
                'id' => 45,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 45,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            45 => 
            array (
                'id' => 46,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 46,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            46 => 
            array (
                'id' => 47,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 47,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            47 => 
            array (
                'id' => 48,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 48,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            48 => 
            array (
                'id' => 49,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 49,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            49 => 
            array (
                'id' => 50,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 50,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            50 => 
            array (
                'id' => 51,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 51,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            51 => 
            array (
                'id' => 52,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 52,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            52 => 
            array (
                'id' => 53,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 53,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            53 => 
            array (
                'id' => 54,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 54,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:17',
                'updated_at' => '2026-02-14 06:30:17',
            ),
            54 => 
            array (
                'id' => 55,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 55,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            55 => 
            array (
                'id' => 56,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 56,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            56 => 
            array (
                'id' => 57,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 57,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            57 => 
            array (
                'id' => 58,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 58,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            58 => 
            array (
                'id' => 59,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 59,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            59 => 
            array (
                'id' => 60,
                'sampleable_id' => 13,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 66,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            60 => 
            array (
                'id' => 61,
                'sampleable_id' => 13,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 67,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            61 => 
            array (
                'id' => 62,
                'sampleable_id' => 13,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 68,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            62 => 
            array (
                'id' => 63,
                'sampleable_id' => 13,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 69,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            63 => 
            array (
                'id' => 64,
                'sampleable_id' => 13,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 70,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            64 => 
            array (
                'id' => 65,
                'sampleable_id' => 13,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 71,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            65 => 
            array (
                'id' => 66,
                'sampleable_id' => 13,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 72,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            66 => 
            array (
                'id' => 67,
                'sampleable_id' => 13,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 73,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            67 => 
            array (
                'id' => 68,
                'sampleable_id' => 13,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 74,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            68 => 
            array (
                'id' => 69,
                'sampleable_id' => 13,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 75,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            69 => 
            array (
                'id' => 70,
                'sampleable_id' => 13,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 76,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            70 => 
            array (
                'id' => 71,
                'sampleable_id' => 13,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 77,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            71 => 
            array (
                'id' => 72,
                'sampleable_id' => 13,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 78,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            72 => 
            array (
                'id' => 73,
                'sampleable_id' => 13,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 79,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            73 => 
            array (
                'id' => 74,
                'sampleable_id' => 14,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 80,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            74 => 
            array (
                'id' => 75,
                'sampleable_id' => 14,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 81,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            75 => 
            array (
                'id' => 76,
                'sampleable_id' => 14,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 82,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            76 => 
            array (
                'id' => 77,
                'sampleable_id' => 14,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 83,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            77 => 
            array (
                'id' => 78,
                'sampleable_id' => 14,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 84,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            78 => 
            array (
                'id' => 79,
                'sampleable_id' => 14,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 85,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            79 => 
            array (
                'id' => 80,
                'sampleable_id' => 14,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 86,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            80 => 
            array (
                'id' => 81,
                'sampleable_id' => 14,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 87,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            81 => 
            array (
                'id' => 82,
                'sampleable_id' => 14,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 88,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            82 => 
            array (
                'id' => 83,
                'sampleable_id' => 15,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 89,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            83 => 
            array (
                'id' => 84,
                'sampleable_id' => 15,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 90,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            84 => 
            array (
                'id' => 85,
                'sampleable_id' => 15,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 91,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            85 => 
            array (
                'id' => 86,
                'sampleable_id' => 15,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 92,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:18',
                'updated_at' => '2026-02-14 06:30:18',
            ),
            86 => 
            array (
                'id' => 87,
                'sampleable_id' => 16,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 93,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            87 => 
            array (
                'id' => 88,
                'sampleable_id' => 16,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 94,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            88 => 
            array (
                'id' => 89,
                'sampleable_id' => 17,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 95,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            89 => 
            array (
                'id' => 90,
                'sampleable_id' => 17,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 96,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            90 => 
            array (
                'id' => 91,
                'sampleable_id' => 17,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 97,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            91 => 
            array (
                'id' => 92,
                'sampleable_id' => 18,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 98,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            92 => 
            array (
                'id' => 93,
                'sampleable_id' => 18,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 99,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            93 => 
            array (
                'id' => 94,
                'sampleable_id' => 18,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 100,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            94 => 
            array (
                'id' => 95,
                'sampleable_id' => 18,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 101,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            95 => 
            array (
                'id' => 96,
                'sampleable_id' => 18,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 102,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            96 => 
            array (
                'id' => 97,
                'sampleable_id' => 18,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 103,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            97 => 
            array (
                'id' => 98,
                'sampleable_id' => 18,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 104,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            98 => 
            array (
                'id' => 99,
                'sampleable_id' => 18,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 105,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            99 => 
            array (
                'id' => 100,
                'sampleable_id' => 20,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 106,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            100 => 
            array (
                'id' => 101,
                'sampleable_id' => 20,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 107,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            101 => 
            array (
                'id' => 102,
                'sampleable_id' => 20,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 108,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            102 => 
            array (
                'id' => 103,
                'sampleable_id' => 20,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 109,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            103 => 
            array (
                'id' => 104,
                'sampleable_id' => 20,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 110,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            104 => 
            array (
                'id' => 105,
                'sampleable_id' => 20,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 111,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            105 => 
            array (
                'id' => 106,
                'sampleable_id' => 20,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 112,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            106 => 
            array (
                'id' => 107,
                'sampleable_id' => 20,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 113,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            107 => 
            array (
                'id' => 108,
                'sampleable_id' => 22,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 116,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            108 => 
            array (
                'id' => 109,
                'sampleable_id' => 22,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 117,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            109 => 
            array (
                'id' => 110,
                'sampleable_id' => 22,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 118,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            110 => 
            array (
                'id' => 111,
                'sampleable_id' => 22,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 119,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            111 => 
            array (
                'id' => 112,
                'sampleable_id' => 23,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 120,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            112 => 
            array (
                'id' => 113,
                'sampleable_id' => 23,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 121,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            113 => 
            array (
                'id' => 114,
                'sampleable_id' => 24,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 122,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            114 => 
            array (
                'id' => 115,
                'sampleable_id' => 24,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 123,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            115 => 
            array (
                'id' => 116,
                'sampleable_id' => 24,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 124,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            116 => 
            array (
                'id' => 117,
                'sampleable_id' => 24,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 125,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            117 => 
            array (
                'id' => 118,
                'sampleable_id' => 24,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 126,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            118 => 
            array (
                'id' => 119,
                'sampleable_id' => 24,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 127,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:19',
                'updated_at' => '2026-02-14 06:30:19',
            ),
            119 => 
            array (
                'id' => 120,
                'sampleable_id' => 24,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 128,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            120 => 
            array (
                'id' => 121,
                'sampleable_id' => 24,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 129,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            121 => 
            array (
                'id' => 122,
                'sampleable_id' => 25,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 130,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            122 => 
            array (
                'id' => 123,
                'sampleable_id' => 25,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 131,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            123 => 
            array (
                'id' => 124,
                'sampleable_id' => 25,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 132,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            124 => 
            array (
                'id' => 125,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 133,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            125 => 
            array (
                'id' => 126,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 134,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            126 => 
            array (
                'id' => 127,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 135,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            127 => 
            array (
                'id' => 128,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 136,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            128 => 
            array (
                'id' => 129,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 137,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            129 => 
            array (
                'id' => 130,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 138,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            130 => 
            array (
                'id' => 131,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 139,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            131 => 
            array (
                'id' => 132,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 140,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            132 => 
            array (
                'id' => 133,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 141,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            133 => 
            array (
                'id' => 134,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 142,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            134 => 
            array (
                'id' => 135,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 143,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            135 => 
            array (
                'id' => 136,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 144,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            136 => 
            array (
                'id' => 137,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 145,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            137 => 
            array (
                'id' => 138,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 146,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            138 => 
            array (
                'id' => 139,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 147,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            139 => 
            array (
                'id' => 140,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 148,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            140 => 
            array (
                'id' => 141,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 149,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            141 => 
            array (
                'id' => 142,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 150,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            142 => 
            array (
                'id' => 143,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 151,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            143 => 
            array (
                'id' => 144,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 152,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            144 => 
            array (
                'id' => 145,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 153,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            145 => 
            array (
                'id' => 146,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 154,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            146 => 
            array (
                'id' => 147,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 155,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            147 => 
            array (
                'id' => 148,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 156,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            148 => 
            array (
                'id' => 149,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 157,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            149 => 
            array (
                'id' => 150,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 158,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            150 => 
            array (
                'id' => 151,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 159,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            151 => 
            array (
                'id' => 152,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 160,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            152 => 
            array (
                'id' => 153,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 161,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            153 => 
            array (
                'id' => 154,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 162,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            154 => 
            array (
                'id' => 155,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 163,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            155 => 
            array (
                'id' => 156,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 164,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            156 => 
            array (
                'id' => 157,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 165,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            157 => 
            array (
                'id' => 158,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 166,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            158 => 
            array (
                'id' => 159,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 167,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            159 => 
            array (
                'id' => 160,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 168,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            160 => 
            array (
                'id' => 161,
                'sampleable_id' => 26,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 169,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            161 => 
            array (
                'id' => 162,
                'sampleable_id' => 29,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 170,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            162 => 
            array (
                'id' => 163,
                'sampleable_id' => 30,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 171,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            163 => 
            array (
                'id' => 164,
                'sampleable_id' => 30,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 172,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            164 => 
            array (
                'id' => 165,
                'sampleable_id' => 30,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 173,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            165 => 
            array (
                'id' => 166,
                'sampleable_id' => 30,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 174,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            166 => 
            array (
                'id' => 167,
                'sampleable_id' => 30,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 175,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            167 => 
            array (
                'id' => 168,
                'sampleable_id' => 30,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 176,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            168 => 
            array (
                'id' => 169,
                'sampleable_id' => 30,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 177,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            169 => 
            array (
                'id' => 170,
                'sampleable_id' => 30,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 178,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            170 => 
            array (
                'id' => 171,
                'sampleable_id' => 31,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 179,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            171 => 
            array (
                'id' => 172,
                'sampleable_id' => 31,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 180,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            172 => 
            array (
                'id' => 173,
                'sampleable_id' => 31,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 181,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            173 => 
            array (
                'id' => 174,
                'sampleable_id' => 31,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 182,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            174 => 
            array (
                'id' => 175,
                'sampleable_id' => 32,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 183,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:20',
                'updated_at' => '2026-02-14 06:30:20',
            ),
            175 => 
            array (
                'id' => 176,
                'sampleable_id' => 32,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 184,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:21',
                'updated_at' => '2026-02-14 06:30:21',
            ),
            176 => 
            array (
                'id' => 177,
                'sampleable_id' => 33,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 185,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:21',
                'updated_at' => '2026-02-14 06:30:21',
            ),
            177 => 
            array (
                'id' => 178,
                'sampleable_id' => 33,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 186,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:21',
                'updated_at' => '2026-02-14 06:30:21',
            ),
            178 => 
            array (
                'id' => 179,
                'sampleable_id' => 33,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 187,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:21',
                'updated_at' => '2026-02-14 06:30:21',
            ),
            179 => 
            array (
                'id' => 180,
                'sampleable_id' => 33,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 188,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:21',
                'updated_at' => '2026-02-14 06:30:21',
            ),
            180 => 
            array (
                'id' => 181,
                'sampleable_id' => 33,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 189,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:21',
                'updated_at' => '2026-02-14 06:30:21',
            ),
            181 => 
            array (
                'id' => 182,
                'sampleable_id' => 33,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 190,
                'added_by' => 2,
                'created_at' => '2026-02-14 06:30:21',
                'updated_at' => '2026-02-14 06:30:21',
            ),
            182 => 
            array (
                'id' => 183,
                'sampleable_id' => 169,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 191,
                'added_by' => 2,
                'created_at' => '2026-02-14 07:13:50',
                'updated_at' => '2026-02-14 07:13:50',
            ),
            183 => 
            array (
                'id' => 184,
                'sampleable_id' => 170,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 191,
                'added_by' => 2,
                'created_at' => '2026-02-14 07:13:50',
                'updated_at' => '2026-02-14 07:13:50',
            ),
            184 => 
            array (
                'id' => 185,
                'sampleable_id' => 169,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 192,
                'added_by' => 2,
                'created_at' => '2026-02-14 07:16:42',
                'updated_at' => '2026-02-14 07:16:42',
            ),
            185 => 
            array (
                'id' => 186,
                'sampleable_id' => 170,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 192,
                'added_by' => 2,
                'created_at' => '2026-02-14 07:16:42',
                'updated_at' => '2026-02-14 07:16:42',
            ),
            186 => 
            array (
                'id' => 187,
                'sampleable_id' => 169,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 193,
                'added_by' => 2,
                'created_at' => '2026-02-14 07:17:05',
                'updated_at' => '2026-02-14 07:17:05',
            ),
            187 => 
            array (
                'id' => 188,
                'sampleable_id' => 170,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 193,
                'added_by' => 2,
                'created_at' => '2026-02-14 07:17:05',
                'updated_at' => '2026-02-14 07:17:05',
            ),
            188 => 
            array (
                'id' => 189,
                'sampleable_id' => 169,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 194,
                'added_by' => 2,
                'created_at' => '2026-02-14 07:17:34',
                'updated_at' => '2026-02-14 07:17:34',
            ),
            189 => 
            array (
                'id' => 190,
                'sampleable_id' => 170,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 194,
                'added_by' => 2,
                'created_at' => '2026-02-14 07:17:34',
                'updated_at' => '2026-02-14 07:17:34',
            ),
            190 => 
            array (
                'id' => 191,
                'sampleable_id' => 171,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 195,
                'added_by' => 2,
                'created_at' => '2026-02-14 07:18:06',
                'updated_at' => '2026-02-14 07:18:06',
            ),
            191 => 
            array (
                'id' => 192,
                'sampleable_id' => 172,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 195,
                'added_by' => 2,
                'created_at' => '2026-02-14 07:18:06',
                'updated_at' => '2026-02-14 07:18:06',
            ),
            192 => 
            array (
                'id' => 193,
                'sampleable_id' => 171,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 196,
                'added_by' => 2,
                'created_at' => '2026-02-14 07:18:27',
                'updated_at' => '2026-02-14 07:18:27',
            ),
            193 => 
            array (
                'id' => 194,
                'sampleable_id' => 172,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 196,
                'added_by' => 2,
                'created_at' => '2026-02-14 07:18:27',
                'updated_at' => '2026-02-14 07:18:27',
            ),
            194 => 
            array (
                'id' => 195,
                'sampleable_id' => 171,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 197,
                'added_by' => 2,
                'created_at' => '2026-02-14 07:19:11',
                'updated_at' => '2026-02-14 07:19:11',
            ),
            195 => 
            array (
                'id' => 196,
                'sampleable_id' => 172,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 197,
                'added_by' => 2,
                'created_at' => '2026-02-14 07:19:11',
                'updated_at' => '2026-02-14 07:19:11',
            ),
            196 => 
            array (
                'id' => 197,
                'sampleable_id' => 37,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 198,
                'added_by' => 2,
                'created_at' => '2026-02-14 07:20:14',
                'updated_at' => '2026-02-14 07:20:14',
            ),
            197 => 
            array (
                'id' => 198,
                'sampleable_id' => 38,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 201,
                'added_by' => 2,
                'created_at' => '2026-02-14 07:22:49',
                'updated_at' => '2026-02-14 07:22:49',
            ),
            198 => 
            array (
                'id' => 199,
                'sampleable_id' => 39,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 202,
                'added_by' => 2,
                'created_at' => '2026-02-14 07:24:45',
                'updated_at' => '2026-02-14 07:24:45',
            ),
            199 => 
            array (
                'id' => 200,
                'sampleable_id' => 40,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 203,
                'added_by' => 2,
                'created_at' => '2026-02-14 07:27:42',
                'updated_at' => '2026-02-14 07:27:42',
            ),
            200 => 
            array (
                'id' => 201,
                'sampleable_id' => 40,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 204,
                'added_by' => 2,
                'created_at' => '2026-02-14 07:36:06',
                'updated_at' => '2026-02-14 07:36:06',
            ),
            201 => 
            array (
                'id' => 202,
                'sampleable_id' => 41,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 205,
                'added_by' => 2,
                'created_at' => '2026-02-14 07:39:04',
                'updated_at' => '2026-02-14 07:39:04',
            ),
            202 => 
            array (
                'id' => 203,
                'sampleable_id' => 41,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 206,
                'added_by' => 2,
                'created_at' => '2026-02-14 07:39:24',
                'updated_at' => '2026-02-14 07:39:24',
            ),
            203 => 
            array (
                'id' => 204,
                'sampleable_id' => 42,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 207,
                'added_by' => 2,
                'created_at' => '2026-02-14 07:41:20',
                'updated_at' => '2026-02-14 07:41:20',
            ),
            204 => 
            array (
                'id' => 205,
                'sampleable_id' => 43,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 205,
                'added_by' => 2,
                'created_at' => '2026-02-14 07:43:30',
                'updated_at' => '2026-02-14 07:43:30',
            ),
            205 => 
            array (
                'id' => 206,
                'sampleable_id' => 200,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 208,
                'added_by' => 2,
                'created_at' => '2026-02-14 08:03:18',
                'updated_at' => '2026-02-14 08:03:18',
            ),
            206 => 
            array (
                'id' => 207,
                'sampleable_id' => 201,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 209,
                'added_by' => 2,
                'created_at' => '2026-02-14 08:05:03',
                'updated_at' => '2026-02-14 08:05:03',
            ),
            207 => 
            array (
                'id' => 208,
                'sampleable_id' => 202,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 209,
                'added_by' => 2,
                'created_at' => '2026-02-14 08:05:03',
                'updated_at' => '2026-02-14 08:05:03',
            ),
            208 => 
            array (
                'id' => 209,
                'sampleable_id' => 203,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 209,
                'added_by' => 2,
                'created_at' => '2026-02-14 08:05:03',
                'updated_at' => '2026-02-14 08:05:03',
            ),
            209 => 
            array (
                'id' => 210,
                'sampleable_id' => 45,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 210,
                'added_by' => 2,
                'created_at' => '2026-02-14 08:06:11',
                'updated_at' => '2026-02-14 08:06:11',
            ),
            210 => 
            array (
                'id' => 211,
                'sampleable_id' => 46,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 213,
                'added_by' => 2,
                'created_at' => '2026-02-14 08:10:34',
                'updated_at' => '2026-02-14 08:10:34',
            ),
            211 => 
            array (
                'id' => 212,
                'sampleable_id' => 46,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 211,
                'added_by' => 2,
                'created_at' => '2026-02-14 08:10:43',
                'updated_at' => '2026-02-14 08:10:43',
            ),
            212 => 
            array (
                'id' => 213,
                'sampleable_id' => 46,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 214,
                'added_by' => 2,
                'created_at' => '2026-02-14 08:10:55',
                'updated_at' => '2026-02-14 08:10:55',
            ),
            213 => 
            array (
                'id' => 214,
                'sampleable_id' => 46,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 212,
                'added_by' => 2,
                'created_at' => '2026-02-14 08:11:03',
                'updated_at' => '2026-02-14 08:11:03',
            ),
            214 => 
            array (
                'id' => 215,
                'sampleable_id' => 47,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 215,
                'added_by' => 2,
                'created_at' => '2026-02-14 08:16:25',
                'updated_at' => '2026-02-14 08:16:25',
            ),
            215 => 
            array (
                'id' => 216,
                'sampleable_id' => 47,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 217,
                'added_by' => 2,
                'created_at' => '2026-02-14 08:16:32',
                'updated_at' => '2026-02-14 08:16:32',
            ),
            216 => 
            array (
                'id' => 217,
                'sampleable_id' => 47,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 216,
                'added_by' => 2,
                'created_at' => '2026-02-14 08:16:41',
                'updated_at' => '2026-02-14 08:16:41',
            ),
            217 => 
            array (
                'id' => 218,
                'sampleable_id' => 48,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 220,
                'added_by' => 2,
                'created_at' => '2026-02-14 08:31:00',
                'updated_at' => '2026-02-14 08:31:00',
            ),
            218 => 
            array (
                'id' => 219,
                'sampleable_id' => 48,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 221,
                'added_by' => 2,
                'created_at' => '2026-02-14 08:31:08',
                'updated_at' => '2026-02-14 08:31:08',
            ),
            219 => 
            array (
                'id' => 220,
                'sampleable_id' => 48,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 222,
                'added_by' => 2,
                'created_at' => '2026-02-14 08:31:18',
                'updated_at' => '2026-02-14 08:31:18',
            ),
            220 => 
            array (
                'id' => 221,
                'sampleable_id' => 48,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 219,
                'added_by' => 2,
                'created_at' => '2026-02-14 08:31:27',
                'updated_at' => '2026-02-14 08:31:27',
            ),
            221 => 
            array (
                'id' => 222,
                'sampleable_id' => 48,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 218,
                'added_by' => 2,
                'created_at' => '2026-02-14 08:31:35',
                'updated_at' => '2026-02-14 08:31:35',
            ),
            222 => 
            array (
                'id' => 223,
                'sampleable_id' => 48,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 223,
                'added_by' => 2,
                'created_at' => '2026-02-14 08:33:14',
                'updated_at' => '2026-02-14 08:33:14',
            ),
            223 => 
            array (
                'id' => 224,
                'sampleable_id' => 49,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 224,
                'added_by' => 2,
                'created_at' => '2026-02-14 08:46:14',
                'updated_at' => '2026-02-14 08:46:14',
            ),
            224 => 
            array (
                'id' => 225,
                'sampleable_id' => 50,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 226,
                'added_by' => 2,
                'created_at' => '2026-02-14 08:48:20',
                'updated_at' => '2026-02-14 08:48:20',
            ),
            225 => 
            array (
                'id' => 226,
                'sampleable_id' => 51,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 226,
                'added_by' => 2,
                'created_at' => '2026-02-14 08:48:30',
                'updated_at' => '2026-02-14 08:48:30',
            ),
            226 => 
            array (
                'id' => 227,
                'sampleable_id' => 52,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 227,
                'added_by' => 2,
                'created_at' => '2026-02-14 08:51:34',
                'updated_at' => '2026-02-14 08:51:34',
            ),
            227 => 
            array (
                'id' => 228,
                'sampleable_id' => 51,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 225,
                'added_by' => 2,
                'created_at' => '2026-02-14 08:52:42',
                'updated_at' => '2026-02-14 08:52:42',
            ),
            228 => 
            array (
                'id' => 229,
                'sampleable_id' => 50,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 225,
                'added_by' => 2,
                'created_at' => '2026-02-14 08:52:58',
                'updated_at' => '2026-02-14 08:52:58',
            ),
            229 => 
            array (
                'id' => 230,
                'sampleable_id' => 219,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 228,
                'added_by' => 2,
                'created_at' => '2026-02-14 09:05:42',
                'updated_at' => '2026-02-14 09:05:42',
            ),
            230 => 
            array (
                'id' => 231,
                'sampleable_id' => 219,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 229,
                'added_by' => 2,
                'created_at' => '2026-02-14 09:06:09',
                'updated_at' => '2026-02-14 09:06:09',
            ),
            231 => 
            array (
                'id' => 232,
                'sampleable_id' => 220,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 231,
                'added_by' => 2,
                'created_at' => '2026-02-14 09:56:57',
                'updated_at' => '2026-02-14 09:56:57',
            ),
            232 => 
            array (
                'id' => 233,
                'sampleable_id' => 220,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 230,
                'added_by' => 2,
                'created_at' => '2026-02-14 09:57:06',
                'updated_at' => '2026-02-14 09:57:06',
            ),
            233 => 
            array (
                'id' => 234,
                'sampleable_id' => 221,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 232,
                'added_by' => 2,
                'created_at' => '2026-02-14 09:59:05',
                'updated_at' => '2026-02-14 09:59:05',
            ),
            234 => 
            array (
                'id' => 235,
                'sampleable_id' => 222,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 233,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:00:17',
                'updated_at' => '2026-02-14 10:00:17',
            ),
            235 => 
            array (
                'id' => 236,
                'sampleable_id' => 223,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 234,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:03:05',
                'updated_at' => '2026-02-14 10:03:05',
            ),
            236 => 
            array (
                'id' => 237,
                'sampleable_id' => 223,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 235,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:03:18',
                'updated_at' => '2026-02-14 10:03:18',
            ),
            237 => 
            array (
                'id' => 238,
                'sampleable_id' => 224,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 236,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:07:30',
                'updated_at' => '2026-02-14 10:07:30',
            ),
            238 => 
            array (
                'id' => 239,
                'sampleable_id' => 224,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 240,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:07:40',
                'updated_at' => '2026-02-14 10:07:40',
            ),
            239 => 
            array (
                'id' => 240,
                'sampleable_id' => 224,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 238,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:07:52',
                'updated_at' => '2026-02-14 10:07:52',
            ),
            240 => 
            array (
                'id' => 241,
                'sampleable_id' => 224,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 237,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:08:21',
                'updated_at' => '2026-02-14 10:08:21',
            ),
            241 => 
            array (
                'id' => 242,
                'sampleable_id' => 224,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 241,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:08:30',
                'updated_at' => '2026-02-14 10:08:30',
            ),
            242 => 
            array (
                'id' => 243,
                'sampleable_id' => 224,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 239,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:08:39',
                'updated_at' => '2026-02-14 10:08:39',
            ),
            243 => 
            array (
                'id' => 244,
                'sampleable_id' => 225,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 242,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:20:08',
                'updated_at' => '2026-02-14 10:20:08',
            ),
            244 => 
            array (
                'id' => 245,
                'sampleable_id' => 226,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 243,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:22:38',
                'updated_at' => '2026-02-14 10:22:38',
            ),
            245 => 
            array (
                'id' => 246,
                'sampleable_id' => 226,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 244,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:22:45',
                'updated_at' => '2026-02-14 10:22:45',
            ),
            246 => 
            array (
                'id' => 247,
                'sampleable_id' => 227,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 245,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:26:14',
                'updated_at' => '2026-02-14 10:26:14',
            ),
            247 => 
            array (
                'id' => 248,
                'sampleable_id' => 228,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 247,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:35:24',
                'updated_at' => '2026-02-14 10:35:24',
            ),
            248 => 
            array (
                'id' => 249,
                'sampleable_id' => 229,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 247,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:35:24',
                'updated_at' => '2026-02-14 10:35:24',
            ),
            249 => 
            array (
                'id' => 250,
                'sampleable_id' => 230,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 247,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:35:24',
                'updated_at' => '2026-02-14 10:35:24',
            ),
            250 => 
            array (
                'id' => 251,
                'sampleable_id' => 228,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 248,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:35:43',
                'updated_at' => '2026-02-14 10:35:43',
            ),
            251 => 
            array (
                'id' => 252,
                'sampleable_id' => 229,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 248,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:35:43',
                'updated_at' => '2026-02-14 10:35:43',
            ),
            252 => 
            array (
                'id' => 253,
                'sampleable_id' => 230,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 248,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:35:43',
                'updated_at' => '2026-02-14 10:35:43',
            ),
            253 => 
            array (
                'id' => 254,
                'sampleable_id' => 228,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 246,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:35:51',
                'updated_at' => '2026-02-14 10:35:51',
            ),
            254 => 
            array (
                'id' => 255,
                'sampleable_id' => 229,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 246,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:35:51',
                'updated_at' => '2026-02-14 10:35:51',
            ),
            255 => 
            array (
                'id' => 256,
                'sampleable_id' => 230,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 246,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:35:51',
                'updated_at' => '2026-02-14 10:35:51',
            ),
            256 => 
            array (
                'id' => 257,
                'sampleable_id' => 231,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 249,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:37:31',
                'updated_at' => '2026-02-14 10:37:31',
            ),
            257 => 
            array (
                'id' => 258,
                'sampleable_id' => 57,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 250,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:39:55',
                'updated_at' => '2026-02-14 10:39:55',
            ),
            258 => 
            array (
                'id' => 259,
                'sampleable_id' => 58,
                'sampleable_type' => 'App\\Models\\SampleType',
                'testservice_id' => 251,
                'added_by' => 2,
                'created_at' => '2026-02-14 10:40:16',
                'updated_at' => '2026-02-14 10:40:16',
            ),
        ));
        
        
    }
}