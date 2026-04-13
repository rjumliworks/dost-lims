<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ScheduleUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('schedule_users')->delete();
        
        \DB::table('schedule_users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 2,
                'schedule_id' => 1,
                'created_at' => '2026-04-11 11:00:36',
                'updated_at' => '2026-04-11 11:00:36',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 2,
                'schedule_id' => 2,
                'created_at' => '2026-04-11 11:00:53',
                'updated_at' => '2026-04-11 11:00:53',
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 2,
                'schedule_id' => 3,
                'created_at' => '2026-04-11 11:01:07',
                'updated_at' => '2026-04-11 11:01:07',
            ),
            3 => 
            array (
                'id' => 4,
                'user_id' => 2,
                'schedule_id' => 4,
                'created_at' => '2026-04-11 11:01:27',
                'updated_at' => '2026-04-11 11:01:27',
            ),
            4 => 
            array (
                'id' => 5,
                'user_id' => 2,
                'schedule_id' => 5,
                'created_at' => '2026-04-11 11:01:49',
                'updated_at' => '2026-04-11 11:01:49',
            ),
            5 => 
            array (
                'id' => 6,
                'user_id' => 2,
                'schedule_id' => 6,
                'created_at' => '2026-04-11 11:02:14',
                'updated_at' => '2026-04-11 11:02:14',
            ),
            6 => 
            array (
                'id' => 7,
                'user_id' => 2,
                'schedule_id' => 7,
                'created_at' => '2026-04-11 11:02:38',
                'updated_at' => '2026-04-11 11:02:38',
            ),
            7 => 
            array (
                'id' => 8,
                'user_id' => 2,
                'schedule_id' => 8,
                'created_at' => '2026-04-11 11:03:05',
                'updated_at' => '2026-04-11 11:03:05',
            ),
            8 => 
            array (
                'id' => 9,
                'user_id' => 2,
                'schedule_id' => 9,
                'created_at' => '2026-04-11 11:03:32',
                'updated_at' => '2026-04-11 11:03:32',
            ),
            9 => 
            array (
                'id' => 10,
                'user_id' => 2,
                'schedule_id' => 10,
                'created_at' => '2026-04-11 11:03:59',
                'updated_at' => '2026-04-11 11:03:59',
            ),
            10 => 
            array (
                'id' => 11,
                'user_id' => 2,
                'schedule_id' => 11,
                'created_at' => '2026-04-11 11:04:24',
                'updated_at' => '2026-04-11 11:04:24',
            ),
            11 => 
            array (
                'id' => 12,
                'user_id' => 2,
                'schedule_id' => 12,
                'created_at' => '2026-04-11 11:05:09',
                'updated_at' => '2026-04-11 11:05:09',
            ),
            12 => 
            array (
                'id' => 13,
                'user_id' => 2,
                'schedule_id' => 13,
                'created_at' => '2026-04-11 11:05:28',
                'updated_at' => '2026-04-11 11:05:28',
            ),
            13 => 
            array (
                'id' => 14,
                'user_id' => 2,
                'schedule_id' => 14,
                'created_at' => '2026-04-11 11:05:47',
                'updated_at' => '2026-04-11 11:05:47',
            ),
            14 => 
            array (
                'id' => 15,
                'user_id' => 2,
                'schedule_id' => 15,
                'created_at' => '2026-04-11 11:06:06',
                'updated_at' => '2026-04-11 11:06:06',
            ),
            15 => 
            array (
                'id' => 16,
                'user_id' => 2,
                'schedule_id' => 16,
                'created_at' => '2026-04-11 11:06:29',
                'updated_at' => '2026-04-11 11:06:29',
            ),
            16 => 
            array (
                'id' => 18,
                'user_id' => 14,
                'schedule_id' => 17,
                'created_at' => '2026-04-13 09:53:26',
                'updated_at' => '2026-04-13 09:53:26',
            ),
            17 => 
            array (
                'id' => 19,
                'user_id' => 13,
                'schedule_id' => 17,
                'created_at' => '2026-04-13 09:53:26',
                'updated_at' => '2026-04-13 09:53:26',
            ),
            18 => 
            array (
                'id' => 20,
                'user_id' => 3,
                'schedule_id' => 18,
                'created_at' => '2026-04-13 09:58:23',
                'updated_at' => '2026-04-13 09:58:23',
            ),
        ));
        
        
    }
}