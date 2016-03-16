<?php

use Illuminate\Database\Seeder;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('stores')->truncate();

        DB::table('stores')->insert([
	            'store_code' => 'PL1',
	            'trade_name' => 'PC - Toms World',
	            'name' => 'Festival Mall',
	            'category' => 1,
	            'address' => '3rd Level, Xsite Area and KBOX Festival Super Mall',
	            'barangay' => 'Filinvest',
	            'district' => 'Alabang',
	            'city' => 'Muntinlupa City',
	            'province' => 'Metro Manila',
	            'zip_code' => '1770',
	            'region' => 'National Capital Region',
	            'island_group' => 'Luzon',
	            'latitude' => '14.4157',
	            'longitude' => '121.039',
	            'date_opened' => '1987-07-09 00:00:00',
	            'size' => 2146,
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('stores')->insert([
	            'store_code' => 'PL2',
	            'trade_name' => 'PTI - Toms World',
	            'name' => 'SM Fairview',
	            'category' => 1,
	            'address' => '2nd Level with Satellite In-Front, Annex building ',
	            'barangay' => 'Greater Lagro',
	            'district' => 'Novaliches',
	            'city' => 'Quezon City',
	            'province' => 'Metro Manila',
	            'zip_code' => '1118',
	            'region' => 'National Capital Region',
	            'island_group' => 'Luzon',
	            'latitude' => '14.7337',
	            'longitude' => '121.059',
	            'date_opened' => '1989-10-28 00:00:00',
	            'size' => 275,
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('stores')->insert([
	            'store_code' => 'PL3',
	            'trade_name' => 'JPI - Toms World',
	            'name' => 'SM Southmall',
	            'category' => 1,
	            'address' => 'Unit 236, 2nd Level',
	            'barangay' => 'Almanza Uno',
	            'district' => 'Alabang',
	            'city' => 'Las Pinas City',
	            'province' => 'Metro Manila',
	            'zip_code' => '1750',
	            'region' => 'National Capital Region',
	            'island_group' => 'Luzon',
	            'latitude' => '14.4327',
	            'longitude' => '121.008',
	            'date_opened' => '1991-12-07 00:00:00',
	            'size' => 978.48,
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	     DB::table('stores')->insert([
	            'store_code' => 'SPG',
	            'trade_name' => 'TJI - Toms World',
	            'name' => 'SM Pampanga',
	            'category' => 1,
	            'address' => 'Jose Abad Santos Avenue, Corner North Luzon Expressway',
	            'barangay' => 'San Jose',
	            'district' => 'San Jose',
	            'city' => 'San Fernando',
	            'province' => 'Pampanga',
	            'zip_code' => '2000',
	            'region' => 'National Capital Region',
	            'island_group' => 'Luzon',
	            'latitude' => '15.0526',
	            'longitude' => '120.6993',
	            'date_opened' => '1992-07-15 00:00:00',
	            'size' => 837.39,
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);
    }
}
