<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AgencyAddressesTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('agency_addresses')->delete();
        
        \DB::table('agency_addresses')->insert(array (
            0 => 
            array (
                'id' => 1,
                'address' => 'DMMMSU-MLU Campus',
                'longitude' => '120.315835',
                'latitude' => '16.607972',
                'barangay_code' => NULL,
                'municipality_code' => '013314000',
                'province_code' => '013300000',
                'region_code' => '010000000',
                'agency_id' => 1,
                
                'created_at' => '2024-02-28 22:42:29',
                'updated_at' => '2024-02-28 22:42:29',
            ),
            1 => 
            array (
                'id' => 2,
                'address' => 'Dalan na Paccurofon, corner Matunung St., Regional Government Center',
                'longitude' => '121.752502',
                'latitude' => '17.652242',
                'barangay_code' => '021529018',
                'municipality_code' => '021529000',
                'province_code' => '021500000',
                'region_code' => '020000000',
                'agency_id' => 3,
                
                'created_at' => '2024-02-28 22:46:42',
                'updated_at' => '2024-02-28 22:46:42',
            ),
            2 => 
            array (
                'id' => 3,
                'address' => 'Regional Gov\'t. Center Park, Main Road Diosdado Macapagal Regional Center',
                'longitude' => '120.657300',
                'latitude' => '15.066352',
                'barangay_code' => NULL,
                'municipality_code' => '035416000',
                'province_code' => '035400000',
                'region_code' => '030000000',
                'agency_id' => 4,
                
                'created_at' => '2024-02-28 22:49:43',
                'updated_at' => '2024-02-28 22:49:43',
            ),
            3 => 
            array (
                'id' => 4,
                'address' => 'Jamboree Rd.',
                'longitude' => '121.223556',
                'latitude' => '14.172264',
                'barangay_code' => '043411014',
                'municipality_code' => '043411000',
                'province_code' => '043400000',
                'region_code' => '040000000',
                'agency_id' => 5,
                
                'created_at' => '2024-02-28 22:53:59',
                'updated_at' => '2024-02-28 22:53:59',
            ),
            4 => 
            array (
                'id' => 5,
                'address' => 'Jamboree Rd.',
                'longitude' => '120.868458',
                'latitude' => '14.278183',
                'barangay_code' => '043411014',
                'municipality_code' => '043411000',
                'province_code' => '043400000',
                'region_code' => '040000000',
                'agency_id' => 6,
                
                'created_at' => '2024-02-28 23:02:55',
                'updated_at' => '2024-02-28 23:02:55',
            ),
            5 => 
            array (
                'id' => 6,
                'address' => 'Provincial Engineering Compound',
                'longitude' => '121.0611725',
                'latitude' => '13.7721064',
                'barangay_code' => '041005035',
                'municipality_code' => '041005000',
                'province_code' => '041000000',
                'region_code' => '040000000',
                'agency_id' => 7,
                
                'created_at' => '2024-02-28 23:04:41',
                'updated_at' => '2024-02-28 23:04:41',
            ),
            6 => 
            array (
                'id' => 7,
                'address' => 'Monica',
                'longitude' => '118.734071',
                'latitude' => '9.784145',
                'barangay_code' => NULL,
                'municipality_code' => '175316000',
                'province_code' => '175300000',
                'region_code' => '170000000',
                'agency_id' => 9,
                
                'created_at' => '2024-02-28 23:10:33',
                'updated_at' => '2024-02-28 23:10:33',
            ),
            7 => 
            array (
                'id' => 8,
                'address' => 'Regional Center Site',
                'longitude' => '123.751951',
                'latitude' => '13.167125',
                'barangay_code' => '050506064',
                'municipality_code' => '050506000',
                'province_code' => '050500000',
                'region_code' => '050000000',
                'agency_id' => 10,
                
                'created_at' => '2024-02-28 23:12:58',
                'updated_at' => '2024-02-28 23:12:58',
            ),
            8 => 
            array (
                'id' => 9,
                'address' => 'La Paz',
                'longitude' => '122.563898',
                'latitude' => '10.711773',
                'barangay_code' => '063022102',
                'municipality_code' => '063022000',
                'province_code' => '063000000',
                'region_code' => '060000000',
                'agency_id' => 11,
                
                'created_at' => '2024-02-28 23:17:06',
                'updated_at' => '2024-02-28 23:17:06',
            ),
            9 => 
            array (
                'id' => 10,
                'address' => 'Sudlon',
                'longitude' => '123.896707',
                'latitude' => '10.326021',
                'barangay_code' => '072217041',
                'municipality_code' => '072217000',
                'province_code' => '072200000',
                'region_code' => '070000000',
                'agency_id' => 12,
                
                'created_at' => '2024-02-28 23:20:31',
                'updated_at' => '2024-02-28 23:20:31',
            ),
            10 => 
            array (
                'id' => 11,
                'address' => 'Government Cente',
                'longitude' => '125.003762',
                'latitude' => '11.179108',
                'barangay_code' => '083739009',
                'municipality_code' => '083739000',
                'province_code' => '083700000',
                'region_code' => '080000000',
                'agency_id' => 13,
                
                'created_at' => '2024-02-28 23:21:56',
                'updated_at' => '2024-02-28 23:21:56',
            ),
            11 => 
            array (
                'id' => 12,
                'address' => 'Pettit Barracks',
                'longitude' => '122.0794235',
                'latitude' => '6.9031523',
                'barangay_code' => '097332064',
                'municipality_code' => '097332000',
                'province_code' => '097300000',
                'region_code' => '090000000',
                'agency_id' => 14,
                
                'created_at' => '2024-02-28 23:24:53',
                'updated_at' => '2024-02-28 23:24:53',
            ),
            12 => 
            array (
                'id' => 13,
                'address' => 'J.V. Seriña Street',
                'longitude' => '124.627571',
                'latitude' => '8.482154',
                'barangay_code' => '104305044',
                'municipality_code' => '104305000',
                'province_code' => '104300000',
                'region_code' => '100000000',
                'agency_id' => 15,
                
                'created_at' => '2024-02-28 23:26:25',
                'updated_at' => '2024-02-28 23:26:25',
            ),
            13 => 
            array (
                'id' => 14,
                'address' => 'Friendship-Dumanlas Roads, Bajada',
                'longitude' => '125.619313',
                'latitude' => '7.100831',
                'barangay_code' => NULL,
                'municipality_code' => '112402000',
                'province_code' => '112400000',
                'region_code' => '110000000',
                'agency_id' => 16,
                
                'created_at' => '2024-02-28 23:28:40',
                'updated_at' => '2024-02-28 23:28:40',
            ),
            14 => 
            array (
                'id' => 15,
                'address' => 'Regional Government Center',
                'longitude' => '124.245030',
                'latitude' => '7.195893',
                'barangay_code' => NULL,
                'municipality_code' => '129804000',
                'province_code' => '153800000',
                'region_code' => '150000000',
                'agency_id' => 17,
                
                'created_at' => '2024-02-28 23:31:39',
                'updated_at' => '2024-02-28 23:31:39',
            ),
            15 => 
            array (
                'id' => 16,
                'address' => 'PSTC SARGEN, Brgy. Hall Compound',
                'longitude' => '124.245030',
                'latitude' => '7.195893',
                'barangay_code' => '126303033',
                'municipality_code' => '126303000',
                'province_code' => '126300000',
                'region_code' => '120000000',
                'agency_id' => 18,
                
                'created_at' => '2024-02-28 23:36:37',
                'updated_at' => '2024-02-28 23:36:37',
            ),
            16 => 
            array (
                'id' => 17,
                'address' => 'Caraga State University Campus',
                'longitude' => '125.531068',
                'latitude' => '8.949169',
                'barangay_code' => '160202007',
                'municipality_code' => '160202000',
                'province_code' => '160200000',
                'region_code' => '160000000',
                'agency_id' => 19,
                
                'created_at' => '2024-02-28 23:39:52',
                'updated_at' => '2024-02-28 23:39:52',
            ),
            17 => 
            array (
                'id' => 18,
                'address' => 'ORG Compound',
                'longitude' => '124.2461288',
                'latitude' => '7.1977899',
                'barangay_code' => '129804004',
                'municipality_code' => '129804000',
                'province_code' => '153800000',
                'region_code' => '150000000',
                'agency_id' => 20,
                
                'created_at' => '2024-02-28 23:42:03',
                'updated_at' => '2024-02-28 23:42:03',
            ),
            18 => 
            array (
                'id' => 19,
                'address' => 'Gen. Santos Ave., Bicutan',
                'longitude' => '121.053114',
                'latitude' => '14.489892',
                'barangay_code' => NULL,
                'municipality_code' => '137607000',
                'province_code' => '170000000',
                'region_code' => '130000000',
                'agency_id' => 21,
                
                'created_at' => '2024-02-28 23:46:17',
                'updated_at' => '2024-02-28 23:46:17',
            ),
            19 => 
            array (
                'id' => 20,
                'address' => 'Narra Rd., Forestry Campus, College',
                'longitude' => '121.235461',
                'latitude' => '14.156966',
                'barangay_code' => NULL,
                'municipality_code' => '043411000',
                'province_code' => '043400000',
                'region_code' => '040000000',
                'agency_id' => 22,
                
                'created_at' => '2024-02-28 23:47:50',
                'updated_at' => '2024-02-28 23:47:50',
            ),
            20 => 
            array (
                'id' => 21,
                'address' => 'DOST Gen. Santos Ave.',
                'longitude' => '121.050719',
                'latitude' => '14.489730',
                'barangay_code' => NULL,
                'municipality_code' => '137607000',
                'province_code' => '170000000',
                'region_code' => '130000000',
                'agency_id' => 23,
                
                'created_at' => '2024-02-28 23:50:24',
                'updated_at' => '2024-02-28 23:50:24',
            ),
            21 => 
            array (
                'id' => 22,
                'address' => 'DOST Gen. Santos Ave.',
                'longitude' => '121.049609',
                'latitude' => '14.486842',
                'barangay_code' => NULL,
                'municipality_code' => '137607000',
                'province_code' => '170000000',
                'region_code' => '130000000',
                'agency_id' => 24,
                
                'created_at' => '2024-02-28 23:51:33',
                'updated_at' => '2024-02-28 23:51:33',
            ),
            22 => 
            array (
                'id' => 23,
                'address' => 'Commonwealth Avenue, Diliman',
                'longitude' => '121.055715',
                'latitude' => '14.661146',
                'barangay_code' => NULL,
                'municipality_code' => '137404000',
                'province_code' => '170000000',
                'region_code' => '130000000',
                'agency_id' => 25,
                
                'created_at' => '2024-02-28 23:55:33',
                'updated_at' => '2024-02-28 23:55:33',
            ),
            23 => 
            array (
                'id' => 24,
                'address' => 'DOST Gen. Santos Ave., Bicutan',
                'longitude' => '121.047867',
                'latitude' => '14.487292',
                'barangay_code' => NULL,
                'municipality_code' => '137607000',
                'province_code' => '170000000',
                'region_code' => '130000000',
                'agency_id' => 26,
                
                'created_at' => '2024-02-28 23:56:31',
                'updated_at' => '2024-02-28 23:56:31',
            ),
            24 => 
            array (
                'id' => 25,
                'address' => 'Civic Drive Filinvest Corporate City',
                'longitude' => '121.0395257',
                'latitude' => '14.4126992',
                'barangay_code' => '137603001',
                'municipality_code' => '137603000',
                'province_code' => '170000000',
                'region_code' => '130000000',
                'agency_id' => 27,
                
                'created_at' => '2024-02-29 00:29:28',
                'updated_at' => '2024-02-29 00:29:28',
            ),
            25 => 
            array (
                'id' => 26,
                'address' => '1101 East Ave, Diliman',
                'longitude' => '120.9687049',
                'latitude' => '14.5879321',
                'barangay_code' => NULL,
                'municipality_code' => '137404000',
                'province_code' => '170000000',
                'region_code' => '130000000',
                'agency_id' => 28,
                
                'created_at' => '2024-02-29 00:31:50',
                'updated_at' => '2024-02-29 00:31:50',
            ),
            26 => 
            array (
                'id' => 27,
                'address' => 'FPA Bldg, B.A.I Compound Visayas Ave',
                'longitude' => '120.9683613',
                'latitude' => '14.5882354',
                'barangay_code' => NULL,
                'municipality_code' => '137404000',
                'province_code' => '170000000',
                'region_code' => '130000000',
                'agency_id' => 29,
                
                'created_at' => '2024-02-29 00:33:08',
                'updated_at' => '2024-02-29 00:33:08',
            ),
            27 => 
            array (
                'id' => 28,
                'address' => '623, Pedro Gil St, Ermita',
                'longitude' => '120.9845589',
                'latitude' => '14.5759405',
                'barangay_code' => NULL,
                'municipality_code' => '133900000',
                'province_code' => '170000000',
                'region_code' => '130000000',
                'agency_id' => 30,
                
                'created_at' => '2024-02-29 00:34:40',
                'updated_at' => '2024-02-29 00:34:40',
            ),
        ));

        
    }
}