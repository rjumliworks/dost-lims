<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AgenciesTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('agencies')->delete();
        
        \DB::table('agencies')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'R1',
                'name' => 'DOST-I',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 2,
                'member_id' => 1,
                'created_at' => '2024-02-28 22:42:29',
                'updated_at' => '2024-02-28 22:42:29',
            ),
            1 => 
            array (
                'id' => 3,
                'code' => 'R2',
                'name' => 'DOST-II',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 2,
                'member_id' => 2,
                'created_at' => '2024-02-28 22:46:42',
                'updated_at' => '2024-02-28 22:46:42',
            ),
            2 => 
            array (
                'id' => 4,
                'code' => 'R3',
                'name' => 'DOST-III',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 2,
                'member_id' => 3,
                'created_at' => '2024-02-28 22:49:43',
                'updated_at' => '2024-02-28 22:49:43',
            ),
            3 => 
            array (
                'id' => 5,
                'code' => 'R4AL1',
                'name' => 'DOST-CALABARZON-L1',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 2,
                'member_id' => 4,
                'created_at' => '2024-02-28 22:53:59',
                'updated_at' => '2024-02-28 22:53:59',
            ),
            4 => 
            array (
                'id' => 6,
                'code' => 'R4AL2',
                'name' => 'DOST-CALABARZON-L2',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 4,
                'member_id' => 4,
                'created_at' => '2024-02-28 23:02:55',
                'updated_at' => '2024-02-28 23:02:55',
            ),
            5 => 
            array (
                'id' => 7,
                'code' => 'R4AL3',
                'name' => 'DOST-CALABARZON-L3',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 5,
                'member_id' => 4,
                'created_at' => '2024-02-28 23:04:41',
                'updated_at' => '2024-02-28 23:04:41',
            ),
            6 => 
            array (
                'id' => 9,
                'code' => 'R4B',
                'name' => 'DOST-4B',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 2,
                'member_id' => 5,
                'created_at' => '2024-02-28 23:10:33',
                'updated_at' => '2024-02-28 23:10:33',
            ),
            7 => 
            array (
                'id' => 10,
                'code' => 'R5',
                'name' => 'DOST-V',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 2,
                'member_id' => 6,
                'created_at' => '2024-02-28 23:12:58',
                'updated_at' => '2024-02-28 23:12:58',
            ),
            8 => 
            array (
                'id' => 11,
                'code' => 'R6',
                'name' => 'DOST-VI',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 1,
                'type_id' => 2,
                'member_id' => 7,
                'created_at' => '2024-02-28 23:17:06',
                'updated_at' => '2025-05-05 20:40:15',
            ),
            9 => 
            array (
                'id' => 12,
                'code' => 'R7',
                'name' => 'DOST-VII',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 2,
                'member_id' => 8,
                'created_at' => '2024-02-28 23:20:31',
                'updated_at' => '2024-02-28 23:20:31',
            ),
            10 => 
            array (
                'id' => 13,
                'code' => 'R8',
                'name' => 'DOST-VIII',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 2,
                'member_id' => 9,
                'created_at' => '2024-02-28 23:21:56',
                'updated_at' => '2024-02-28 23:21:56',
            ),
            11 => 
            array (
                'id' => 14,
                'code' => 'R9',
                'name' => 'DOST-IX',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 1,
                'type_id' => 2,
                'member_id' => 10,
                'created_at' => '2024-02-28 23:24:53',
                'updated_at' => '2025-05-04 11:05:39',
            ),
            12 => 
            array (
                'id' => 15,
                'code' => 'R10',
                'name' => 'DOST-X',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 2,
                'member_id' => 11,
                'created_at' => '2024-02-28 23:26:25',
                'updated_at' => '2024-02-28 23:26:25',
            ),
            13 => 
            array (
                'id' => 16,
                'code' => 'R11',
                'name' => 'DOST-XI',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 2,
                'member_id' => 12,
                'created_at' => '2024-02-28 23:28:40',
                'updated_at' => '2024-02-28 23:28:40',
            ),
            14 => 
            array (
                'id' => 17,
                'code' => 'R12L1',
                'name' => 'DOST-XII-L1',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 2,
                'member_id' => 13,
                'created_at' => '2024-02-28 23:31:39',
                'updated_at' => '2024-02-28 23:31:39',
            ),
            15 => 
            array (
                'id' => 18,
                'code' => 'R12L2',
                'name' => 'DOST-XII-L2',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 2,
                'member_id' => 13,
                'created_at' => '2024-02-28 23:36:37',
                'updated_at' => '2024-02-28 23:36:37',
            ),
            16 => 
            array (
                'id' => 19,
                'code' => 'R13',
                'name' => 'DOST-CARAGA',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 2,
                'member_id' => 14,
                'created_at' => '2024-02-28 23:39:52',
                'updated_at' => '2024-02-28 23:39:52',
            ),
            17 => 
            array (
                'id' => 20,
                'code' => 'BARMM',
                'name' => 'MOST-BARMM',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 2,
                'member_id' => 16,
                'created_at' => '2024-02-28 23:42:03',
                'updated_at' => '2024-02-28 23:42:03',
            ),
            18 => 
            array (
                'id' => 21,
                'code' => 'FNRI',
                'name' => 'DOST-FNRI',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 3,
                'member_id' => 19,
                'created_at' => '2024-02-28 23:46:17',
                'updated_at' => '2024-02-28 23:46:17',
            ),
            19 => 
            array (
                'id' => 22,
                'code' => 'FPRDI',
                'name' => 'DOST-FPRDI',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 3,
                'member_id' => 20,
                'created_at' => '2024-02-28 23:47:50',
                'updated_at' => '2024-02-28 23:47:50',
            ),
            20 => 
            array (
                'id' => 23,
                'code' => 'ITDI',
                'name' => 'DOST-ITDI',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 3,
                'member_id' => 21,
                'created_at' => '2024-02-28 23:50:24',
                'updated_at' => '2024-02-28 23:50:24',
            ),
            21 => 
            array (
                'id' => 24,
                'code' => 'MIRDC',
                'name' => 'DOST-MIRDC',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 3,
                'member_id' => 22,
                'created_at' => '2024-02-28 23:51:33',
                'updated_at' => '2024-02-28 23:51:33',
            ),
            22 => 
            array (
                'id' => 25,
                'code' => 'PNRI',
                'name' => 'DOST-PNRI',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 3,
                'member_id' => 23,
                'created_at' => '2024-02-28 23:55:33',
                'updated_at' => '2024-02-28 23:55:33',
            ),
            23 => 
            array (
                'id' => 26,
                'code' => 'PTRI',
                'name' => 'DOST-PTRI',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 3,
                'member_id' => 24,
                'created_at' => '2024-02-28 23:56:31',
                'updated_at' => '2024-02-28 23:56:31',
            ),
            24 => 
            array (
                'id' => 27,
                'code' => 'FDA',
                'name' => 'FDA',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 1,
                'member_id' => 25,
                'created_at' => '2024-02-29 00:29:28',
                'updated_at' => '2024-02-29 00:29:28',
            ),
            25 => 
            array (
                'id' => 28,
                'code' => 'NRL',
                'name' => 'DOH-NRL',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 1,
                'member_id' => 26,
                'created_at' => '2024-02-29 00:31:50',
                'updated_at' => '2024-02-29 00:31:50',
            ),
            26 => 
            array (
                'id' => 29,
                'code' => 'FPA',
                'name' => 'FPA',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 1,
                'member_id' => 27,
                'created_at' => '2024-02-29 00:33:08',
                'updated_at' => '2024-02-29 00:33:08',
            ),
            27 => 
            array (
                'id' => 30,
                'code' => 'NIH',
                'name' => 'UP-NIH',
                'member_since' => NULL,
                'contact_no' => NULL,
                'is_active' => 0,
                'type_id' => 1,
                'member_id' => 28,
                'created_at' => '2024-02-29 00:34:40',
                'updated_at' => '2024-02-29 00:34:40',
            ),
        ));

        
    }
}