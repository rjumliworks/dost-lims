<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AgencyConfigurationsTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('agency_configurations')->delete();
        
        \DB::table('agency_configurations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'laboratories' => '[{"name": "Chemical Laboratory", "value": 1, "tsr_count": 389, "report_count": "958", "sample_count": "989"}, {"name": "Microbiological Laboratory", "value": 2, "tsr_count": "336", "report_count": "1079", "sample_count": "927"}, {"name": "Metrology Laboratory", "value": 3, "tsr_count": "426", "report_count": "959", "sample_count": "1513"}]',
            'form' => '{"time": "4:00 PM", "email": "dost9info@gmail.com", "address": "Pettit Baracks, Zamboanga City", "contact": "(062) 991-1024", "form_name": "TECHNICAL SERVICES REQUEST"}',
                'contact' => '[]',
                'samplecode_year' => 0,
                'show_others' => 1,
                'strict_mode' => 0,
                'agency_id' => 14,
                'created_at' => '2025-05-02 10:51:51',
                'updated_at' => '2025-05-04 11:07:18',
            ),
            1 => 
            array (
                'id' => 2,
                'laboratories' => '[{"name": "Chemical Laboratory", "value": 1, "tsr_count": "0", "report_count": "0", "sample_count": "0"}, {"name": "Microbiological Laboratory", "value": 2, "tsr_count": "0", "report_count": "0", "sample_count": "0"}, {"name": "Metrology Laboratory", "value": 3, "tsr_count": "0", "report_count": "0", "sample_count": "0"}]',
            'form' => '{"time": "2:00 PM", "email": "rstl@ro6.dost.gov.ph", "address": "Magsaysay Village, La Paz, Iloilo City, Iloilo", "contact": "(033) 315-3116", "form_name": "TEST SERVICE REQUEST"}',
                'contact' => '[]',
                'samplecode_year' => 0,
                'show_others' => 1,
                'strict_mode' => 0,
                'agency_id' => 11,
                'created_at' => '2025-05-05 20:40:15',
                'updated_at' => '2025-05-05 20:41:28',
            ),
        ));

        
    }
}