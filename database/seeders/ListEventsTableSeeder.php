<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListEventsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('list_events')->delete();
        
        \DB::table('list_events')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'In-house Calibration',
                'type' => 'Calibration Services',
                'color' => 'text-white',
                'bg' => 'bg-primary',
                'icon' => 'n/a',
                'fields' => '{"tsr": false, "info": true, "title": false, "venue": false, "samples": false, "conforme": true, "customer": true, "employees": true, "quotation": false}',
                'is_active' => 1,
                'created_at' => '2026-04-03 10:29:15',
                'updated_at' => '2026-04-03 10:29:15',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'On-site Calibration',
                'type' => 'Calibration Services',
                'color' => 'text-white',
                'bg' => 'bg-danger',
                'icon' => 'n/a',
                'fields' => '{"tsr": true, "info": true, "title": false, "venue": false, "samples": false, "conforme": false, "customer": true, "employees": true, "quotation": false}',
                'is_active' => 1,
                'created_at' => '2026-04-03 10:29:15',
                'updated_at' => '2026-04-03 10:29:15',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'BOD Schedule',
                'type' => 'Testing Services',
                'color' => 'text-white',
                'bg' => 'bg-info',
                'icon' => 'n/a',
                'fields' => '{"tsr": false, "info": true, "title": false, "venue": false, "samples": true, "conforme": true, "customer": true, "employees": true, "quotation": true}',
                'is_active' => 1,
                'created_at' => '2026-04-03 10:29:15',
                'updated_at' => '2026-04-03 10:29:15',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Microbiological',
                'type' => 'Testing Services',
                'color' => 'text-white',
                'bg' => 'bg-info',
                'icon' => 'n/a',
                'fields' => '{"tsr": false, "info": true, "title": false, "venue": false, "samples": false, "conforme": false, "customer": true, "employees": true, "quotation": true}',
                'is_active' => 1,
                'created_at' => '2026-04-03 10:29:15',
                'updated_at' => '2026-04-03 10:29:15',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Official Travel',
                'type' => 'Official Business',
                'color' => 'text-success',
                'bg' => 'bg-success-subtle',
                'icon' => 'n/a',
                'fields' => '{"tsr": false, "info": true, "title": true, "venue": true, "samples": false, "conforme": false, "customer": false, "employees": true, "quotation": false}',
                'is_active' => 1,
                'created_at' => '2026-04-03 10:29:15',
                'updated_at' => '2026-04-03 10:29:15',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Meeting',
                'type' => 'Official Business',
                'color' => 'text-info',
                'bg' => 'bg-info-subtle',
                'icon' => 'n/a',
                'fields' => '{"tsr": false, "info": true, "title": true, "venue": true, "samples": false, "conforme": false, "customer": false, "employees": true, "quotation": false}',
                'is_active' => 1,
                'created_at' => '2026-04-03 10:29:15',
                'updated_at' => '2026-04-03 10:29:15',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Audit',
                'type' => 'Official Business',
                'color' => 'text-warning',
                'bg' => 'bg-warning-subtle',
                'icon' => 'n/a',
                'fields' => '{"tsr": false, "info": true, "title": true, "venue": true, "samples": false, "conforme": false, "customer": false, "employees": true, "quotation": false}',
                'is_active' => 1,
                'created_at' => '2026-04-03 10:29:15',
                'updated_at' => '2026-04-03 10:29:15',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Review',
                'type' => 'Official Business',
                'color' => 'text-primary',
                'bg' => 'bg-primary-subtle',
                'icon' => 'n/a',
                'fields' => '{"tsr": false, "info": true, "title": true, "venue": true, "samples": false, "conforme": false, "customer": false, "employees": true, "quotation": false}',
                'is_active' => 1,
                'created_at' => '2026-04-03 10:29:15',
                'updated_at' => '2026-04-03 10:29:15',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Leave',
                'type' => 'Personal Business',
                'color' => 'text-danger',
                'bg' => 'bg-danger-subtle',
                'icon' => 'n/a',
                'fields' => '{"tsr": false, "info": true, "title": false, "venue": false, "samples": false, "conforme": false, "customer": false, "employees": false, "quotation": false}',
                'is_active' => 1,
                'created_at' => '2026-04-03 10:29:15',
                'updated_at' => '2026-04-03 10:29:15',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Holiday',
                'type' => 'Official ',
                'color' => 'text-white',
                'bg' => 'bg-dark',
                'icon' => 'n/a',
                'fields' => '{"tsr": false, "info": false, "title": true, "venue": false, "samples": false, "conforme": false, "customer": false, "employees": false, "quotation": false}',
                'is_active' => 1,
                'created_at' => '2026-04-03 10:29:15',
                'updated_at' => '2026-04-03 10:29:15',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'GAD Activity',
                'type' => 'Official ',
                'color' => 'text-purple',
                'bg' => 'bg-primary-subtle',
                'icon' => 'n/a',
                'fields' => '{"tsr": false, "info": true, "title": true, "venue": false, "samples": false, "conforme": false, "customer": false, "employees": false, "quotation": false}',
                'is_active' => 1,
                'created_at' => '2026-04-03 10:29:15',
                'updated_at' => '2026-04-03 10:29:15',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Others',
                'type' => 'Official ',
                'color' => 'text-warning',
                'bg' => 'bg-warning-subtle',
                'icon' => 'n/a',
                'fields' => '{"tsr": false, "info": true, "title": true, "venue": false, "samples": false, "conforme": false, "customer": false, "employees": false, "quotation": false}',
                'is_active' => 1,
                'created_at' => '2026-04-03 10:29:15',
                'updated_at' => '2026-04-03 10:29:15',
            ),
        ));
        
        
    }
}