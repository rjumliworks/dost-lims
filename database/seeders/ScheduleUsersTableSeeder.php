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
        
        
        
    }
}