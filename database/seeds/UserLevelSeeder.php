<?php

use Illuminate\Database\Seeder;

class UserLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
			DB::table('user_levels')->insert([
				'id_user' => 1,
				'id_level' => 1
			]);

			DB::table('user_levels')->insert([
				'id_user' => 1,
				'id_level' => 2
			]);

			DB::table('user_levels')->insert([
				'id_user' => 1,
				'id_level' => 3
			]);

			DB::table('user_levels')->insert([
				'id_user' => 2,
				'id_level' => 2
			]);

			DB::table('user_levels')->insert([
				'id_user' => 3,
				'id_level' => 3
			]);
    }
}
