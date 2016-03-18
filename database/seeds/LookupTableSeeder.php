<?php

use Illuminate\Database\Seeder;

class LookupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('lookup')->truncate();

        DB::table('lookup')->insert([
	            'key' => 'island_group',
	            'title' => 'Luzon',
	            'description' => 'Luzon',
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('lookup')->insert([
	            'key' => 'island_group',
	            'title' => 'Visayas',
	            'description' => 'Visayas',
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('lookup')->insert([
	            'key' => 'island_group',
	            'title' => 'Mindanao',
	            'description' => 'Mindanao',
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('lookup')->insert([
	            'key' => 'region',
	            'title' => 'NCR',
	            'description' => 'National Capital Region',
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('lookup')->insert([
	            'key' => 'region',
	            'title' => 'Region I',
	            'description' => 'Ilocos Region',
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('lookup')->insert([
	            'key' => 'region',
	            'title' => 'CAR',
	            'description' => 'Cordillera Administrative Region',
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('lookup')->insert([
	            'key' => 'region',
	            'title' => 'Region II',
	            'description' => 'Cagayan Valley',
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('lookup')->insert([
	            'key' => 'region',
	            'title' => 'Region III',
	            'description' => 'Central Luzon',
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('lookup')->insert([
	            'key' => 'region',
	            'title' => 'Region IV-A',
	            'description' => 'Calabarzon',
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('lookup')->insert([
	            'key' => 'region',
	            'title' => 'Region IV-B',
	            'description' => 'Mimaropa',
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('lookup')->insert([
	            'key' => 'region',
	            'title' => 'Region V',
	            'description' => 'Bicol Region',
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('lookup')->insert([
	            'key' => 'region',
	            'title' => 'Region VI',
	            'description' => 'Western Visayas',
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('lookup')->insert([
	            'key' => 'region',
	            'title' => 'Region VII',
	            'description' => 'Central Visayas',
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('lookup')->insert([
	            'key' => 'region',
	            'title' => 'Region VIII',
	            'description' => 'Eastern Visayas',
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('lookup')->insert([
	            'key' => 'region',
	            'title' => 'Region IX',
	            'description' => 'Zamboanga Peninsula',
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('lookup')->insert([
	            'key' => 'region',
	            'title' => 'Region X',
	            'description' => 'Northern Mindanao',
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('lookup')->insert([
	            'key' => 'region',
	            'title' => 'Region XI',
	            'description' => 'Davao Region',
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('lookup')->insert([
	            'key' => 'region',
	            'title' => 'Region XII',
	            'description' => 'Soccsksargen',
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('lookup')->insert([
	            'key' => 'region',
	            'title' => 'Region XIII',
	            'description' => 'Caraga',
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('lookup')->insert([
	            'key' => 'region',
	            'title' => 'ARMM',
	            'description' => 'Autonomous Region in Muslim Mindanao',
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('lookup')->insert([
	            'key' => 'sex',
	            'title' => 'Male',
	            'description' => 'Male',
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

	    DB::table('lookup')->insert([
	            'key' => 'sex',
	            'title' => 'Female',
	            'description' => 'Female',
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);
    }
}
