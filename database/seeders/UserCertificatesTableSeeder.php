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
                'file' => 'lims/certificates/anastacio.larra.p12',
                'password' => 'eyJpdiI6ImtYWFdvOVE0bGJnQWcrdmZXRXA4c0E9PSIsInZhbHVlIjoiM0EzcS9MNUd6dS91b0R6TnA4TnNMZz09IiwibWFjIjoiMDM2ODRmNzIwZDdjOTk2NDQ3YjYxY2FmY2E3M2FhOGQyMDVkYmQ2YzY3MGQwYjY1OTJkOTI1NWQ1YzdiN2U0YiIsInRhZyI6IiJ9',
                'signature' => 'lims/signatures/anastacio.larra.png',
                'is_checked' => 1,
                'expires_at' => NULL,
                'user_id' => 2,
                'created_at' => '2026-03-11 01:29:02',
                'updated_at' => '2026-08-26 16:48:11',
            ),
            1 => 
            array (
                'id' => 2,
                'file' => 'lims/certificates/suganobshadam.p12',
                'password' => 'eyJpdiI6IkhyMmFRUHBSOGMrZWRoYmNFS3JRR3c9PSIsInZhbHVlIjoiMWhVN2tCZXpLcU9JaVlVK1FsMjRuZz09IiwibWFjIjoiYWMwY2ZiNDE0ZWZiMWFkYTkyZjFhNDhkOGYyMGE3Yjk2ZjIzYTRhZTQyYjM4MDJlZTIwMmM2OGE3NGY4MmEzOSIsInRhZyI6IiJ9',
                'signature' => 'lims/signatures/suganobshadam.png',
                'is_checked' => 0,
                'expires_at' => NULL,
                'user_id' => 5,
                'created_at' => '2026-03-11 01:31:48',
                'updated_at' => '2026-08-06 16:26:34',
            ),
            2 => 
            array (
                'id' => 3,
                'file' => 'lims/certificates/schezzojuly.p12',
                'password' => 'M3trology',
                'signature' => 'lims/signatures/schezzojuly.png',
                'is_checked' => 0,
                'expires_at' => NULL,
                'user_id' => 3,
                'created_at' => '2026-04-23 16:31:03',
                'updated_at' => '2026-06-18 00:12:22',
            ),
            3 => 
            array (
                'id' => 4,
                'file' => 'lims/certificates/emapendergat95.p12',
                'password' => 'EAPBalucanag0705',
                'signature' => 'lims/signatures/emapendergat95.png',
                'is_checked' => 0,
                'expires_at' => NULL,
                'user_id' => 6,
                'created_at' => '2026-07-29 21:57:28',
                'updated_at' => '2026-07-29 21:57:45',
            ),
            4 => 
            array (
                'id' => 5,
                'file' => 'lims/certificates/rubenjr1005.p12',
                'password' => 'eyJpdiI6ImVrRUJ3dGNwc2I4M1NBMXBURVZtQlE9PSIsInZhbHVlIjoiVW1XYXQ1NW13YUVuMmRpZmxYK3QwQT09IiwibWFjIjoiZDFjOTkwMzUyM2RlYTJmNmYyZjg3Yjk3ZWZlM2Q3YmVhMjA5N2UzZTc1NTcxYjdkODJmNDMxNjVhYTVlNGQ3OSIsInRhZyI6IiJ9',
                'signature' => 'lims/signatures/rubenjr1005.png',
                'is_checked' => 0,
                'expires_at' => NULL,
                'user_id' => 8,
                'created_at' => '2026-07-29 21:57:28',
                'updated_at' => '2026-08-06 17:28:15',
            ),
            5 => 
            array (
                'id' => 6,
                'file' => 'lims/certificates/oniangelongomez.p12',
                'password' => 'eyJpdiI6InppaXY3OU5hYjh2ZnJ4WnFldG4vbUE9PSIsInZhbHVlIjoia1hVbGxrUWZTYVR4eUtUK201clRuZz09IiwibWFjIjoiOWNjOWNjZTg2NmQ2YjE5NDFlYmFjZjExYWMyZDkxNmU1YWI2ZmIyMTNmYzJjMDhjZWFkNjYyNTUzMDI0ZDlhMCIsInRhZyI6IiJ9',
                'signature' => 'lims/signatures/oniangelongomez.png',
                'is_checked' => 0,
                'expires_at' => NULL,
                'user_id' => 10,
                'created_at' => '2026-07-29 21:57:28',
                'updated_at' => '2026-08-06 23:04:42',
            ),
            6 => 
            array (
                'id' => 7,
                'file' => 'lims/certificates/janice.ong.p12',
                'password' => 'eyJpdiI6IjdrOFpKQ2h3Y1h1a2tJb1hFY2VwQ1E9PSIsInZhbHVlIjoiRlpYYXZlbGRJdnpuR3lCeE8yVUhxUT09IiwibWFjIjoiZWQ3OWMxYzI2Y2JjOGQ1ZjM3ZTMxMjE0MzkwNWRiZGZjYmY5NzI2NzcxNmZmNzRlMjJiOWM5NWZlZWZiMTE1NyIsInRhZyI6IiJ9',
                'signature' => 'lims/signatures/janice.ong.png',
                'is_checked' => 0,
                'expires_at' => NULL,
                'user_id' => 4,
                'created_at' => '2026-07-29 21:57:28',
                'updated_at' => '2026-08-11 18:09:08',
            ),
            7 => 
            array (
                'id' => 8,
                'file' => 'lims/certificates/hermajoycea.p12',
                'password' => 'eyJpdiI6IldIWFVyTTdRQ0RvMndXZFJvMytpVVE9PSIsInZhbHVlIjoiemNNSlMzREJINFdwNzdBSytkR1ZNUT09IiwibWFjIjoiZTkxN2U4MjEzMTEyZmU4NjQ1YmE4MmE4ZGZiZjAyOGYyNjZhYTZmNTM2OTM5ZmI2YjBlZTU5NmMzNGU2YmQ2NSIsInRhZyI6IiJ9',
                'signature' => 'lims/signatures/hermajoycea.png',
                'is_checked' => 1,
                'expires_at' => NULL,
                'user_id' => 26,
                'created_at' => '2026-07-29 21:57:28',
                'updated_at' => '2026-08-26 18:39:49',
            ),
            8 => 
            array (
                'id' => 9,
                'file' => 'lims/certificates/josefkyle12345.p12',
                'password' => 'eyJpdiI6Im5OdEZRdGRxWFgwSzFxNGRWOXZhOVE9PSIsInZhbHVlIjoieEFRRUJXMjVxWGhSTTFGSU8rSVdzZz09IiwibWFjIjoiZjJhODJlNWQ2Nzk5MjBmYmVmZjE4Y2UyYzMwM2NjYWQwM2I3ODIwODFlNzA3MjI3ZWE4NTYxMjE3MTE5MWJhNSIsInRhZyI6IiJ9',
                'signature' => 'lims/signatures/josefkyle12345.png',
                'is_checked' => 0,
                'expires_at' => NULL,
                'user_id' => 27,
                'created_at' => '2026-07-29 21:57:28',
                'updated_at' => '2026-08-25 02:40:05',
            ),
            9 => 
            array (
                'id' => 10,
                'file' => 'lims/certificates/ton2x.jvr.p12',
                'password' => 'eyJpdiI6IndEemNtZ1BuaU9mL3dQaWsrVGh0enc9PSIsInZhbHVlIjoiVExGNmhpeVJ1blhoY3BEcWtxQmU0UT09IiwibWFjIjoiYTJhNWFlYzRjZDlmNzM4NzRmNDNlM2JlMDRlYzM2Y2Y0M2Y0NGI2MGVhOWRkZjk5OTI5MGFiZDIyMzBmNmJjMiIsInRhZyI6IiJ9',
                'signature' => 'lims/signatures/ton2x.jvr.png',
                'is_checked' => 0,
                'expires_at' => NULL,
                'user_id' => 14,
                'created_at' => '2026-07-29 21:57:28',
                'updated_at' => '2026-08-24 22:05:32',
            ),
            10 => 
            array (
                'id' => 11,
                'file' => 'lims/certificates/kevinkarlramosramiso.p12',
                'password' => 'eyJpdiI6Ino5Q2szek5EWXhIR1QzVWJVNWdEK2c9PSIsInZhbHVlIjoiM3JsSm5nVkN1d2h0d0dTN05BQ1d6UT09IiwibWFjIjoiMzU3YTU2MmQ0ZjhhY2RlNjAzOTJiMGExN2ZiY2ExYzJjMzRkYmMxNWYyMjdkYTJkYWFlZDRiMDJlNWI3YzI3NyIsInRhZyI6IiJ9',
                'signature' => 'lims/signatures/kevinkarlramosramiso.png',
                'is_checked' => 1,
                'expires_at' => NULL,
                'user_id' => 12,
                'created_at' => '2026-09-02 16:39:22',
                'updated_at' => '2026-09-02 16:49:32',
            ),
        ));


    }
}
