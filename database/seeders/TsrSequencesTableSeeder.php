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
                'next_sequence' => 10,
                'year' => 2026,
                'type_id' => 9,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 1,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-02-18 14:07:48',
            ),
            1 => 
            array (
                'id' => 2,
                'next_sequence' => 1,
                'year' => 2026,
                'type_id' => 9,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 2,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-01-01 09:12:03',
            ),
            2 => 
            array (
                'id' => 3,
                'next_sequence' => 4,
                'year' => 2026,
                'type_id' => 9,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 3,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-02-16 13:21:17',
            ),
            3 => 
            array (
                'id' => 4,
                'next_sequence' => 1,
                'year' => 2026,
                'type_id' => 9,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 4,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-01-01 09:12:03',
            ),
            4 => 
            array (
                'id' => 5,
                'next_sequence' => 7,
                'year' => 2026,
                'type_id' => 10,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 1,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-02-18 11:51:40',
            ),
            5 => 
            array (
                'id' => 6,
                'next_sequence' => 1,
                'year' => 2026,
                'type_id' => 10,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 2,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-01-01 09:12:03',
            ),
            6 => 
            array (
                'id' => 7,
                'next_sequence' => 5,
                'year' => 2026,
                'type_id' => 10,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 3,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-02-16 13:21:17',
            ),
            7 => 
            array (
                'id' => 8,
                'next_sequence' => 1,
                'year' => 2026,
                'type_id' => 10,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 4,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-01-01 09:12:03',
            ),
            8 => 
            array (
                'id' => 9,
                'next_sequence' => 1,
                'year' => 2026,
                'type_id' => 11,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 1,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-01-01 09:12:03',
            ),
            9 => 
            array (
                'id' => 10,
                'next_sequence' => 1,
                'year' => 2026,
                'type_id' => 11,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 2,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-01-01 09:12:03',
            ),
            10 => 
            array (
                'id' => 11,
                'next_sequence' => 1,
                'year' => 2026,
                'type_id' => 11,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 3,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-01-01 09:12:03',
            ),
            11 => 
            array (
                'id' => 12,
                'next_sequence' => 1,
                'year' => 2026,
                'type_id' => 11,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 4,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-01-01 09:12:03',
            ),
            12 => 
            array (
                'id' => 13,
                'next_sequence' => 4,
                'year' => 2026,
                'type_id' => 12,
                'facility_id' => 1,
                'agency_id' => 14,
                'laboratory_id' => 1,
                'created_at' => '2026-01-01 09:12:03',
                'updated_at' => '2026-02-19 13:19:37',
            ),
        ));
        
        
    }
}