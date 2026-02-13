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
                'id' => 3838,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 672,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            8 => 
            array (
                'id' => 3839,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 672,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            9 => 
            array (
                'id' => 3840,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 672,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            10 => 
            array (
                'id' => 3841,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 672,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            11 => 
            array (
                'id' => 3842,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 672,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            12 => 
            array (
                'id' => 3843,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 672,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            13 => 
            array (
                'id' => 3844,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 672,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            14 => 
            array (
                'id' => 3845,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 672,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            15 => 
            array (
                'id' => 3846,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 672,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            16 => 
            array (
                'id' => 3847,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 672,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            17 => 
            array (
                'id' => 3848,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 673,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            18 => 
            array (
                'id' => 3849,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 673,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            19 => 
            array (
                'id' => 3850,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 673,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            20 => 
            array (
                'id' => 3851,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 673,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            21 => 
            array (
                'id' => 3852,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 673,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            22 => 
            array (
                'id' => 3853,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 673,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            23 => 
            array (
                'id' => 3854,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 673,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            24 => 
            array (
                'id' => 3855,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 673,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            25 => 
            array (
                'id' => 3856,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 673,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            26 => 
            array (
                'id' => 3857,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 673,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            27 => 
            array (
                'id' => 3858,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 674,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            28 => 
            array (
                'id' => 3859,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 674,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            29 => 
            array (
                'id' => 3860,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 674,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            30 => 
            array (
                'id' => 3861,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 674,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            31 => 
            array (
                'id' => 3862,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 674,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            32 => 
            array (
                'id' => 3863,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 674,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            33 => 
            array (
                'id' => 3864,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 674,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            34 => 
            array (
                'id' => 3865,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 674,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            35 => 
            array (
                'id' => 3866,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 674,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            36 => 
            array (
                'id' => 3867,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 674,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:23',
                'updated_at' => '2026-02-13 15:58:23',
            ),
            37 => 
            array (
                'id' => 3868,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 675,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            38 => 
            array (
                'id' => 3869,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 675,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            39 => 
            array (
                'id' => 3870,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 675,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            40 => 
            array (
                'id' => 3871,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 675,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            41 => 
            array (
                'id' => 3872,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 675,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            42 => 
            array (
                'id' => 3873,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 675,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            43 => 
            array (
                'id' => 3874,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 675,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            44 => 
            array (
                'id' => 3875,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 675,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            45 => 
            array (
                'id' => 3876,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 675,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            46 => 
            array (
                'id' => 3877,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 675,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            47 => 
            array (
                'id' => 3878,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 676,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            48 => 
            array (
                'id' => 3879,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 676,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            49 => 
            array (
                'id' => 3880,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 676,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            50 => 
            array (
                'id' => 3881,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 676,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            51 => 
            array (
                'id' => 3882,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 676,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            52 => 
            array (
                'id' => 3883,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 676,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            53 => 
            array (
                'id' => 3884,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 676,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            54 => 
            array (
                'id' => 3885,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 676,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            55 => 
            array (
                'id' => 3886,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 676,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            56 => 
            array (
                'id' => 3887,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 676,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            57 => 
            array (
                'id' => 3888,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 677,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            58 => 
            array (
                'id' => 3889,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 677,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            59 => 
            array (
                'id' => 3890,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 677,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            60 => 
            array (
                'id' => 3891,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 677,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            61 => 
            array (
                'id' => 3892,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 677,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            62 => 
            array (
                'id' => 3893,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 677,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            63 => 
            array (
                'id' => 3894,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 677,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            64 => 
            array (
                'id' => 3895,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 677,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            65 => 
            array (
                'id' => 3896,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 677,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            66 => 
            array (
                'id' => 3897,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 677,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            67 => 
            array (
                'id' => 3898,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 678,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            68 => 
            array (
                'id' => 3899,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 678,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            69 => 
            array (
                'id' => 3900,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 678,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            70 => 
            array (
                'id' => 3901,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 678,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            71 => 
            array (
                'id' => 3902,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 678,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            72 => 
            array (
                'id' => 3903,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 678,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            73 => 
            array (
                'id' => 3904,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 678,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            74 => 
            array (
                'id' => 3905,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 678,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            75 => 
            array (
                'id' => 3906,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 678,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            76 => 
            array (
                'id' => 3907,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 678,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            77 => 
            array (
                'id' => 3908,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 679,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            78 => 
            array (
                'id' => 3909,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 679,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            79 => 
            array (
                'id' => 3910,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 679,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            80 => 
            array (
                'id' => 3911,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 679,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            81 => 
            array (
                'id' => 3912,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 679,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            82 => 
            array (
                'id' => 3913,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 679,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            83 => 
            array (
                'id' => 3914,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 679,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            84 => 
            array (
                'id' => 3915,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 679,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            85 => 
            array (
                'id' => 3916,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 679,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            86 => 
            array (
                'id' => 3917,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 679,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            87 => 
            array (
                'id' => 3918,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 680,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            88 => 
            array (
                'id' => 3919,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 680,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            89 => 
            array (
                'id' => 3920,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 680,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            90 => 
            array (
                'id' => 3921,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 680,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            91 => 
            array (
                'id' => 3922,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 680,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            92 => 
            array (
                'id' => 3923,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 680,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            93 => 
            array (
                'id' => 3924,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 680,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            94 => 
            array (
                'id' => 3925,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 680,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            95 => 
            array (
                'id' => 3926,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 680,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            96 => 
            array (
                'id' => 3927,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 680,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            97 => 
            array (
                'id' => 3928,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 681,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            98 => 
            array (
                'id' => 3929,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 681,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            99 => 
            array (
                'id' => 3930,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 681,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            100 => 
            array (
                'id' => 3931,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 681,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            101 => 
            array (
                'id' => 3932,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 681,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            102 => 
            array (
                'id' => 3933,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 681,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            103 => 
            array (
                'id' => 3934,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 681,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            104 => 
            array (
                'id' => 3935,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 681,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            105 => 
            array (
                'id' => 3936,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 681,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            106 => 
            array (
                'id' => 3937,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 681,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            107 => 
            array (
                'id' => 3938,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 682,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            108 => 
            array (
                'id' => 3939,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 682,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            109 => 
            array (
                'id' => 3940,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 682,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            110 => 
            array (
                'id' => 3941,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 682,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            111 => 
            array (
                'id' => 3942,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 682,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            112 => 
            array (
                'id' => 3943,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 682,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            113 => 
            array (
                'id' => 3944,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 682,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            114 => 
            array (
                'id' => 3945,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 682,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            115 => 
            array (
                'id' => 3946,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 682,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            116 => 
            array (
                'id' => 3947,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 682,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            117 => 
            array (
                'id' => 3948,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 683,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            118 => 
            array (
                'id' => 3949,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 683,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            119 => 
            array (
                'id' => 3950,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 683,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            120 => 
            array (
                'id' => 3951,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 683,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            121 => 
            array (
                'id' => 3952,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 683,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            122 => 
            array (
                'id' => 3953,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 683,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            123 => 
            array (
                'id' => 3954,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 683,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            124 => 
            array (
                'id' => 3955,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 683,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            125 => 
            array (
                'id' => 3956,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 683,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            126 => 
            array (
                'id' => 3957,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 683,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:24',
                'updated_at' => '2026-02-13 15:58:24',
            ),
            127 => 
            array (
                'id' => 3958,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 684,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            128 => 
            array (
                'id' => 3959,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 684,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            129 => 
            array (
                'id' => 3960,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 684,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            130 => 
            array (
                'id' => 3961,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 684,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            131 => 
            array (
                'id' => 3962,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 684,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            132 => 
            array (
                'id' => 3963,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 684,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            133 => 
            array (
                'id' => 3964,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 684,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            134 => 
            array (
                'id' => 3965,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 684,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            135 => 
            array (
                'id' => 3966,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 684,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            136 => 
            array (
                'id' => 3967,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 684,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            137 => 
            array (
                'id' => 3968,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 685,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            138 => 
            array (
                'id' => 3969,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 685,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            139 => 
            array (
                'id' => 3970,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 685,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            140 => 
            array (
                'id' => 3971,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 685,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            141 => 
            array (
                'id' => 3972,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 685,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            142 => 
            array (
                'id' => 3973,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 685,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            143 => 
            array (
                'id' => 3974,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 685,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            144 => 
            array (
                'id' => 3975,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 685,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            145 => 
            array (
                'id' => 3976,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 685,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            146 => 
            array (
                'id' => 3977,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 685,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            147 => 
            array (
                'id' => 3978,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 686,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            148 => 
            array (
                'id' => 3979,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 686,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            149 => 
            array (
                'id' => 3980,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 686,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            150 => 
            array (
                'id' => 3981,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 686,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            151 => 
            array (
                'id' => 3982,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 686,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            152 => 
            array (
                'id' => 3983,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 686,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            153 => 
            array (
                'id' => 3984,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 686,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            154 => 
            array (
                'id' => 3985,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 686,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            155 => 
            array (
                'id' => 3986,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 686,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            156 => 
            array (
                'id' => 3987,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 686,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            157 => 
            array (
                'id' => 3988,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 687,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            158 => 
            array (
                'id' => 3989,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 687,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            159 => 
            array (
                'id' => 3990,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 687,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            160 => 
            array (
                'id' => 3991,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 687,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            161 => 
            array (
                'id' => 3992,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 687,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            162 => 
            array (
                'id' => 3993,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 687,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            163 => 
            array (
                'id' => 3994,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 687,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            164 => 
            array (
                'id' => 3995,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 687,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            165 => 
            array (
                'id' => 3996,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 687,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            166 => 
            array (
                'id' => 3997,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 687,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            167 => 
            array (
                'id' => 3998,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 688,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            168 => 
            array (
                'id' => 3999,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 688,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            169 => 
            array (
                'id' => 4000,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 688,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            170 => 
            array (
                'id' => 4001,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 688,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            171 => 
            array (
                'id' => 4002,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 688,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            172 => 
            array (
                'id' => 4003,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 688,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            173 => 
            array (
                'id' => 4004,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 688,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            174 => 
            array (
                'id' => 4005,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 688,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            175 => 
            array (
                'id' => 4006,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 688,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            176 => 
            array (
                'id' => 4007,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 688,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            177 => 
            array (
                'id' => 4008,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 689,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            178 => 
            array (
                'id' => 4009,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 689,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            179 => 
            array (
                'id' => 4010,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 689,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            180 => 
            array (
                'id' => 4011,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 689,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            181 => 
            array (
                'id' => 4012,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 689,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            182 => 
            array (
                'id' => 4013,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 689,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            183 => 
            array (
                'id' => 4014,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 689,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            184 => 
            array (
                'id' => 4015,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 689,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            185 => 
            array (
                'id' => 4016,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 689,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            186 => 
            array (
                'id' => 4017,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 689,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            187 => 
            array (
                'id' => 4018,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 690,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            188 => 
            array (
                'id' => 4019,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 690,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            189 => 
            array (
                'id' => 4020,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 690,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            190 => 
            array (
                'id' => 4021,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 690,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            191 => 
            array (
                'id' => 4022,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 690,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            192 => 
            array (
                'id' => 4023,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 690,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            193 => 
            array (
                'id' => 4024,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 690,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            194 => 
            array (
                'id' => 4025,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 690,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            195 => 
            array (
                'id' => 4026,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 690,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            196 => 
            array (
                'id' => 4027,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 690,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            197 => 
            array (
                'id' => 4028,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 691,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            198 => 
            array (
                'id' => 4029,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 691,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            199 => 
            array (
                'id' => 4030,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 691,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            200 => 
            array (
                'id' => 4031,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 691,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            201 => 
            array (
                'id' => 4032,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 691,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            202 => 
            array (
                'id' => 4033,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 691,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            203 => 
            array (
                'id' => 4034,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 691,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            204 => 
            array (
                'id' => 4035,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 691,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            205 => 
            array (
                'id' => 4036,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 691,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            206 => 
            array (
                'id' => 4037,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 691,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            207 => 
            array (
                'id' => 4038,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 692,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            208 => 
            array (
                'id' => 4039,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 692,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            209 => 
            array (
                'id' => 4040,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 692,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            210 => 
            array (
                'id' => 4041,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 692,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            211 => 
            array (
                'id' => 4042,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 692,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            212 => 
            array (
                'id' => 4043,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 692,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            213 => 
            array (
                'id' => 4044,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 692,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            214 => 
            array (
                'id' => 4045,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 692,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            215 => 
            array (
                'id' => 4046,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 692,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            216 => 
            array (
                'id' => 4047,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 692,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            217 => 
            array (
                'id' => 4048,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 693,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            218 => 
            array (
                'id' => 4049,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 693,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            219 => 
            array (
                'id' => 4050,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 693,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            220 => 
            array (
                'id' => 4051,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 693,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            221 => 
            array (
                'id' => 4052,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 693,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            222 => 
            array (
                'id' => 4053,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 693,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            223 => 
            array (
                'id' => 4054,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 693,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            224 => 
            array (
                'id' => 4055,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 693,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            225 => 
            array (
                'id' => 4056,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 693,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            226 => 
            array (
                'id' => 4057,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 693,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:25',
                'updated_at' => '2026-02-13 15:58:25',
            ),
            227 => 
            array (
                'id' => 4058,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 694,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            228 => 
            array (
                'id' => 4059,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 694,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            229 => 
            array (
                'id' => 4060,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 694,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            230 => 
            array (
                'id' => 4061,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 694,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            231 => 
            array (
                'id' => 4062,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 694,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            232 => 
            array (
                'id' => 4063,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 694,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            233 => 
            array (
                'id' => 4064,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 694,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            234 => 
            array (
                'id' => 4065,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 694,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            235 => 
            array (
                'id' => 4066,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 694,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            236 => 
            array (
                'id' => 4067,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 694,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            237 => 
            array (
                'id' => 4068,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 695,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            238 => 
            array (
                'id' => 4069,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 695,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            239 => 
            array (
                'id' => 4070,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 695,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            240 => 
            array (
                'id' => 4071,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 695,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            241 => 
            array (
                'id' => 4072,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 695,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            242 => 
            array (
                'id' => 4073,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 695,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            243 => 
            array (
                'id' => 4074,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 695,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            244 => 
            array (
                'id' => 4075,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 695,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            245 => 
            array (
                'id' => 4076,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 695,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            246 => 
            array (
                'id' => 4077,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 695,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            247 => 
            array (
                'id' => 4078,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 696,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            248 => 
            array (
                'id' => 4079,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 696,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            249 => 
            array (
                'id' => 4080,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 696,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            250 => 
            array (
                'id' => 4081,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 696,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            251 => 
            array (
                'id' => 4082,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 696,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            252 => 
            array (
                'id' => 4083,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 696,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            253 => 
            array (
                'id' => 4084,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 696,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            254 => 
            array (
                'id' => 4085,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 696,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            255 => 
            array (
                'id' => 4086,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 696,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            256 => 
            array (
                'id' => 4087,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 696,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            257 => 
            array (
                'id' => 4088,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 697,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            258 => 
            array (
                'id' => 4089,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 697,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            259 => 
            array (
                'id' => 4090,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 697,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            260 => 
            array (
                'id' => 4091,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 697,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            261 => 
            array (
                'id' => 4092,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 697,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            262 => 
            array (
                'id' => 4093,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 697,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            263 => 
            array (
                'id' => 4094,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 697,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            264 => 
            array (
                'id' => 4095,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 697,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            265 => 
            array (
                'id' => 4096,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 697,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            266 => 
            array (
                'id' => 4097,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 697,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            267 => 
            array (
                'id' => 4098,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 698,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            268 => 
            array (
                'id' => 4099,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 698,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            269 => 
            array (
                'id' => 4100,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 698,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            270 => 
            array (
                'id' => 4101,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 698,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            271 => 
            array (
                'id' => 4102,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 698,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            272 => 
            array (
                'id' => 4103,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 698,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            273 => 
            array (
                'id' => 4104,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 698,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            274 => 
            array (
                'id' => 4105,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 698,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            275 => 
            array (
                'id' => 4106,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 698,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            276 => 
            array (
                'id' => 4107,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 698,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            277 => 
            array (
                'id' => 4108,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 699,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            278 => 
            array (
                'id' => 4109,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 699,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            279 => 
            array (
                'id' => 4110,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 699,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            280 => 
            array (
                'id' => 4111,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 699,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            281 => 
            array (
                'id' => 4112,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 699,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            282 => 
            array (
                'id' => 4113,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 699,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            283 => 
            array (
                'id' => 4114,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 699,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            284 => 
            array (
                'id' => 4115,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 699,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            285 => 
            array (
                'id' => 4116,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 699,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            286 => 
            array (
                'id' => 4117,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 699,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            287 => 
            array (
                'id' => 4118,
                'sampleable_id' => 2,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 700,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            288 => 
            array (
                'id' => 4119,
                'sampleable_id' => 3,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 700,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            289 => 
            array (
                'id' => 4120,
                'sampleable_id' => 4,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 700,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            290 => 
            array (
                'id' => 4121,
                'sampleable_id' => 5,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 700,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            291 => 
            array (
                'id' => 4122,
                'sampleable_id' => 6,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 700,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            292 => 
            array (
                'id' => 4123,
                'sampleable_id' => 7,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 700,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            293 => 
            array (
                'id' => 4124,
                'sampleable_id' => 8,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 700,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            294 => 
            array (
                'id' => 4125,
                'sampleable_id' => 9,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 700,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            295 => 
            array (
                'id' => 4126,
                'sampleable_id' => 10,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 700,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            296 => 
            array (
                'id' => 4127,
                'sampleable_id' => 11,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 700,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            297 => 
            array (
                'id' => 4128,
                'sampleable_id' => 12,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 701,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            298 => 
            array (
                'id' => 4129,
                'sampleable_id' => 13,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 701,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            299 => 
            array (
                'id' => 4130,
                'sampleable_id' => 14,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 701,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            300 => 
            array (
                'id' => 4131,
                'sampleable_id' => 15,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 701,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            301 => 
            array (
                'id' => 4132,
                'sampleable_id' => 16,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 701,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            302 => 
            array (
                'id' => 4133,
                'sampleable_id' => 17,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 701,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            303 => 
            array (
                'id' => 4134,
                'sampleable_id' => 18,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 701,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            304 => 
            array (
                'id' => 4135,
                'sampleable_id' => 19,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 701,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            305 => 
            array (
                'id' => 4136,
                'sampleable_id' => 20,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 701,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            306 => 
            array (
                'id' => 4137,
                'sampleable_id' => 12,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 702,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            307 => 
            array (
                'id' => 4138,
                'sampleable_id' => 13,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 702,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            308 => 
            array (
                'id' => 4139,
                'sampleable_id' => 14,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 702,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            309 => 
            array (
                'id' => 4140,
                'sampleable_id' => 15,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 702,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            310 => 
            array (
                'id' => 4141,
                'sampleable_id' => 16,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 702,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            311 => 
            array (
                'id' => 4142,
                'sampleable_id' => 17,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 702,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            312 => 
            array (
                'id' => 4143,
                'sampleable_id' => 18,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 702,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            313 => 
            array (
                'id' => 4144,
                'sampleable_id' => 19,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 702,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            314 => 
            array (
                'id' => 4145,
                'sampleable_id' => 20,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 702,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            315 => 
            array (
                'id' => 4146,
                'sampleable_id' => 12,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 703,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            316 => 
            array (
                'id' => 4147,
                'sampleable_id' => 13,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 703,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            317 => 
            array (
                'id' => 4148,
                'sampleable_id' => 14,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 703,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            318 => 
            array (
                'id' => 4149,
                'sampleable_id' => 15,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 703,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            319 => 
            array (
                'id' => 4150,
                'sampleable_id' => 16,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 703,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            320 => 
            array (
                'id' => 4151,
                'sampleable_id' => 17,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 703,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            321 => 
            array (
                'id' => 4152,
                'sampleable_id' => 18,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 703,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            322 => 
            array (
                'id' => 4153,
                'sampleable_id' => 19,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 703,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            323 => 
            array (
                'id' => 4154,
                'sampleable_id' => 20,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 703,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:26',
                'updated_at' => '2026-02-13 15:58:26',
            ),
            324 => 
            array (
                'id' => 4155,
                'sampleable_id' => 39,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 704,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            325 => 
            array (
                'id' => 4156,
                'sampleable_id' => 40,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 704,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            326 => 
            array (
                'id' => 4157,
                'sampleable_id' => 41,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 704,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            327 => 
            array (
                'id' => 4158,
                'sampleable_id' => 43,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 704,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            328 => 
            array (
                'id' => 4159,
                'sampleable_id' => 39,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 705,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            329 => 
            array (
                'id' => 4160,
                'sampleable_id' => 40,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 705,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            330 => 
            array (
                'id' => 4161,
                'sampleable_id' => 41,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 705,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            331 => 
            array (
                'id' => 4162,
                'sampleable_id' => 43,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 705,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            332 => 
            array (
                'id' => 4163,
                'sampleable_id' => 39,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 706,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            333 => 
            array (
                'id' => 4164,
                'sampleable_id' => 40,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 706,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            334 => 
            array (
                'id' => 4165,
                'sampleable_id' => 41,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 706,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            335 => 
            array (
                'id' => 4166,
                'sampleable_id' => 43,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 706,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            336 => 
            array (
                'id' => 4167,
                'sampleable_id' => 39,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 707,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            337 => 
            array (
                'id' => 4168,
                'sampleable_id' => 40,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 707,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            338 => 
            array (
                'id' => 4169,
                'sampleable_id' => 41,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 707,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            339 => 
            array (
                'id' => 4170,
                'sampleable_id' => 43,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 707,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            340 => 
            array (
                'id' => 4171,
                'sampleable_id' => 39,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 708,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            341 => 
            array (
                'id' => 4172,
                'sampleable_id' => 40,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 708,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            342 => 
            array (
                'id' => 4173,
                'sampleable_id' => 41,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 708,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            343 => 
            array (
                'id' => 4174,
                'sampleable_id' => 43,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 708,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            344 => 
            array (
                'id' => 4175,
                'sampleable_id' => 39,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 709,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            345 => 
            array (
                'id' => 4176,
                'sampleable_id' => 40,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 709,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            346 => 
            array (
                'id' => 4177,
                'sampleable_id' => 41,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 709,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            347 => 
            array (
                'id' => 4178,
                'sampleable_id' => 43,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 709,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            348 => 
            array (
                'id' => 4179,
                'sampleable_id' => 39,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 710,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            349 => 
            array (
                'id' => 4180,
                'sampleable_id' => 40,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 710,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            350 => 
            array (
                'id' => 4181,
                'sampleable_id' => 41,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 710,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            351 => 
            array (
                'id' => 4182,
                'sampleable_id' => 43,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 710,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            352 => 
            array (
                'id' => 4183,
                'sampleable_id' => 39,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 711,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            353 => 
            array (
                'id' => 4184,
                'sampleable_id' => 40,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 711,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            354 => 
            array (
                'id' => 4185,
                'sampleable_id' => 41,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 711,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            355 => 
            array (
                'id' => 4186,
                'sampleable_id' => 43,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 711,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            356 => 
            array (
                'id' => 4187,
                'sampleable_id' => 39,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 712,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            357 => 
            array (
                'id' => 4188,
                'sampleable_id' => 40,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 712,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            358 => 
            array (
                'id' => 4189,
                'sampleable_id' => 41,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 712,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            359 => 
            array (
                'id' => 4190,
                'sampleable_id' => 43,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 712,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            360 => 
            array (
                'id' => 4191,
                'sampleable_id' => 39,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 713,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            361 => 
            array (
                'id' => 4192,
                'sampleable_id' => 40,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 713,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            362 => 
            array (
                'id' => 4193,
                'sampleable_id' => 41,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 713,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            363 => 
            array (
                'id' => 4194,
                'sampleable_id' => 43,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 713,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            364 => 
            array (
                'id' => 4195,
                'sampleable_id' => 44,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 714,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            365 => 
            array (
                'id' => 4196,
                'sampleable_id' => 45,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 714,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            366 => 
            array (
                'id' => 4197,
                'sampleable_id' => 46,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 714,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            367 => 
            array (
                'id' => 4198,
                'sampleable_id' => 47,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 714,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            368 => 
            array (
                'id' => 4199,
                'sampleable_id' => 44,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 715,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            369 => 
            array (
                'id' => 4200,
                'sampleable_id' => 45,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 715,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            370 => 
            array (
                'id' => 4201,
                'sampleable_id' => 46,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 715,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            371 => 
            array (
                'id' => 4202,
                'sampleable_id' => 47,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 715,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            372 => 
            array (
                'id' => 4203,
                'sampleable_id' => 44,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 716,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            373 => 
            array (
                'id' => 4204,
                'sampleable_id' => 45,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 716,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            374 => 
            array (
                'id' => 4205,
                'sampleable_id' => 46,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 716,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            375 => 
            array (
                'id' => 4206,
                'sampleable_id' => 47,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 716,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            376 => 
            array (
                'id' => 4207,
                'sampleable_id' => 44,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 717,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            377 => 
            array (
                'id' => 4208,
                'sampleable_id' => 45,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 717,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            378 => 
            array (
                'id' => 4209,
                'sampleable_id' => 46,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 717,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            379 => 
            array (
                'id' => 4210,
                'sampleable_id' => 47,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 717,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:27',
                'updated_at' => '2026-02-13 15:58:27',
            ),
            380 => 
            array (
                'id' => 4211,
                'sampleable_id' => 44,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 718,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            381 => 
            array (
                'id' => 4212,
                'sampleable_id' => 45,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 718,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            382 => 
            array (
                'id' => 4213,
                'sampleable_id' => 46,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 718,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            383 => 
            array (
                'id' => 4214,
                'sampleable_id' => 47,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 718,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            384 => 
            array (
                'id' => 4215,
                'sampleable_id' => 50,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 719,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            385 => 
            array (
                'id' => 4216,
                'sampleable_id' => 52,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 719,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            386 => 
            array (
                'id' => 4217,
                'sampleable_id' => 50,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 720,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            387 => 
            array (
                'id' => 4218,
                'sampleable_id' => 52,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 720,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            388 => 
            array (
                'id' => 4219,
                'sampleable_id' => 50,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 721,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            389 => 
            array (
                'id' => 4220,
                'sampleable_id' => 52,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 721,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            390 => 
            array (
                'id' => 4221,
                'sampleable_id' => 50,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 722,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            391 => 
            array (
                'id' => 4222,
                'sampleable_id' => 52,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 722,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            392 => 
            array (
                'id' => 4223,
                'sampleable_id' => 54,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 723,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            393 => 
            array (
                'id' => 4224,
                'sampleable_id' => 55,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 724,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            394 => 
            array (
                'id' => 4225,
                'sampleable_id' => 56,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 724,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            395 => 
            array (
                'id' => 4226,
                'sampleable_id' => 55,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 725,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            396 => 
            array (
                'id' => 4227,
                'sampleable_id' => 56,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 725,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            397 => 
            array (
                'id' => 4228,
                'sampleable_id' => 55,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 726,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            398 => 
            array (
                'id' => 4229,
                'sampleable_id' => 56,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 726,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            399 => 
            array (
                'id' => 4230,
                'sampleable_id' => 55,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 727,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            400 => 
            array (
                'id' => 4231,
                'sampleable_id' => 56,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 727,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            401 => 
            array (
                'id' => 4232,
                'sampleable_id' => 55,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 728,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            402 => 
            array (
                'id' => 4233,
                'sampleable_id' => 56,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 728,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            403 => 
            array (
                'id' => 4234,
                'sampleable_id' => 55,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 729,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            404 => 
            array (
                'id' => 4235,
                'sampleable_id' => 56,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 729,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            405 => 
            array (
                'id' => 4236,
                'sampleable_id' => 58,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 730,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            406 => 
            array (
                'id' => 4237,
                'sampleable_id' => 59,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 730,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            407 => 
            array (
                'id' => 4238,
                'sampleable_id' => 60,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 730,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            408 => 
            array (
                'id' => 4239,
                'sampleable_id' => 61,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 730,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            409 => 
            array (
                'id' => 4240,
                'sampleable_id' => 62,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 730,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            410 => 
            array (
                'id' => 4241,
                'sampleable_id' => 63,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 730,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            411 => 
            array (
                'id' => 4242,
                'sampleable_id' => 58,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 731,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            412 => 
            array (
                'id' => 4243,
                'sampleable_id' => 59,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 731,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            413 => 
            array (
                'id' => 4244,
                'sampleable_id' => 60,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 731,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            414 => 
            array (
                'id' => 4245,
                'sampleable_id' => 61,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 731,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            415 => 
            array (
                'id' => 4246,
                'sampleable_id' => 62,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 731,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            416 => 
            array (
                'id' => 4247,
                'sampleable_id' => 63,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 731,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            417 => 
            array (
                'id' => 4248,
                'sampleable_id' => 58,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 732,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            418 => 
            array (
                'id' => 4249,
                'sampleable_id' => 59,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 732,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            419 => 
            array (
                'id' => 4250,
                'sampleable_id' => 60,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 732,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            420 => 
            array (
                'id' => 4251,
                'sampleable_id' => 61,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 732,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            421 => 
            array (
                'id' => 4252,
                'sampleable_id' => 62,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 732,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            422 => 
            array (
                'id' => 4253,
                'sampleable_id' => 63,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 732,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            423 => 
            array (
                'id' => 4254,
                'sampleable_id' => 58,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 733,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            424 => 
            array (
                'id' => 4255,
                'sampleable_id' => 59,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 733,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            425 => 
            array (
                'id' => 4256,
                'sampleable_id' => 60,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 733,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            426 => 
            array (
                'id' => 4257,
                'sampleable_id' => 61,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 733,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            427 => 
            array (
                'id' => 4258,
                'sampleable_id' => 62,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 733,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            428 => 
            array (
                'id' => 4259,
                'sampleable_id' => 63,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 733,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:28',
                'updated_at' => '2026-02-13 15:58:28',
            ),
            429 => 
            array (
                'id' => 4260,
                'sampleable_id' => 58,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 734,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            430 => 
            array (
                'id' => 4261,
                'sampleable_id' => 59,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 734,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            431 => 
            array (
                'id' => 4262,
                'sampleable_id' => 60,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 734,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            432 => 
            array (
                'id' => 4263,
                'sampleable_id' => 61,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 734,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            433 => 
            array (
                'id' => 4264,
                'sampleable_id' => 62,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 734,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            434 => 
            array (
                'id' => 4265,
                'sampleable_id' => 63,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 734,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            435 => 
            array (
                'id' => 4266,
                'sampleable_id' => 58,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 735,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            436 => 
            array (
                'id' => 4267,
                'sampleable_id' => 59,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 735,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            437 => 
            array (
                'id' => 4268,
                'sampleable_id' => 60,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 735,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            438 => 
            array (
                'id' => 4269,
                'sampleable_id' => 61,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 735,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            439 => 
            array (
                'id' => 4270,
                'sampleable_id' => 62,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 735,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            440 => 
            array (
                'id' => 4271,
                'sampleable_id' => 63,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 735,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            441 => 
            array (
                'id' => 4272,
                'sampleable_id' => 58,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 736,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            442 => 
            array (
                'id' => 4273,
                'sampleable_id' => 59,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 736,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            443 => 
            array (
                'id' => 4274,
                'sampleable_id' => 60,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 736,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            444 => 
            array (
                'id' => 4275,
                'sampleable_id' => 61,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 736,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            445 => 
            array (
                'id' => 4276,
                'sampleable_id' => 62,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 736,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            446 => 
            array (
                'id' => 4277,
                'sampleable_id' => 63,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 736,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            447 => 
            array (
                'id' => 4278,
                'sampleable_id' => 58,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 737,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            448 => 
            array (
                'id' => 4279,
                'sampleable_id' => 59,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 737,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            449 => 
            array (
                'id' => 4280,
                'sampleable_id' => 60,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 737,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            450 => 
            array (
                'id' => 4281,
                'sampleable_id' => 61,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 737,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            451 => 
            array (
                'id' => 4282,
                'sampleable_id' => 62,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 737,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            452 => 
            array (
                'id' => 4283,
                'sampleable_id' => 63,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 737,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            453 => 
            array (
                'id' => 4284,
                'sampleable_id' => 58,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 738,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            454 => 
            array (
                'id' => 4285,
                'sampleable_id' => 59,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 738,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            455 => 
            array (
                'id' => 4286,
                'sampleable_id' => 60,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 738,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            456 => 
            array (
                'id' => 4287,
                'sampleable_id' => 61,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 738,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            457 => 
            array (
                'id' => 4288,
                'sampleable_id' => 62,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 738,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            458 => 
            array (
                'id' => 4289,
                'sampleable_id' => 63,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 738,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            459 => 
            array (
                'id' => 4290,
                'sampleable_id' => 58,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 739,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            460 => 
            array (
                'id' => 4291,
                'sampleable_id' => 59,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 739,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            461 => 
            array (
                'id' => 4292,
                'sampleable_id' => 60,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 739,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            462 => 
            array (
                'id' => 4293,
                'sampleable_id' => 61,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 739,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            463 => 
            array (
                'id' => 4294,
                'sampleable_id' => 62,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 739,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            464 => 
            array (
                'id' => 4295,
                'sampleable_id' => 63,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 739,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            465 => 
            array (
                'id' => 4296,
                'sampleable_id' => 58,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 740,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            466 => 
            array (
                'id' => 4297,
                'sampleable_id' => 59,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 740,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            467 => 
            array (
                'id' => 4298,
                'sampleable_id' => 60,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 740,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            468 => 
            array (
                'id' => 4299,
                'sampleable_id' => 61,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 740,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            469 => 
            array (
                'id' => 4300,
                'sampleable_id' => 62,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 740,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            470 => 
            array (
                'id' => 4301,
                'sampleable_id' => 63,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 740,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            471 => 
            array (
                'id' => 4302,
                'sampleable_id' => 58,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 741,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            472 => 
            array (
                'id' => 4303,
                'sampleable_id' => 59,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 741,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            473 => 
            array (
                'id' => 4304,
                'sampleable_id' => 60,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 741,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            474 => 
            array (
                'id' => 4305,
                'sampleable_id' => 61,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 741,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            475 => 
            array (
                'id' => 4306,
                'sampleable_id' => 62,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 741,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            476 => 
            array (
                'id' => 4307,
                'sampleable_id' => 63,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 741,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            477 => 
            array (
                'id' => 4308,
                'sampleable_id' => 58,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 742,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            478 => 
            array (
                'id' => 4309,
                'sampleable_id' => 59,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 742,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            479 => 
            array (
                'id' => 4310,
                'sampleable_id' => 60,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 742,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            480 => 
            array (
                'id' => 4311,
                'sampleable_id' => 61,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 742,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            481 => 
            array (
                'id' => 4312,
                'sampleable_id' => 62,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 742,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            482 => 
            array (
                'id' => 4313,
                'sampleable_id' => 63,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 742,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            483 => 
            array (
                'id' => 4314,
                'sampleable_id' => 58,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 743,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            484 => 
            array (
                'id' => 4315,
                'sampleable_id' => 59,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 743,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            485 => 
            array (
                'id' => 4316,
                'sampleable_id' => 60,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 743,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            486 => 
            array (
                'id' => 4317,
                'sampleable_id' => 61,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 743,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            487 => 
            array (
                'id' => 4318,
                'sampleable_id' => 62,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 743,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            488 => 
            array (
                'id' => 4319,
                'sampleable_id' => 63,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 743,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            489 => 
            array (
                'id' => 4320,
                'sampleable_id' => 64,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 744,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            490 => 
            array (
                'id' => 4321,
                'sampleable_id' => 65,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 744,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            491 => 
            array (
                'id' => 4322,
                'sampleable_id' => 66,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 744,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            492 => 
            array (
                'id' => 4323,
                'sampleable_id' => 67,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 744,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            493 => 
            array (
                'id' => 4324,
                'sampleable_id' => 68,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 744,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            494 => 
            array (
                'id' => 4325,
                'sampleable_id' => 69,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 744,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            495 => 
            array (
                'id' => 4326,
                'sampleable_id' => 64,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 745,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            496 => 
            array (
                'id' => 4327,
                'sampleable_id' => 65,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 745,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            497 => 
            array (
                'id' => 4328,
                'sampleable_id' => 66,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 745,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            498 => 
            array (
                'id' => 4329,
                'sampleable_id' => 67,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 745,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            499 => 
            array (
                'id' => 4330,
                'sampleable_id' => 68,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 745,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
        ));
        \DB::table('testservice_samples')->insert(array (
            0 => 
            array (
                'id' => 4331,
                'sampleable_id' => 69,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 745,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            1 => 
            array (
                'id' => 4332,
                'sampleable_id' => 64,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 746,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            2 => 
            array (
                'id' => 4333,
                'sampleable_id' => 65,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 746,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            3 => 
            array (
                'id' => 4334,
                'sampleable_id' => 66,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 746,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            4 => 
            array (
                'id' => 4335,
                'sampleable_id' => 67,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 746,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            5 => 
            array (
                'id' => 4336,
                'sampleable_id' => 68,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 746,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            6 => 
            array (
                'id' => 4337,
                'sampleable_id' => 69,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 746,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:29',
                'updated_at' => '2026-02-13 15:58:29',
            ),
            7 => 
            array (
                'id' => 4338,
                'sampleable_id' => 64,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 747,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            8 => 
            array (
                'id' => 4339,
                'sampleable_id' => 65,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 747,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            9 => 
            array (
                'id' => 4340,
                'sampleable_id' => 66,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 747,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            10 => 
            array (
                'id' => 4341,
                'sampleable_id' => 67,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 747,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            11 => 
            array (
                'id' => 4342,
                'sampleable_id' => 68,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 747,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            12 => 
            array (
                'id' => 4343,
                'sampleable_id' => 69,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 747,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            13 => 
            array (
                'id' => 4344,
                'sampleable_id' => 64,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 748,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            14 => 
            array (
                'id' => 4345,
                'sampleable_id' => 65,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 748,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            15 => 
            array (
                'id' => 4346,
                'sampleable_id' => 66,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 748,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            16 => 
            array (
                'id' => 4347,
                'sampleable_id' => 67,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 748,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            17 => 
            array (
                'id' => 4348,
                'sampleable_id' => 68,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 748,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            18 => 
            array (
                'id' => 4349,
                'sampleable_id' => 69,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 748,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            19 => 
            array (
                'id' => 4350,
                'sampleable_id' => 64,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 749,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            20 => 
            array (
                'id' => 4351,
                'sampleable_id' => 65,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 749,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            21 => 
            array (
                'id' => 4352,
                'sampleable_id' => 66,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 749,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            22 => 
            array (
                'id' => 4353,
                'sampleable_id' => 67,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 749,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            23 => 
            array (
                'id' => 4354,
                'sampleable_id' => 68,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 749,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            24 => 
            array (
                'id' => 4355,
                'sampleable_id' => 69,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 749,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            25 => 
            array (
                'id' => 4356,
                'sampleable_id' => 64,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 750,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            26 => 
            array (
                'id' => 4357,
                'sampleable_id' => 65,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 750,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            27 => 
            array (
                'id' => 4358,
                'sampleable_id' => 66,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 750,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            28 => 
            array (
                'id' => 4359,
                'sampleable_id' => 67,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 750,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            29 => 
            array (
                'id' => 4360,
                'sampleable_id' => 68,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 750,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            30 => 
            array (
                'id' => 4361,
                'sampleable_id' => 69,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 750,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            31 => 
            array (
                'id' => 4362,
                'sampleable_id' => 64,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 751,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            32 => 
            array (
                'id' => 4363,
                'sampleable_id' => 65,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 751,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            33 => 
            array (
                'id' => 4364,
                'sampleable_id' => 66,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 751,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            34 => 
            array (
                'id' => 4365,
                'sampleable_id' => 67,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 751,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            35 => 
            array (
                'id' => 4366,
                'sampleable_id' => 68,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 751,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            36 => 
            array (
                'id' => 4367,
                'sampleable_id' => 69,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 751,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            37 => 
            array (
                'id' => 4368,
                'sampleable_id' => 64,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 752,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            38 => 
            array (
                'id' => 4369,
                'sampleable_id' => 65,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 752,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            39 => 
            array (
                'id' => 4370,
                'sampleable_id' => 66,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 752,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            40 => 
            array (
                'id' => 4371,
                'sampleable_id' => 67,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 752,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            41 => 
            array (
                'id' => 4372,
                'sampleable_id' => 68,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 752,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            42 => 
            array (
                'id' => 4373,
                'sampleable_id' => 69,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 752,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            43 => 
            array (
                'id' => 4374,
                'sampleable_id' => 70,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 753,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            44 => 
            array (
                'id' => 4375,
                'sampleable_id' => 72,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 753,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            45 => 
            array (
                'id' => 4376,
                'sampleable_id' => 70,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 754,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            46 => 
            array (
                'id' => 4377,
                'sampleable_id' => 72,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 754,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            47 => 
            array (
                'id' => 4378,
                'sampleable_id' => 70,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 755,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            48 => 
            array (
                'id' => 4379,
                'sampleable_id' => 72,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 755,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            49 => 
            array (
                'id' => 4380,
                'sampleable_id' => 70,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 756,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            50 => 
            array (
                'id' => 4381,
                'sampleable_id' => 72,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 756,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            51 => 
            array (
                'id' => 4382,
                'sampleable_id' => 73,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 757,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            52 => 
            array (
                'id' => 4383,
                'sampleable_id' => 73,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 758,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            53 => 
            array (
                'id' => 4384,
                'sampleable_id' => 75,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 759,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            54 => 
            array (
                'id' => 4385,
                'sampleable_id' => 76,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 759,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            55 => 
            array (
                'id' => 4386,
                'sampleable_id' => 77,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 759,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            56 => 
            array (
                'id' => 4387,
                'sampleable_id' => 75,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 760,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            57 => 
            array (
                'id' => 4388,
                'sampleable_id' => 76,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 760,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            58 => 
            array (
                'id' => 4389,
                'sampleable_id' => 77,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 760,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            59 => 
            array (
                'id' => 4390,
                'sampleable_id' => 75,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 761,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            60 => 
            array (
                'id' => 4391,
                'sampleable_id' => 76,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 761,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            61 => 
            array (
                'id' => 4392,
                'sampleable_id' => 77,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 761,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:30',
                'updated_at' => '2026-02-13 15:58:30',
            ),
            62 => 
            array (
                'id' => 4393,
                'sampleable_id' => 78,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 762,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            63 => 
            array (
                'id' => 4394,
                'sampleable_id' => 79,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 762,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            64 => 
            array (
                'id' => 4395,
                'sampleable_id' => 80,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 762,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            65 => 
            array (
                'id' => 4396,
                'sampleable_id' => 81,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 762,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            66 => 
            array (
                'id' => 4397,
                'sampleable_id' => 82,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 762,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            67 => 
            array (
                'id' => 4398,
                'sampleable_id' => 78,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 763,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            68 => 
            array (
                'id' => 4399,
                'sampleable_id' => 79,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 763,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            69 => 
            array (
                'id' => 4400,
                'sampleable_id' => 80,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 763,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            70 => 
            array (
                'id' => 4401,
                'sampleable_id' => 81,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 763,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            71 => 
            array (
                'id' => 4402,
                'sampleable_id' => 82,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 763,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            72 => 
            array (
                'id' => 4403,
                'sampleable_id' => 78,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 764,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            73 => 
            array (
                'id' => 4404,
                'sampleable_id' => 79,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 764,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            74 => 
            array (
                'id' => 4405,
                'sampleable_id' => 80,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 764,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            75 => 
            array (
                'id' => 4406,
                'sampleable_id' => 81,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 764,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            76 => 
            array (
                'id' => 4407,
                'sampleable_id' => 82,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 764,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            77 => 
            array (
                'id' => 4408,
                'sampleable_id' => 78,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 765,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            78 => 
            array (
                'id' => 4409,
                'sampleable_id' => 79,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 765,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            79 => 
            array (
                'id' => 4410,
                'sampleable_id' => 80,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 765,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            80 => 
            array (
                'id' => 4411,
                'sampleable_id' => 81,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 765,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            81 => 
            array (
                'id' => 4412,
                'sampleable_id' => 82,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 765,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            82 => 
            array (
                'id' => 4413,
                'sampleable_id' => 78,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 766,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            83 => 
            array (
                'id' => 4414,
                'sampleable_id' => 79,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 766,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            84 => 
            array (
                'id' => 4415,
                'sampleable_id' => 80,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 766,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            85 => 
            array (
                'id' => 4416,
                'sampleable_id' => 81,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 766,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            86 => 
            array (
                'id' => 4417,
                'sampleable_id' => 82,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 766,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            87 => 
            array (
                'id' => 4418,
                'sampleable_id' => 78,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 767,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            88 => 
            array (
                'id' => 4419,
                'sampleable_id' => 79,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 767,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            89 => 
            array (
                'id' => 4420,
                'sampleable_id' => 80,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 767,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            90 => 
            array (
                'id' => 4421,
                'sampleable_id' => 81,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 767,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            91 => 
            array (
                'id' => 4422,
                'sampleable_id' => 82,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 767,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            92 => 
            array (
                'id' => 4423,
                'sampleable_id' => 84,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 768,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            93 => 
            array (
                'id' => 4424,
                'sampleable_id' => 85,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 768,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            94 => 
            array (
                'id' => 4425,
                'sampleable_id' => 86,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 768,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            95 => 
            array (
                'id' => 4426,
                'sampleable_id' => 87,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 768,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            96 => 
            array (
                'id' => 4427,
                'sampleable_id' => 88,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 768,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            97 => 
            array (
                'id' => 4428,
                'sampleable_id' => 89,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 768,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            98 => 
            array (
                'id' => 4429,
                'sampleable_id' => 90,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 768,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            99 => 
            array (
                'id' => 4430,
                'sampleable_id' => 84,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 769,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            100 => 
            array (
                'id' => 4431,
                'sampleable_id' => 85,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 769,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            101 => 
            array (
                'id' => 4432,
                'sampleable_id' => 86,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 769,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            102 => 
            array (
                'id' => 4433,
                'sampleable_id' => 87,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 769,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            103 => 
            array (
                'id' => 4434,
                'sampleable_id' => 88,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 769,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            104 => 
            array (
                'id' => 4435,
                'sampleable_id' => 89,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 769,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            105 => 
            array (
                'id' => 4436,
                'sampleable_id' => 90,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 769,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            106 => 
            array (
                'id' => 4437,
                'sampleable_id' => 91,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 770,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            107 => 
            array (
                'id' => 4438,
                'sampleable_id' => 92,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 770,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            108 => 
            array (
                'id' => 4439,
                'sampleable_id' => 93,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 770,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            109 => 
            array (
                'id' => 4440,
                'sampleable_id' => 94,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 770,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            110 => 
            array (
                'id' => 4441,
                'sampleable_id' => 95,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 770,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            111 => 
            array (
                'id' => 4442,
                'sampleable_id' => 96,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 770,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            112 => 
            array (
                'id' => 4443,
                'sampleable_id' => 97,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 770,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            113 => 
            array (
                'id' => 4444,
                'sampleable_id' => 98,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 770,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            114 => 
            array (
                'id' => 4445,
                'sampleable_id' => 99,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 770,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            115 => 
            array (
                'id' => 4446,
                'sampleable_id' => 100,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 770,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            116 => 
            array (
                'id' => 4447,
                'sampleable_id' => 101,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 770,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            117 => 
            array (
                'id' => 4448,
                'sampleable_id' => 102,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 770,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            118 => 
            array (
                'id' => 4449,
                'sampleable_id' => 91,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 771,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            119 => 
            array (
                'id' => 4450,
                'sampleable_id' => 92,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 771,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            120 => 
            array (
                'id' => 4451,
                'sampleable_id' => 93,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 771,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            121 => 
            array (
                'id' => 4452,
                'sampleable_id' => 94,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 771,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            122 => 
            array (
                'id' => 4453,
                'sampleable_id' => 95,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 771,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            123 => 
            array (
                'id' => 4454,
                'sampleable_id' => 96,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 771,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            124 => 
            array (
                'id' => 4455,
                'sampleable_id' => 97,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 771,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            125 => 
            array (
                'id' => 4456,
                'sampleable_id' => 98,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 771,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            126 => 
            array (
                'id' => 4457,
                'sampleable_id' => 99,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 771,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            127 => 
            array (
                'id' => 4458,
                'sampleable_id' => 100,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 771,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            128 => 
            array (
                'id' => 4459,
                'sampleable_id' => 101,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 771,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            129 => 
            array (
                'id' => 4460,
                'sampleable_id' => 102,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 771,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            130 => 
            array (
                'id' => 4461,
                'sampleable_id' => 91,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 772,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            131 => 
            array (
                'id' => 4462,
                'sampleable_id' => 92,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 772,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            132 => 
            array (
                'id' => 4463,
                'sampleable_id' => 93,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 772,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            133 => 
            array (
                'id' => 4464,
                'sampleable_id' => 94,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 772,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            134 => 
            array (
                'id' => 4465,
                'sampleable_id' => 95,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 772,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            135 => 
            array (
                'id' => 4466,
                'sampleable_id' => 96,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 772,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:31',
                'updated_at' => '2026-02-13 15:58:31',
            ),
            136 => 
            array (
                'id' => 4467,
                'sampleable_id' => 97,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 772,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            137 => 
            array (
                'id' => 4468,
                'sampleable_id' => 98,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 772,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            138 => 
            array (
                'id' => 4469,
                'sampleable_id' => 99,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 772,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            139 => 
            array (
                'id' => 4470,
                'sampleable_id' => 100,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 772,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            140 => 
            array (
                'id' => 4471,
                'sampleable_id' => 101,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 772,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            141 => 
            array (
                'id' => 4472,
                'sampleable_id' => 102,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 772,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            142 => 
            array (
                'id' => 4473,
                'sampleable_id' => 103,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 773,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            143 => 
            array (
                'id' => 4474,
                'sampleable_id' => 103,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 774,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            144 => 
            array (
                'id' => 4475,
                'sampleable_id' => 103,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 775,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            145 => 
            array (
                'id' => 4476,
                'sampleable_id' => 103,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 776,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            146 => 
            array (
                'id' => 4477,
                'sampleable_id' => 103,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 777,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            147 => 
            array (
                'id' => 4478,
                'sampleable_id' => 104,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 778,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            148 => 
            array (
                'id' => 4479,
                'sampleable_id' => 105,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 778,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            149 => 
            array (
                'id' => 4480,
                'sampleable_id' => 104,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 779,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            150 => 
            array (
                'id' => 4481,
                'sampleable_id' => 105,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 779,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            151 => 
            array (
                'id' => 4482,
                'sampleable_id' => 106,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 780,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            152 => 
            array (
                'id' => 4483,
                'sampleable_id' => 107,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 780,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            153 => 
            array (
                'id' => 4484,
                'sampleable_id' => 108,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 780,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            154 => 
            array (
                'id' => 4485,
                'sampleable_id' => 109,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 780,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            155 => 
            array (
                'id' => 4486,
                'sampleable_id' => 110,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 780,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            156 => 
            array (
                'id' => 4487,
                'sampleable_id' => 111,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 780,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            157 => 
            array (
                'id' => 4488,
                'sampleable_id' => 106,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 781,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            158 => 
            array (
                'id' => 4489,
                'sampleable_id' => 107,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 781,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            159 => 
            array (
                'id' => 4490,
                'sampleable_id' => 108,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 781,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            160 => 
            array (
                'id' => 4491,
                'sampleable_id' => 109,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 781,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            161 => 
            array (
                'id' => 4492,
                'sampleable_id' => 110,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 781,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            162 => 
            array (
                'id' => 4493,
                'sampleable_id' => 111,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 781,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            163 => 
            array (
                'id' => 4494,
                'sampleable_id' => 106,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 782,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            164 => 
            array (
                'id' => 4495,
                'sampleable_id' => 107,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 782,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            165 => 
            array (
                'id' => 4496,
                'sampleable_id' => 108,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 782,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            166 => 
            array (
                'id' => 4497,
                'sampleable_id' => 109,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 782,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            167 => 
            array (
                'id' => 4498,
                'sampleable_id' => 110,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 782,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            168 => 
            array (
                'id' => 4499,
                'sampleable_id' => 111,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 782,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            169 => 
            array (
                'id' => 4500,
                'sampleable_id' => 106,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 783,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            170 => 
            array (
                'id' => 4501,
                'sampleable_id' => 107,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 783,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            171 => 
            array (
                'id' => 4502,
                'sampleable_id' => 108,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 783,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            172 => 
            array (
                'id' => 4503,
                'sampleable_id' => 109,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 783,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            173 => 
            array (
                'id' => 4504,
                'sampleable_id' => 110,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 783,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            174 => 
            array (
                'id' => 4505,
                'sampleable_id' => 111,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 783,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            175 => 
            array (
                'id' => 4506,
                'sampleable_id' => 112,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 784,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            176 => 
            array (
                'id' => 4507,
                'sampleable_id' => 113,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 784,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            177 => 
            array (
                'id' => 4508,
                'sampleable_id' => 114,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 784,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            178 => 
            array (
                'id' => 4509,
                'sampleable_id' => 115,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 784,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            179 => 
            array (
                'id' => 4510,
                'sampleable_id' => 116,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 784,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            180 => 
            array (
                'id' => 4511,
                'sampleable_id' => 117,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 784,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            181 => 
            array (
                'id' => 4512,
                'sampleable_id' => 112,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 785,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            182 => 
            array (
                'id' => 4513,
                'sampleable_id' => 113,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 785,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            183 => 
            array (
                'id' => 4514,
                'sampleable_id' => 114,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 785,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            184 => 
            array (
                'id' => 4515,
                'sampleable_id' => 115,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 785,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            185 => 
            array (
                'id' => 4516,
                'sampleable_id' => 116,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 785,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            186 => 
            array (
                'id' => 4517,
                'sampleable_id' => 117,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 785,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            187 => 
            array (
                'id' => 4518,
                'sampleable_id' => 118,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 786,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            188 => 
            array (
                'id' => 4519,
                'sampleable_id' => 119,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 786,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            189 => 
            array (
                'id' => 4520,
                'sampleable_id' => 120,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 786,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            190 => 
            array (
                'id' => 4521,
                'sampleable_id' => 121,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 786,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            191 => 
            array (
                'id' => 4522,
                'sampleable_id' => 122,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 786,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            192 => 
            array (
                'id' => 4523,
                'sampleable_id' => 118,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 787,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            193 => 
            array (
                'id' => 4524,
                'sampleable_id' => 119,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 787,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            194 => 
            array (
                'id' => 4525,
                'sampleable_id' => 120,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 787,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            195 => 
            array (
                'id' => 4526,
                'sampleable_id' => 121,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 787,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            196 => 
            array (
                'id' => 4527,
                'sampleable_id' => 122,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 787,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:32',
                'updated_at' => '2026-02-13 15:58:32',
            ),
            197 => 
            array (
                'id' => 4528,
                'sampleable_id' => 118,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 788,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            198 => 
            array (
                'id' => 4529,
                'sampleable_id' => 119,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 788,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            199 => 
            array (
                'id' => 4530,
                'sampleable_id' => 120,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 788,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            200 => 
            array (
                'id' => 4531,
                'sampleable_id' => 121,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 788,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            201 => 
            array (
                'id' => 4532,
                'sampleable_id' => 122,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 788,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            202 => 
            array (
                'id' => 4533,
                'sampleable_id' => 118,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 789,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            203 => 
            array (
                'id' => 4534,
                'sampleable_id' => 119,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 789,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            204 => 
            array (
                'id' => 4535,
                'sampleable_id' => 120,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 789,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            205 => 
            array (
                'id' => 4536,
                'sampleable_id' => 121,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 789,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            206 => 
            array (
                'id' => 4537,
                'sampleable_id' => 122,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 789,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            207 => 
            array (
                'id' => 4538,
                'sampleable_id' => 118,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 790,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            208 => 
            array (
                'id' => 4539,
                'sampleable_id' => 119,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 790,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            209 => 
            array (
                'id' => 4540,
                'sampleable_id' => 120,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 790,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            210 => 
            array (
                'id' => 4541,
                'sampleable_id' => 121,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 790,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            211 => 
            array (
                'id' => 4542,
                'sampleable_id' => 122,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 790,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            212 => 
            array (
                'id' => 4543,
                'sampleable_id' => 118,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 791,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            213 => 
            array (
                'id' => 4544,
                'sampleable_id' => 119,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 791,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            214 => 
            array (
                'id' => 4545,
                'sampleable_id' => 120,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 791,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            215 => 
            array (
                'id' => 4546,
                'sampleable_id' => 121,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 791,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            216 => 
            array (
                'id' => 4547,
                'sampleable_id' => 122,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 791,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            217 => 
            array (
                'id' => 4548,
                'sampleable_id' => 118,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 792,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            218 => 
            array (
                'id' => 4549,
                'sampleable_id' => 119,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 792,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            219 => 
            array (
                'id' => 4550,
                'sampleable_id' => 120,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 792,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            220 => 
            array (
                'id' => 4551,
                'sampleable_id' => 121,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 792,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            221 => 
            array (
                'id' => 4552,
                'sampleable_id' => 122,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 792,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            222 => 
            array (
                'id' => 4553,
                'sampleable_id' => 118,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 793,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            223 => 
            array (
                'id' => 4554,
                'sampleable_id' => 119,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 793,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            224 => 
            array (
                'id' => 4555,
                'sampleable_id' => 120,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 793,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            225 => 
            array (
                'id' => 4556,
                'sampleable_id' => 121,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 793,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            226 => 
            array (
                'id' => 4557,
                'sampleable_id' => 122,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 793,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            227 => 
            array (
                'id' => 4558,
                'sampleable_id' => 123,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 794,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            228 => 
            array (
                'id' => 4559,
                'sampleable_id' => 124,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 794,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            229 => 
            array (
                'id' => 4560,
                'sampleable_id' => 125,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 794,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            230 => 
            array (
                'id' => 4561,
                'sampleable_id' => 123,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 795,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            231 => 
            array (
                'id' => 4562,
                'sampleable_id' => 124,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 795,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            232 => 
            array (
                'id' => 4563,
                'sampleable_id' => 125,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 795,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            233 => 
            array (
                'id' => 4564,
                'sampleable_id' => 123,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 796,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            234 => 
            array (
                'id' => 4565,
                'sampleable_id' => 124,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 796,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            235 => 
            array (
                'id' => 4566,
                'sampleable_id' => 125,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 796,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            236 => 
            array (
                'id' => 4567,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 797,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            237 => 
            array (
                'id' => 4568,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 797,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            238 => 
            array (
                'id' => 4569,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 797,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            239 => 
            array (
                'id' => 4570,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 797,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            240 => 
            array (
                'id' => 4571,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 797,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            241 => 
            array (
                'id' => 4572,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 797,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            242 => 
            array (
                'id' => 4573,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 798,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            243 => 
            array (
                'id' => 4574,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 798,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            244 => 
            array (
                'id' => 4575,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 798,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            245 => 
            array (
                'id' => 4576,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 798,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            246 => 
            array (
                'id' => 4577,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 798,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            247 => 
            array (
                'id' => 4578,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 798,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            248 => 
            array (
                'id' => 4579,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 799,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            249 => 
            array (
                'id' => 4580,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 799,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            250 => 
            array (
                'id' => 4581,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 799,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            251 => 
            array (
                'id' => 4582,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 799,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            252 => 
            array (
                'id' => 4583,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 799,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            253 => 
            array (
                'id' => 4584,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 799,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            254 => 
            array (
                'id' => 4585,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 800,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            255 => 
            array (
                'id' => 4586,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 800,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            256 => 
            array (
                'id' => 4587,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 800,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            257 => 
            array (
                'id' => 4588,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 800,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            258 => 
            array (
                'id' => 4589,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 800,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            259 => 
            array (
                'id' => 4590,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 800,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:33',
                'updated_at' => '2026-02-13 15:58:33',
            ),
            260 => 
            array (
                'id' => 4591,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 801,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            261 => 
            array (
                'id' => 4592,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 801,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            262 => 
            array (
                'id' => 4593,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 801,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            263 => 
            array (
                'id' => 4594,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 801,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            264 => 
            array (
                'id' => 4595,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 801,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            265 => 
            array (
                'id' => 4596,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 801,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            266 => 
            array (
                'id' => 4597,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 802,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            267 => 
            array (
                'id' => 4598,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 802,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            268 => 
            array (
                'id' => 4599,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 802,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            269 => 
            array (
                'id' => 4600,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 802,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            270 => 
            array (
                'id' => 4601,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 802,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            271 => 
            array (
                'id' => 4602,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 802,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            272 => 
            array (
                'id' => 4603,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 803,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            273 => 
            array (
                'id' => 4604,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 803,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            274 => 
            array (
                'id' => 4605,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 803,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            275 => 
            array (
                'id' => 4606,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 803,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            276 => 
            array (
                'id' => 4607,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 803,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            277 => 
            array (
                'id' => 4608,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 803,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            278 => 
            array (
                'id' => 4609,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 804,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            279 => 
            array (
                'id' => 4610,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 804,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            280 => 
            array (
                'id' => 4611,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 804,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            281 => 
            array (
                'id' => 4612,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 804,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            282 => 
            array (
                'id' => 4613,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 804,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            283 => 
            array (
                'id' => 4614,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 804,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            284 => 
            array (
                'id' => 4615,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 805,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            285 => 
            array (
                'id' => 4616,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 805,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            286 => 
            array (
                'id' => 4617,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 805,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            287 => 
            array (
                'id' => 4618,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 805,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            288 => 
            array (
                'id' => 4619,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 805,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            289 => 
            array (
                'id' => 4620,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 805,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            290 => 
            array (
                'id' => 4621,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 806,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            291 => 
            array (
                'id' => 4622,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 806,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            292 => 
            array (
                'id' => 4623,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 806,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            293 => 
            array (
                'id' => 4624,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 806,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            294 => 
            array (
                'id' => 4625,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 806,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            295 => 
            array (
                'id' => 4626,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 806,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            296 => 
            array (
                'id' => 4627,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 807,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            297 => 
            array (
                'id' => 4628,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 807,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            298 => 
            array (
                'id' => 4629,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 807,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            299 => 
            array (
                'id' => 4630,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 807,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            300 => 
            array (
                'id' => 4631,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 807,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            301 => 
            array (
                'id' => 4632,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 807,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            302 => 
            array (
                'id' => 4633,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 808,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            303 => 
            array (
                'id' => 4634,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 808,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            304 => 
            array (
                'id' => 4635,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 808,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            305 => 
            array (
                'id' => 4636,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 808,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            306 => 
            array (
                'id' => 4637,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 808,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            307 => 
            array (
                'id' => 4638,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 808,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            308 => 
            array (
                'id' => 4639,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 809,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            309 => 
            array (
                'id' => 4640,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 809,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            310 => 
            array (
                'id' => 4641,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 809,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            311 => 
            array (
                'id' => 4642,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 809,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            312 => 
            array (
                'id' => 4643,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 809,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            313 => 
            array (
                'id' => 4644,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 809,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            314 => 
            array (
                'id' => 4645,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 810,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            315 => 
            array (
                'id' => 4646,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 810,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            316 => 
            array (
                'id' => 4647,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 810,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            317 => 
            array (
                'id' => 4648,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 810,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            318 => 
            array (
                'id' => 4649,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 810,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            319 => 
            array (
                'id' => 4650,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 810,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            320 => 
            array (
                'id' => 4651,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 811,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            321 => 
            array (
                'id' => 4652,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 811,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            322 => 
            array (
                'id' => 4653,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 811,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            323 => 
            array (
                'id' => 4654,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 811,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            324 => 
            array (
                'id' => 4655,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 811,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            325 => 
            array (
                'id' => 4656,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 811,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            326 => 
            array (
                'id' => 4657,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 812,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            327 => 
            array (
                'id' => 4658,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 812,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            328 => 
            array (
                'id' => 4659,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 812,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            329 => 
            array (
                'id' => 4660,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 812,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            330 => 
            array (
                'id' => 4661,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 812,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            331 => 
            array (
                'id' => 4662,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 812,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            332 => 
            array (
                'id' => 4663,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 813,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            333 => 
            array (
                'id' => 4664,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 813,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            334 => 
            array (
                'id' => 4665,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 813,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            335 => 
            array (
                'id' => 4666,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 813,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            336 => 
            array (
                'id' => 4667,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 813,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            337 => 
            array (
                'id' => 4668,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 813,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            338 => 
            array (
                'id' => 4669,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 814,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            339 => 
            array (
                'id' => 4670,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 814,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            340 => 
            array (
                'id' => 4671,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 814,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            341 => 
            array (
                'id' => 4672,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 814,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            342 => 
            array (
                'id' => 4673,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 814,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            343 => 
            array (
                'id' => 4674,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 814,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:34',
                'updated_at' => '2026-02-13 15:58:34',
            ),
            344 => 
            array (
                'id' => 4675,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 815,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            345 => 
            array (
                'id' => 4676,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 815,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            346 => 
            array (
                'id' => 4677,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 815,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            347 => 
            array (
                'id' => 4678,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 815,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            348 => 
            array (
                'id' => 4679,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 815,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            349 => 
            array (
                'id' => 4680,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 815,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            350 => 
            array (
                'id' => 4681,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 816,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            351 => 
            array (
                'id' => 4682,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 816,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            352 => 
            array (
                'id' => 4683,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 816,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            353 => 
            array (
                'id' => 4684,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 816,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            354 => 
            array (
                'id' => 4685,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 816,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            355 => 
            array (
                'id' => 4686,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 816,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            356 => 
            array (
                'id' => 4687,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 817,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            357 => 
            array (
                'id' => 4688,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 817,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            358 => 
            array (
                'id' => 4689,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 817,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            359 => 
            array (
                'id' => 4690,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 817,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            360 => 
            array (
                'id' => 4691,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 817,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            361 => 
            array (
                'id' => 4692,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 817,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            362 => 
            array (
                'id' => 4693,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 818,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            363 => 
            array (
                'id' => 4694,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 818,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            364 => 
            array (
                'id' => 4695,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 818,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            365 => 
            array (
                'id' => 4696,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 818,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            366 => 
            array (
                'id' => 4697,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 818,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            367 => 
            array (
                'id' => 4698,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 818,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            368 => 
            array (
                'id' => 4699,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 819,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            369 => 
            array (
                'id' => 4700,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 819,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            370 => 
            array (
                'id' => 4701,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 819,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            371 => 
            array (
                'id' => 4702,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 819,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            372 => 
            array (
                'id' => 4703,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 819,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            373 => 
            array (
                'id' => 4704,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 819,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            374 => 
            array (
                'id' => 4705,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 820,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            375 => 
            array (
                'id' => 4706,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 820,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            376 => 
            array (
                'id' => 4707,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 820,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            377 => 
            array (
                'id' => 4708,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 820,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            378 => 
            array (
                'id' => 4709,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 820,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            379 => 
            array (
                'id' => 4710,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 820,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            380 => 
            array (
                'id' => 4711,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 821,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            381 => 
            array (
                'id' => 4712,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 821,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            382 => 
            array (
                'id' => 4713,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 821,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            383 => 
            array (
                'id' => 4714,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 821,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            384 => 
            array (
                'id' => 4715,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 821,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            385 => 
            array (
                'id' => 4716,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 821,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            386 => 
            array (
                'id' => 4717,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 822,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            387 => 
            array (
                'id' => 4718,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 822,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            388 => 
            array (
                'id' => 4719,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 822,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            389 => 
            array (
                'id' => 4720,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 822,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            390 => 
            array (
                'id' => 4721,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 822,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            391 => 
            array (
                'id' => 4722,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 822,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            392 => 
            array (
                'id' => 4723,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 823,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            393 => 
            array (
                'id' => 4724,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 823,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            394 => 
            array (
                'id' => 4725,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 823,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            395 => 
            array (
                'id' => 4726,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 823,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            396 => 
            array (
                'id' => 4727,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 823,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            397 => 
            array (
                'id' => 4728,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 823,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            398 => 
            array (
                'id' => 4729,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 824,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            399 => 
            array (
                'id' => 4730,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 824,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            400 => 
            array (
                'id' => 4731,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 824,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            401 => 
            array (
                'id' => 4732,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 824,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            402 => 
            array (
                'id' => 4733,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 824,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            403 => 
            array (
                'id' => 4734,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 824,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            404 => 
            array (
                'id' => 4735,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 825,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            405 => 
            array (
                'id' => 4736,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 825,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            406 => 
            array (
                'id' => 4737,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 825,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            407 => 
            array (
                'id' => 4738,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 825,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            408 => 
            array (
                'id' => 4739,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 825,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            409 => 
            array (
                'id' => 4740,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 825,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            410 => 
            array (
                'id' => 4741,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 826,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            411 => 
            array (
                'id' => 4742,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 826,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            412 => 
            array (
                'id' => 4743,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 826,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            413 => 
            array (
                'id' => 4744,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 826,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            414 => 
            array (
                'id' => 4745,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 826,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            415 => 
            array (
                'id' => 4746,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 826,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            416 => 
            array (
                'id' => 4747,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 827,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            417 => 
            array (
                'id' => 4748,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 827,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            418 => 
            array (
                'id' => 4749,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 827,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            419 => 
            array (
                'id' => 4750,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 827,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            420 => 
            array (
                'id' => 4751,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 827,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            421 => 
            array (
                'id' => 4752,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 827,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            422 => 
            array (
                'id' => 4753,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 828,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            423 => 
            array (
                'id' => 4754,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 828,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            424 => 
            array (
                'id' => 4755,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 828,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            425 => 
            array (
                'id' => 4756,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 828,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            426 => 
            array (
                'id' => 4757,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 828,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            427 => 
            array (
                'id' => 4758,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 828,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            428 => 
            array (
                'id' => 4759,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 829,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            429 => 
            array (
                'id' => 4760,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 829,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:35',
                'updated_at' => '2026-02-13 15:58:35',
            ),
            430 => 
            array (
                'id' => 4761,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 829,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            431 => 
            array (
                'id' => 4762,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 829,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            432 => 
            array (
                'id' => 4763,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 829,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            433 => 
            array (
                'id' => 4764,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 829,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            434 => 
            array (
                'id' => 4765,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 830,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            435 => 
            array (
                'id' => 4766,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 830,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            436 => 
            array (
                'id' => 4767,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 830,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            437 => 
            array (
                'id' => 4768,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 830,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            438 => 
            array (
                'id' => 4769,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 830,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            439 => 
            array (
                'id' => 4770,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 830,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            440 => 
            array (
                'id' => 4771,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 831,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            441 => 
            array (
                'id' => 4772,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 831,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            442 => 
            array (
                'id' => 4773,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 831,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            443 => 
            array (
                'id' => 4774,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 831,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            444 => 
            array (
                'id' => 4775,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 831,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            445 => 
            array (
                'id' => 4776,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 831,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            446 => 
            array (
                'id' => 4777,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 832,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            447 => 
            array (
                'id' => 4778,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 832,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            448 => 
            array (
                'id' => 4779,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 832,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            449 => 
            array (
                'id' => 4780,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 832,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            450 => 
            array (
                'id' => 4781,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 832,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            451 => 
            array (
                'id' => 4782,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 832,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            452 => 
            array (
                'id' => 4783,
                'sampleable_id' => 126,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 833,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            453 => 
            array (
                'id' => 4784,
                'sampleable_id' => 127,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 833,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            454 => 
            array (
                'id' => 4785,
                'sampleable_id' => 128,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 833,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            455 => 
            array (
                'id' => 4786,
                'sampleable_id' => 129,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 833,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            456 => 
            array (
                'id' => 4787,
                'sampleable_id' => 130,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 833,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            457 => 
            array (
                'id' => 4788,
                'sampleable_id' => 131,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 833,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            458 => 
            array (
                'id' => 4789,
                'sampleable_id' => 142,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 834,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            459 => 
            array (
                'id' => 4790,
                'sampleable_id' => 143,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 834,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            460 => 
            array (
                'id' => 4791,
                'sampleable_id' => 144,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 834,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            461 => 
            array (
                'id' => 4792,
                'sampleable_id' => 145,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 834,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            462 => 
            array (
                'id' => 4793,
                'sampleable_id' => 146,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 835,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            463 => 
            array (
                'id' => 4794,
                'sampleable_id' => 147,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 835,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            464 => 
            array (
                'id' => 4795,
                'sampleable_id' => 148,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 835,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            465 => 
            array (
                'id' => 4796,
                'sampleable_id' => 149,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 835,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            466 => 
            array (
                'id' => 4797,
                'sampleable_id' => 150,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 835,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            467 => 
            array (
                'id' => 4798,
                'sampleable_id' => 146,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 836,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            468 => 
            array (
                'id' => 4799,
                'sampleable_id' => 147,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 836,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            469 => 
            array (
                'id' => 4800,
                'sampleable_id' => 148,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 836,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            470 => 
            array (
                'id' => 4801,
                'sampleable_id' => 149,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 836,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            471 => 
            array (
                'id' => 4802,
                'sampleable_id' => 150,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 836,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            472 => 
            array (
                'id' => 4803,
                'sampleable_id' => 146,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 837,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            473 => 
            array (
                'id' => 4804,
                'sampleable_id' => 147,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 837,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            474 => 
            array (
                'id' => 4805,
                'sampleable_id' => 148,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 837,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            475 => 
            array (
                'id' => 4806,
                'sampleable_id' => 149,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 837,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            476 => 
            array (
                'id' => 4807,
                'sampleable_id' => 150,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 837,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            477 => 
            array (
                'id' => 4808,
                'sampleable_id' => 146,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 838,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            478 => 
            array (
                'id' => 4809,
                'sampleable_id' => 147,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 838,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            479 => 
            array (
                'id' => 4810,
                'sampleable_id' => 148,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 838,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            480 => 
            array (
                'id' => 4811,
                'sampleable_id' => 149,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 838,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            481 => 
            array (
                'id' => 4812,
                'sampleable_id' => 150,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 838,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            482 => 
            array (
                'id' => 4813,
                'sampleable_id' => 146,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 839,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            483 => 
            array (
                'id' => 4814,
                'sampleable_id' => 147,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 839,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            484 => 
            array (
                'id' => 4815,
                'sampleable_id' => 148,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 839,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            485 => 
            array (
                'id' => 4816,
                'sampleable_id' => 149,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 839,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            486 => 
            array (
                'id' => 4817,
                'sampleable_id' => 150,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 839,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            487 => 
            array (
                'id' => 4818,
                'sampleable_id' => 146,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 840,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            488 => 
            array (
                'id' => 4819,
                'sampleable_id' => 147,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 840,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            489 => 
            array (
                'id' => 4820,
                'sampleable_id' => 148,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 840,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            490 => 
            array (
                'id' => 4821,
                'sampleable_id' => 149,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 840,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            491 => 
            array (
                'id' => 4822,
                'sampleable_id' => 150,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 840,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            492 => 
            array (
                'id' => 4823,
                'sampleable_id' => 146,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 841,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            493 => 
            array (
                'id' => 4824,
                'sampleable_id' => 147,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 841,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            494 => 
            array (
                'id' => 4825,
                'sampleable_id' => 148,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 841,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            495 => 
            array (
                'id' => 4826,
                'sampleable_id' => 149,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 841,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            496 => 
            array (
                'id' => 4827,
                'sampleable_id' => 150,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 841,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            497 => 
            array (
                'id' => 4828,
                'sampleable_id' => 146,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 842,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            498 => 
            array (
                'id' => 4829,
                'sampleable_id' => 147,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 842,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            499 => 
            array (
                'id' => 4830,
                'sampleable_id' => 148,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 842,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
        ));
        \DB::table('testservice_samples')->insert(array (
            0 => 
            array (
                'id' => 4831,
                'sampleable_id' => 149,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 842,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            1 => 
            array (
                'id' => 4832,
                'sampleable_id' => 150,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 842,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            2 => 
            array (
                'id' => 4833,
                'sampleable_id' => 151,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 843,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            3 => 
            array (
                'id' => 4834,
                'sampleable_id' => 152,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 843,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            4 => 
            array (
                'id' => 4835,
                'sampleable_id' => 153,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 843,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:36',
                'updated_at' => '2026-02-13 15:58:36',
            ),
            5 => 
            array (
                'id' => 4836,
                'sampleable_id' => 151,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 844,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            6 => 
            array (
                'id' => 4837,
                'sampleable_id' => 152,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 844,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            7 => 
            array (
                'id' => 4838,
                'sampleable_id' => 153,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 844,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            8 => 
            array (
                'id' => 4839,
                'sampleable_id' => 151,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 845,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            9 => 
            array (
                'id' => 4840,
                'sampleable_id' => 152,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 845,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            10 => 
            array (
                'id' => 4841,
                'sampleable_id' => 153,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 845,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            11 => 
            array (
                'id' => 4842,
                'sampleable_id' => 151,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 846,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            12 => 
            array (
                'id' => 4843,
                'sampleable_id' => 152,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 846,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            13 => 
            array (
                'id' => 4844,
                'sampleable_id' => 153,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 846,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            14 => 
            array (
                'id' => 4845,
                'sampleable_id' => 154,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 847,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            15 => 
            array (
                'id' => 4846,
                'sampleable_id' => 155,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 847,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            16 => 
            array (
                'id' => 4847,
                'sampleable_id' => 156,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 847,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            17 => 
            array (
                'id' => 4848,
                'sampleable_id' => 154,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 848,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            18 => 
            array (
                'id' => 4849,
                'sampleable_id' => 155,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 848,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            19 => 
            array (
                'id' => 4850,
                'sampleable_id' => 156,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 848,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            20 => 
            array (
                'id' => 4851,
                'sampleable_id' => 157,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 849,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            21 => 
            array (
                'id' => 4852,
                'sampleable_id' => 158,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 849,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            22 => 
            array (
                'id' => 4853,
                'sampleable_id' => 159,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 849,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            23 => 
            array (
                'id' => 4854,
                'sampleable_id' => 157,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 850,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            24 => 
            array (
                'id' => 4855,
                'sampleable_id' => 158,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 850,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            25 => 
            array (
                'id' => 4856,
                'sampleable_id' => 159,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 850,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            26 => 
            array (
                'id' => 4857,
                'sampleable_id' => 157,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 851,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            27 => 
            array (
                'id' => 4858,
                'sampleable_id' => 158,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 851,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            28 => 
            array (
                'id' => 4859,
                'sampleable_id' => 159,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 851,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            29 => 
            array (
                'id' => 4860,
                'sampleable_id' => 157,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 852,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            30 => 
            array (
                'id' => 4861,
                'sampleable_id' => 158,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 852,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            31 => 
            array (
                'id' => 4862,
                'sampleable_id' => 159,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 852,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            32 => 
            array (
                'id' => 4863,
                'sampleable_id' => 157,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 853,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            33 => 
            array (
                'id' => 4864,
                'sampleable_id' => 158,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 853,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            34 => 
            array (
                'id' => 4865,
                'sampleable_id' => 159,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 853,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            35 => 
            array (
                'id' => 4866,
                'sampleable_id' => 157,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 854,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            36 => 
            array (
                'id' => 4867,
                'sampleable_id' => 158,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 854,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
            37 => 
            array (
                'id' => 4868,
                'sampleable_id' => 159,
                'sampleable_type' => 'App\\Models\\SampleName',
                'testservice_id' => 854,
                'added_by' => 2,
                'created_at' => '2026-02-13 15:58:37',
                'updated_at' => '2026-02-13 15:58:37',
            ),
        ));
        
        
    }
}