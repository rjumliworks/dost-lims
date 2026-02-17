<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_roles')->delete();
        
        \DB::table('user_roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'is_active' => 1,
                'is_primary' => 1,
                'laboratory_id' => NULL,
                'role_id' => 1,
                'user_id' => 1,
                'added_by' => 1,
                'removed_by' => NULL,
                'removed_at' => NULL,
                'created_at' => '2026-02-11 14:59:44',
                'updated_at' => '2026-02-11 14:59:44',
            ),
            1 => 
            array (
                'id' => 2,
                'is_active' => 1,
                'is_primary' => 1,
                'laboratory_id' => NULL,
                'role_id' => 4,
                'user_id' => 2,
                'added_by' => 1,
                'removed_by' => NULL,
                'removed_at' => NULL,
                'created_at' => '2026-02-11 15:26:59',
                'updated_at' => '2026-02-11 15:26:59',
            ),
            2 => 
            array (
                'id' => 3,
                'is_active' => 1,
                'is_primary' => 1,
                'laboratory_id' => NULL,
                'role_id' => 2,
                'user_id' => 3,
                'added_by' => 1,
                'removed_by' => NULL,
                'removed_at' => NULL,
                'created_at' => '2026-02-11 15:33:36',
                'updated_at' => '2026-02-11 15:33:36',
            ),
            3 => 
            array (
                'id' => 4,
                'is_active' => 1,
                'is_primary' => 1,
                'laboratory_id' => 1,
                'role_id' => 3,
                'user_id' => 4,
                'added_by' => 1,
                'removed_by' => NULL,
                'removed_at' => NULL,
                'created_at' => '2026-02-11 15:36:00',
                'updated_at' => '2026-02-11 15:36:00',
            ),
            4 => 
            array (
                'id' => 5,
                'is_active' => 1,
                'is_primary' => 1,
                'laboratory_id' => 4,
                'role_id' => 3,
                'user_id' => 5,
                'added_by' => 1,
                'removed_by' => NULL,
                'removed_at' => NULL,
                'created_at' => '2026-02-11 15:37:54',
                'updated_at' => '2026-02-11 15:37:54',
            ),
            5 => 
            array (
                'id' => 6,
                'is_active' => 1,
                'is_primary' => 1,
                'laboratory_id' => 1,
                'role_id' => 5,
                'user_id' => 6,
                'added_by' => 1,
                'removed_by' => NULL,
                'removed_at' => NULL,
                'created_at' => '2026-02-11 15:41:38',
                'updated_at' => '2026-02-11 15:41:38',
            ),
            6 => 
            array (
                'id' => 7,
                'is_active' => 1,
                'is_primary' => 1,
                'laboratory_id' => 1,
                'role_id' => 5,
                'user_id' => 7,
                'added_by' => 1,
                'removed_by' => NULL,
                'removed_at' => NULL,
                'created_at' => '2026-02-11 15:44:47',
                'updated_at' => '2026-02-11 15:44:47',
            ),
            7 => 
            array (
                'id' => 8,
                'is_active' => 1,
                'is_primary' => 1,
                'laboratory_id' => 1,
                'role_id' => 5,
                'user_id' => 8,
                'added_by' => 1,
                'removed_by' => NULL,
                'removed_at' => NULL,
                'created_at' => '2026-02-11 15:46:39',
                'updated_at' => '2026-02-11 15:46:39',
            ),
            8 => 
            array (
                'id' => 9,
                'is_active' => 1,
                'is_primary' => 1,
                'laboratory_id' => 2,
                'role_id' => 5,
                'user_id' => 9,
                'added_by' => 1,
                'removed_by' => NULL,
                'removed_at' => NULL,
                'created_at' => '2026-02-11 15:48:09',
                'updated_at' => '2026-02-11 15:48:09',
            ),
            9 => 
            array (
                'id' => 10,
                'is_active' => 1,
                'is_primary' => 1,
                'laboratory_id' => 2,
                'role_id' => 5,
                'user_id' => 10,
                'added_by' => 1,
                'removed_by' => NULL,
                'removed_at' => NULL,
                'created_at' => '2026-02-11 15:49:01',
                'updated_at' => '2026-02-11 15:49:01',
            ),
            10 => 
            array (
                'id' => 11,
                'is_active' => 1,
                'is_primary' => 1,
                'laboratory_id' => 2,
                'role_id' => 5,
                'user_id' => 11,
                'added_by' => 1,
                'removed_by' => NULL,
                'removed_at' => NULL,
                'created_at' => '2026-02-11 15:49:53',
                'updated_at' => '2026-02-11 15:49:53',
            ),
            11 => 
            array (
                'id' => 12,
                'is_active' => 1,
                'is_primary' => 1,
                'laboratory_id' => 3,
                'role_id' => 10,
                'user_id' => 12,
                'added_by' => 1,
                'removed_by' => NULL,
                'removed_at' => NULL,
                'created_at' => '2026-02-11 16:23:47',
                'updated_at' => '2026-02-11 16:23:47',
            ),
            12 => 
            array (
                'id' => 13,
                'is_active' => 1,
                'is_primary' => 1,
                'laboratory_id' => 3,
                'role_id' => 10,
                'user_id' => 13,
                'added_by' => 1,
                'removed_by' => NULL,
                'removed_at' => NULL,
                'created_at' => '2026-02-11 16:25:20',
                'updated_at' => '2026-02-11 16:25:20',
            ),
            13 => 
            array (
                'id' => 14,
                'is_active' => 1,
                'is_primary' => 1,
                'laboratory_id' => 3,
                'role_id' => 10,
                'user_id' => 14,
                'added_by' => 1,
                'removed_by' => NULL,
                'removed_at' => NULL,
                'created_at' => '2026-02-11 16:26:19',
                'updated_at' => '2026-02-11 16:26:19',
            ),
            14 => 
            array (
                'id' => 15,
                'is_active' => 1,
                'is_primary' => 1,
                'laboratory_id' => 2,
                'role_id' => 9,
                'user_id' => 15,
                'added_by' => 1,
                'removed_by' => NULL,
                'removed_at' => NULL,
                'created_at' => '2026-02-11 16:29:09',
                'updated_at' => '2026-02-11 16:29:09',
            ),
            15 => 
            array (
                'id' => 16,
                'is_active' => 1,
                'is_primary' => 1,
                'laboratory_id' => 1,
                'role_id' => 9,
                'user_id' => 16,
                'added_by' => 1,
                'removed_by' => NULL,
                'removed_at' => NULL,
                'created_at' => '2026-02-11 16:30:34',
                'updated_at' => '2026-02-11 16:30:34',
            ),
            16 => 
            array (
                'id' => 17,
                'is_active' => 1,
                'is_primary' => 1,
                'laboratory_id' => NULL,
                'role_id' => 8,
                'user_id' => 17,
                'added_by' => 1,
                'removed_by' => NULL,
                'removed_at' => NULL,
                'created_at' => '2026-02-11 16:31:39',
                'updated_at' => '2026-02-11 16:31:39',
            ),
            17 => 
            array (
                'id' => 18,
                'is_active' => 1,
                'is_primary' => 1,
                'laboratory_id' => 3,
                'role_id' => 9,
                'user_id' => 18,
                'added_by' => 1,
                'removed_by' => NULL,
                'removed_at' => NULL,
                'created_at' => '2026-02-11 16:33:43',
                'updated_at' => '2026-02-11 16:33:43',
            ),
            18 => 
            array (
                'id' => 19,
                'is_active' => 1,
                'is_primary' => 1,
                'laboratory_id' => NULL,
                'role_id' => 7,
                'user_id' => 19,
                'added_by' => 1,
                'removed_by' => NULL,
                'removed_at' => NULL,
                'created_at' => '2026-02-11 16:54:07',
                'updated_at' => '2026-02-11 16:54:07',
            ),
            19 => 
            array (
                'id' => 20,
                'is_active' => 1,
                'is_primary' => 1,
                'laboratory_id' => NULL,
                'role_id' => 6,
                'user_id' => 20,
                'added_by' => 1,
                'removed_by' => NULL,
                'removed_at' => NULL,
                'created_at' => '2026-02-11 16:54:53',
                'updated_at' => '2026-02-11 16:54:53',
            ),
            20 => 
            array (
                'id' => 21,
                'is_active' => 1,
                'is_primary' => 1,
                'laboratory_id' => NULL,
                'role_id' => 7,
                'user_id' => 21,
                'added_by' => 1,
                'removed_by' => NULL,
                'removed_at' => NULL,
                'created_at' => '2026-02-11 16:59:22',
                'updated_at' => '2026-02-11 16:59:22',
            ),
            21 => 
            array (
                'id' => 22,
                'is_active' => 1,
                'is_primary' => 1,
                'laboratory_id' => NULL,
                'role_id' => 6,
                'user_id' => 22,
                'added_by' => 1,
                'removed_by' => NULL,
                'removed_at' => NULL,
                'created_at' => '2026-02-11 17:00:33',
                'updated_at' => '2026-02-11 17:00:33',
            ),
            22 => 
            array (
                'id' => 23,
                'is_active' => 1,
                'is_primary' => 1,
                'laboratory_id' => 3,
                'role_id' => 3,
                'user_id' => 3,
                'added_by' => 1,
                'removed_by' => NULL,
                'removed_at' => NULL,
                'created_at' => '2026-02-16 09:48:12',
                'updated_at' => '2026-02-16 09:48:12',
            ),
            23 => 
            array (
                'id' => 24,
                'is_active' => 1,
                'is_primary' => 1,
                'laboratory_id' => 2,
                'role_id' => 3,
                'user_id' => 4,
                'added_by' => 1,
                'removed_by' => NULL,
                'removed_at' => NULL,
                'created_at' => '2026-02-16 10:29:38',
                'updated_at' => '2026-02-16 10:29:38',
            ),
        ));
        
        
    }
}