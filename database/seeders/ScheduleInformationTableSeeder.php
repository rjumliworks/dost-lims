<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ScheduleInformationTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('schedule_information')->delete();
        
        \DB::table('schedule_information')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Maundy Thursday',
                'information' => NULL,
                'venue' => NULL,
                'samples' => NULL,
                'quotation_id' => NULL,
                'tsr_id' => NULL,
                'customer_id' => NULL,
                'conforme_id' => NULL,
                'schedule_id' => 1,
                'created_at' => '2026-04-11 11:00:36',
                'updated_at' => '2026-04-11 11:00:36',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Good Friday',
                'information' => NULL,
                'venue' => NULL,
                'samples' => NULL,
                'quotation_id' => NULL,
                'tsr_id' => NULL,
                'customer_id' => NULL,
                'conforme_id' => NULL,
                'schedule_id' => 2,
                'created_at' => '2026-04-11 11:00:53',
                'updated_at' => '2026-04-11 11:00:53',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Black Saturday',
                'information' => NULL,
                'venue' => NULL,
                'samples' => NULL,
                'quotation_id' => NULL,
                'tsr_id' => NULL,
                'customer_id' => NULL,
                'conforme_id' => NULL,
                'schedule_id' => 3,
                'created_at' => '2026-04-11 11:01:07',
                'updated_at' => '2026-04-11 11:01:07',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'Araw ng Kagitingan',
                'information' => NULL,
                'venue' => NULL,
                'samples' => NULL,
                'quotation_id' => NULL,
                'tsr_id' => NULL,
                'customer_id' => NULL,
                'conforme_id' => NULL,
                'schedule_id' => 4,
                'created_at' => '2026-04-11 11:01:27',
                'updated_at' => '2026-04-11 11:01:27',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'Labor Day',
                'information' => NULL,
                'venue' => NULL,
                'samples' => NULL,
                'quotation_id' => NULL,
                'tsr_id' => NULL,
                'customer_id' => NULL,
                'conforme_id' => NULL,
                'schedule_id' => 5,
                'created_at' => '2026-04-11 11:01:49',
                'updated_at' => '2026-04-11 11:01:49',
            ),
            5 => 
            array (
                'id' => 6,
                'title' => 'Independence Day',
                'information' => NULL,
                'venue' => NULL,
                'samples' => NULL,
                'quotation_id' => NULL,
                'tsr_id' => NULL,
                'customer_id' => NULL,
                'conforme_id' => NULL,
                'schedule_id' => 6,
                'created_at' => '2026-04-11 11:02:14',
                'updated_at' => '2026-04-11 11:02:14',
            ),
            6 => 
            array (
                'id' => 7,
                'title' => 'Ninoy Aquinao Day',
                'information' => NULL,
                'venue' => NULL,
                'samples' => NULL,
                'quotation_id' => NULL,
                'tsr_id' => NULL,
                'customer_id' => NULL,
                'conforme_id' => NULL,
                'schedule_id' => 7,
                'created_at' => '2026-04-11 11:02:38',
                'updated_at' => '2026-04-11 11:02:38',
            ),
            7 => 
            array (
                'id' => 8,
                'title' => 'National Heroes Day',
                'information' => NULL,
                'venue' => NULL,
                'samples' => NULL,
                'quotation_id' => NULL,
                'tsr_id' => NULL,
                'customer_id' => NULL,
                'conforme_id' => NULL,
                'schedule_id' => 8,
                'created_at' => '2026-04-11 11:03:05',
                'updated_at' => '2026-04-11 11:03:05',
            ),
            8 => 
            array (
                'id' => 9,
                'title' => 'Fiest Pilar',
                'information' => NULL,
                'venue' => NULL,
                'samples' => NULL,
                'quotation_id' => NULL,
                'tsr_id' => NULL,
                'customer_id' => NULL,
                'conforme_id' => NULL,
                'schedule_id' => 9,
                'created_at' => '2026-04-11 11:03:32',
                'updated_at' => '2026-04-11 11:03:32',
            ),
            9 => 
            array (
                'id' => 10,
                'title' => 'All Saint\'s Day',
                'information' => NULL,
                'venue' => NULL,
                'samples' => NULL,
                'quotation_id' => NULL,
                'tsr_id' => NULL,
                'customer_id' => NULL,
                'conforme_id' => NULL,
                'schedule_id' => 10,
                'created_at' => '2026-04-11 11:03:59',
                'updated_at' => '2026-04-11 11:03:59',
            ),
            10 => 
            array (
                'id' => 11,
                'title' => 'All Souls\' Day',
                'information' => NULL,
                'venue' => NULL,
                'samples' => NULL,
                'quotation_id' => NULL,
                'tsr_id' => NULL,
                'customer_id' => NULL,
                'conforme_id' => NULL,
                'schedule_id' => 11,
                'created_at' => '2026-04-11 11:04:24',
                'updated_at' => '2026-04-11 11:04:24',
            ),
            11 => 
            array (
                'id' => 12,
                'title' => 'Feast of the Immaculate Conception of Mary',
                'information' => NULL,
                'venue' => NULL,
                'samples' => NULL,
                'quotation_id' => NULL,
                'tsr_id' => NULL,
                'customer_id' => NULL,
                'conforme_id' => NULL,
                'schedule_id' => 12,
                'created_at' => '2026-04-11 11:05:09',
                'updated_at' => '2026-04-11 11:05:09',
            ),
            12 => 
            array (
                'id' => 13,
                'title' => 'Christmas Eve',
                'information' => NULL,
                'venue' => NULL,
                'samples' => NULL,
                'quotation_id' => NULL,
                'tsr_id' => NULL,
                'customer_id' => NULL,
                'conforme_id' => NULL,
                'schedule_id' => 13,
                'created_at' => '2026-04-11 11:05:28',
                'updated_at' => '2026-04-11 11:05:28',
            ),
            13 => 
            array (
                'id' => 14,
                'title' => 'Christmas Day',
                'information' => NULL,
                'venue' => NULL,
                'samples' => NULL,
                'quotation_id' => NULL,
                'tsr_id' => NULL,
                'customer_id' => NULL,
                'conforme_id' => NULL,
                'schedule_id' => 14,
                'created_at' => '2026-04-11 11:05:47',
                'updated_at' => '2026-04-11 11:05:47',
            ),
            14 => 
            array (
                'id' => 15,
                'title' => 'Rizal Day',
                'information' => NULL,
                'venue' => NULL,
                'samples' => NULL,
                'quotation_id' => NULL,
                'tsr_id' => NULL,
                'customer_id' => NULL,
                'conforme_id' => NULL,
                'schedule_id' => 15,
                'created_at' => '2026-04-11 11:06:06',
                'updated_at' => '2026-04-11 11:06:06',
            ),
            15 => 
            array (
                'id' => 16,
                'title' => 'Last Day of the Year',
                'information' => NULL,
                'venue' => NULL,
                'samples' => NULL,
                'quotation_id' => NULL,
                'tsr_id' => NULL,
                'customer_id' => NULL,
                'conforme_id' => NULL,
                'schedule_id' => 16,
                'created_at' => '2026-04-11 11:06:29',
                'updated_at' => '2026-04-11 11:06:29',
            ),
        ));
        
        
    }
}