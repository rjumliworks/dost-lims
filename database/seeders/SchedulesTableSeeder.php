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
                'start' => '2026-06-16 08:00:00',
                'end' => '2026-06-16 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-06-10 21:15:50',
                'updated_at' => '2026-06-10 21:15:50',
            ),
            1 => 
            array (
                'id' => 2,
                'start' => '2026-06-12 08:00:00',
                'end' => '2026-06-12 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-06-10 21:16:22',
                'updated_at' => '2026-06-10 21:16:22',
            ),
            2 => 
            array (
                'id' => 3,
                'start' => '2026-08-12 08:00:00',
                'end' => '2026-08-12 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-06-10 21:17:12',
                'updated_at' => '2026-06-10 21:17:12',
            ),
            3 => 
            array (
                'id' => 4,
                'start' => '2026-08-31 08:00:00',
                'end' => '2026-08-31 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-06-10 21:17:35',
                'updated_at' => '2026-06-10 21:17:35',
            ),
            4 => 
            array (
                'id' => 5,
                'start' => '2026-10-12 08:00:00',
                'end' => '2026-10-12 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-06-10 21:18:06',
                'updated_at' => '2026-06-10 21:18:06',
            ),
            5 => 
            array (
                'id' => 6,
                'start' => '2026-11-01 08:00:00',
                'end' => '2026-11-01 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-06-10 21:18:42',
                'updated_at' => '2026-06-10 21:18:42',
            ),
            6 => 
            array (
                'id' => 7,
                'start' => '2026-11-02 08:00:00',
                'end' => '2026-11-02 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-06-10 21:19:02',
                'updated_at' => '2026-06-10 21:19:02',
            ),
            7 => 
            array (
                'id' => 8,
                'start' => '2026-12-08 08:00:00',
                'end' => '2026-12-08 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-06-10 21:19:43',
                'updated_at' => '2026-06-10 21:19:43',
            ),
            8 => 
            array (
                'id' => 9,
                'start' => '2026-12-24 08:00:00',
                'end' => '2026-12-24 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-06-10 21:20:08',
                'updated_at' => '2026-06-10 21:20:08',
            ),
            9 => 
            array (
                'id' => 10,
                'start' => '2026-12-25 08:00:00',
                'end' => '2026-12-25 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-06-10 21:20:28',
                'updated_at' => '2026-06-10 21:20:28',
            ),
            10 => 
            array (
                'id' => 11,
                'start' => '2026-12-30 08:00:00',
                'end' => '2026-12-30 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-06-10 21:20:48',
                'updated_at' => '2026-06-10 21:20:48',
            ),
            11 => 
            array (
                'id' => 12,
                'start' => '2026-12-31 08:00:00',
                'end' => '2026-12-31 17:00:00',
                'is_forall' => 0,
                'is_allday' => 0,
                'event_id' => 10,
                'user_id' => 2,
                'agency_id' => 14,
                'created_at' => '2026-06-10 21:21:06',
                'updated_at' => '2026-06-10 21:21:06',
            ),
        ));
        
        
    }
}