<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserCertificatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_certificates')->delete();
        
        \DB::table('user_certificates')->insert(array (
            0 => 
            array (
                'id' => 1,
                'file' => 'lims/certificates/emapendergat95.p12',
                'password' => '12345china',
                'signature' => 'lims/signatures/emapendergat95.png',
                'expires_at' => NULL,
                'user_id' => 6,
                'created_at' => '2026-03-10 17:29:02',
                'updated_at' => '2026-03-10 17:35:54',
            ),
            1 => 
            array (
                'id' => 2,
                'file' => 'lims/certificates/suganobshadam.p12',
                'password' => 'rstlD057rubber',
                'signature' => 'lims/signatures/suganobshadam.png',
                'expires_at' => NULL,
                'user_id' => 5,
                'created_at' => '2026-03-10 17:31:48',
                'updated_at' => '2026-03-10 17:36:07',
            ),
            2 => 
            array (
                'id' => 3,
                'file' => 'lims/certificates/schezzojuly.p12',
                'password' => 'M3trology',
                'signature' => NULL,
                'expires_at' => NULL,
                'user_id' => 3,
                'created_at' => '2026-04-23 08:31:03',
                'updated_at' => '2026-04-23 08:31:03',
            ),
        ));
        
        
    }
}