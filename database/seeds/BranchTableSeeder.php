<?php

use Illuminate\Database\Seeder;

class BranchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('branch')->truncate();

        DB::table('branch')->insert([
        		'code' => 'PL01',
	            'branch_code' => 'PL1',
	            'trade_name' => 'PC - Toms World',
	            'name' => 'Festival Mall',
	            'address' => '3rd Level, Xsite Area and KBOX Festival Super Mall, Filinvest, Alabang, Muntinlupa City',
	            'zip_code' => '1770',
	            'region' => 4,
	            'island_group' => 1,
	            'division' => 1,
	            'latitude' => '14.4157',
	            'longitude' => '121.039',
	            'date_opened' => '1987-07-09 00:00:00',
	            'size' => 2146,
	            'status' => 1,
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('branch')->insert([
	    		'code' => 'PL02',
	            'branch_code' => 'PL2',
	            'trade_name' => 'PTI - Toms World',
	            'name' => 'SM Fairview',
	            'address' => '2nd Level with Satellite In-Front, Annex building, Greater Lagro, Novaliches, Quezon City',
	            'zip_code' => '1118',
	            'region' => 4,
	            'island_group' => 1,
	            'division' => 1,
	            'latitude' => '14.7337',
	            'longitude' => '121.059',
	            'date_opened' => '1989-10-28 00:00:00',
	            'size' => 275,
	            'status' => 1,
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('branch')->insert([
	    		'code' => 'PL03',
	            'branch_code' => 'PL3',
	            'trade_name' => 'JPI - Toms World',
	            'name' => 'SM Southmall',
	            'address' => 'Unit 236, 2nd Level, Almanza Uno, Alabang, Las Pinas City',
	            'zip_code' => '1750',
	            'region' => 4,
	            'island_group' => 1,
	            'division' => 1,
	            'latitude' => '14.4327',
	            'longitude' => '121.008',
	            'date_opened' => '1991-12-07 00:00:00',
	            'size' => 978.48,
	            'status' => 1,
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	     DB::table('branch')->insert([
	     		'code' => 'PL04',
	            'branch_code' => 'SPG',
	            'trade_name' => 'TJI - Toms World',
	            'name' => 'SM Pampanga',
	            'address' => 'Jose Abad Santos Avenue, Corner North Luzon Expressway, San Jose, San Fernando City, Pampanga',
	            'zip_code' => '2000',
	            'region' => 4,
	            'island_group' => 1,
	            'division' => 1,
	            'latitude' => '15.0526',
	            'longitude' => '120.6993',
	            'date_opened' => '1992-07-15 00:00:00',
	            'size' => 837.39,
	            'status' => 1,
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);
    }
}
