<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TsrSequencesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('tsr_sequences')->delete();

        \DB::table('tsr_sequences')->insert(array (
            0 => 
            array (
                'id' => 1,
                'next_sequence' => 324,
                'year' => 2026,
                'type_id' => 9,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 1,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-09-08 16:13:50',
            ),
            1 => 
            array (
                'id' => 2,
                'next_sequence' => 411,
                'year' => 2026,
                'type_id' => 9,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 2,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-09-09 08:27:40',
            ),
            2 => 
            array (
                'id' => 3,
                'next_sequence' => 716,
                'year' => 2026,
                'type_id' => 9,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 3,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-09-09 08:33:11',
            ),
            3 => 
            array (
                'id' => 4,
                'next_sequence' => 27,
                'year' => 2026,
                'type_id' => 9,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 4,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-09-07 09:53:51',
            ),
            4 => 
            array (
                'id' => 5,
                'next_sequence' => 814,
                'year' => 2026,
                'type_id' => 10,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 1,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-09-08 16:13:50',
            ),
            5 => 
            array (
                'id' => 6,
                'next_sequence' => 1192,
                'year' => 2026,
                'type_id' => 10,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 2,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-09-09 08:27:40',
            ),
            6 => 
            array (
                'id' => 7,
                'next_sequence' => 1856,
                'year' => 2026,
                'type_id' => 10,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 3,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-09-09 08:33:11',
            ),
            7 => 
            array (
                'id' => 8,
                'next_sequence' => 175,
                'year' => 2026,
                'type_id' => 10,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 4,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-09-07 09:53:51',
            ),
            8 => 
            array (
                'id' => 9,
                'next_sequence' => 682,
                'year' => 2026,
                'type_id' => 11,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 1,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-09-07 08:14:32',
            ),
            9 => 
            array (
                'id' => 10,
                'next_sequence' => 1073,
                'year' => 2026,
                'type_id' => 11,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 2,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-09-08 17:45:30',
            ),
            10 => 
            array (
                'id' => 11,
                'next_sequence' => 1252,
                'year' => 2026,
                'type_id' => 11,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 3,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-09-08 11:56:21',
            ),
            11 => 
            array (
                'id' => 12,
                'next_sequence' => 140,
                'year' => 2026,
                'type_id' => 11,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 4,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-09-08 12:47:35',
            ),
            12 => 
            array (
                'id' => 13,
                'next_sequence' => 505,
                'year' => 2026,
                'type_id' => 12,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 1,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-09-09 07:23:28',
            ),
            13 => 
            array (
                'id' => 14,
                'next_sequence' => 3,
                'year' => 2026,
                'type_id' => 12,
                'facility_id' => 2,
                'agency_id' => 14,
                'laboratory_id' => 1,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-08-20 11:01:59',
            ),
            14 => 
            array (
                'id' => 15,
                'next_sequence' => 17,
                'year' => 2026,
                'type_id' => 9,
                'facility_id' => 2,
                'agency_id' => 14,
                'laboratory_id' => 3,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-09-07 15:31:22',
            ),
            15 => 
            array (
                'id' => 16,
                'next_sequence' => 22,
                'year' => 2026,
                'type_id' => 10,
                'facility_id' => 2,
                'agency_id' => 14,
                'laboratory_id' => 3,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-09-07 15:31:22',
            ),
            16 => 
            array (
                'id' => 17,
                'next_sequence' => 5,
                'year' => 2026,
                'type_id' => 11,
                'facility_id' => 2,
                'agency_id' => 14,
                'laboratory_id' => 3,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-09-07 16:51:25',
            ),
        ));


    }
}
