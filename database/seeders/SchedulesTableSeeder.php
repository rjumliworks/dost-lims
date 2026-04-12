<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SchedulesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('schedules')->delete();
        
        \DB::table('schedules')->insert(array (
            0 => 
            array (
                'id' => 1,
                'start' => '2026-04-02 08:00:00',
                'end' => '2026-04-02 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-04-11 11:00:36',
                'updated_at' => '2026-04-11 11:00:36',
            ),
            1 => 
            array (
                'id' => 2,
                'start' => '2026-04-03 08:00:00',
                'end' => '2026-04-03 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-04-11 11:00:53',
                'updated_at' => '2026-04-11 11:00:53',
            ),
            2 => 
            array (
                'id' => 3,
                'start' => '2026-04-04 08:00:00',
                'end' => '2026-04-04 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-04-11 11:01:07',
                'updated_at' => '2026-04-11 11:01:07',
            ),
            3 => 
            array (
                'id' => 4,
                'start' => '2026-04-09 08:00:00',
                'end' => '2026-04-09 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-04-11 11:01:27',
                'updated_at' => '2026-04-11 11:01:27',
            ),
            4 => 
            array (
                'id' => 5,
                'start' => '2026-05-01 08:00:00',
                'end' => '2026-05-01 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-04-11 11:01:49',
                'updated_at' => '2026-04-11 11:01:49',
            ),
            5 => 
            array (
                'id' => 6,
                'start' => '2026-06-12 08:00:00',
                'end' => '2026-06-12 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-04-11 11:02:14',
                'updated_at' => '2026-04-11 11:02:14',
            ),
            6 => 
            array (
                'id' => 7,
                'start' => '2026-08-12 08:00:00',
                'end' => '2026-08-12 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-04-11 11:02:38',
                'updated_at' => '2026-04-11 11:02:38',
            ),
            7 => 
            array (
                'id' => 8,
                'start' => '2026-08-31 08:00:00',
                'end' => '2026-08-31 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-04-11 11:03:05',
                'updated_at' => '2026-04-11 11:03:05',
            ),
            8 => 
            array (
                'id' => 9,
                'start' => '2026-10-12 08:00:00',
                'end' => '2026-10-12 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-04-11 11:03:32',
                'updated_at' => '2026-04-11 11:03:32',
            ),
            9 => 
            array (
                'id' => 10,
                'start' => '2026-11-01 08:00:00',
                'end' => '2026-11-01 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-04-11 11:03:59',
                'updated_at' => '2026-04-11 11:03:59',
            ),
            10 => 
            array (
                'id' => 11,
                'start' => '2026-11-02 08:00:00',
                'end' => '2026-11-02 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-04-11 11:04:24',
                'updated_at' => '2026-04-11 11:04:24',
            ),
            11 => 
            array (
                'id' => 12,
                'start' => '2026-12-08 08:00:00',
                'end' => '2026-12-08 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-04-11 11:05:09',
                'updated_at' => '2026-04-11 11:05:09',
            ),
            12 => 
            array (
                'id' => 13,
                'start' => '2026-12-24 08:00:00',
                'end' => '2026-12-24 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-04-11 11:05:28',
                'updated_at' => '2026-04-11 11:05:28',
            ),
            13 => 
            array (
                'id' => 14,
                'start' => '2026-12-25 08:00:00',
                'end' => '2026-12-25 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-04-11 11:05:47',
                'updated_at' => '2026-04-11 11:05:47',
            ),
            14 => 
            array (
                'id' => 15,
                'start' => '2026-12-30 08:00:00',
                'end' => '2026-12-30 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-04-11 11:06:06',
                'updated_at' => '2026-04-11 11:06:06',
            ),
            15 => 
            array (
                'id' => 16,
                'start' => '2026-12-31 08:00:00',
                'end' => '2026-12-31 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-04-11 11:06:29',
                'updated_at' => '2026-04-11 11:06:29',
            ),
        ));
        
        
    }
}