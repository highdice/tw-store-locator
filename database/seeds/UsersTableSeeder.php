<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        DB::table('users')->insert([
	            'name' => 'Super Admin',
	            'email' => 'twsuperadmin@gmail.com',
	            'password' => Hash::make('superadmin123'),
                'user_level' => 30,
	            'created_at' => date('Y-m-d h:i:s'),
	            'updated_at' => date('Y-m-d h:i:s')
	    ]);

        DB::table('users')->insert([
                'name' => 'Admin',
                'email' => 'twadmin@gmail.com',
                'password' => Hash::make('admin123'),
                'user_level' => 31,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
        ]);

        DB::table('users')->insert([
                'name' => 'User',
                'email' => 'twuser@gmail.com',
                'password' => Hash::make('user123'),
                'user_level' => 32,
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
        ]);
    }
}
