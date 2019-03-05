<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
			DB::table('users')->insert([
				'name' => 'Super Admin',
				'email' => 'super@midnight-dev.com',
				'password' => bcrypt('123456'),
				'addres' => 'Gunungpati, Semarang',
				'phone' => '087830415926',
				'username' => 'super'
			]);

			DB::table('users')->insert([
				'name' => 'Admin',
				'email' => 'admin@midnight-dev.com',
				'password' => bcrypt('123456'),
				'addres' => 'Sekaran, Semarang',
				'phone' => '087830415543',
				'username' => 'admin'
			]);

			DB::table('users')->insert([
				'name' => 'User',
				'email' => 'user@midnight-dev.com',
				'password' => bcrypt('123456'),
				'addres' => 'Banaran, Semarang',
				'phone' => '087832315543',
				'username' => 'user'
			]);
    }
}
