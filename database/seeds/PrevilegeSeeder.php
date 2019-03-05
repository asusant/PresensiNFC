<?php

use Illuminate\Database\Seeder;

class PrevilegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
				DB::table('previleges')->insert([
					'id_level' => 1,
					'id_menu' => 1,
					'create' => 1,
					'read' => 1,
					'update' => 1,
					'delete' => 1,
				]);

				DB::table('previleges')->insert([
					'id_level' => 1,
					'id_menu' => 2,
					'create' => 1,
					'read' => 1,
					'update' => 1,
					'delete' => 1,
				]);

				DB::table('previleges')->insert([
					'id_level' => 1,
					'id_menu' => 3,
					'create' => 1,
					'read' => 1,
					'update' => 1,
					'delete' => 1,
				]);

				DB::table('previleges')->insert([
					'id_level' => 2,
					'id_menu' => 1,
					'create' => 1,
					'read' => 1,
					'update' => 1,
					'delete' => 1,
				]);

				DB::table('previleges')->insert([
					'id_level' => 2,
					'id_menu' => 2,
					'create' => 1,
					'read' => 1,
					'update' => 1,
					'delete' => 1,
				]);

				DB::table('previleges')->insert([
					'id_level' => 2,
					'id_menu' => 3,
					'create' => 1,
					'read' => 1,
					'update' => 1,
					'delete' => 1,
				]);

				DB::table('previleges')->insert([
					'id_level' => 3,
					'id_menu' => 1,
					'create' => 0,
					'read' => 1,
					'update' => 0,
					'delete' => 0,
				]);

				DB::table('previleges')->insert([
					'id_level' => 3,
					'id_menu' => 2,
					'create' => 0,
					'read' => 1,
					'update' => 0,
					'delete' => 0,
				]);

				DB::table('previleges')->insert([
					'id_level' => 3,
					'id_menu' => 3,
					'create' => 1,
					'read' => 1,
					'update' => 1,
					'delete' => 1,
				]);


    }
}
