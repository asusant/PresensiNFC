<?php

use Illuminate\Database\Seeder;

class SubmenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
			// DB::table('submenus')->insert(['id_menu' => 1, 'submenu' => 'Dashboard', 'routing' => 'dashboard.read']);

			// DB::table('submenus')->insert(['id_menu' => 2, 'submenu' => 'All Users', 'routing' => 'users.read']);

			// DB::table('submenus')->insert(['id_menu' => 3, 'submenu' => 'All Contents', 'routing' => 'contents.read']);
			DB::table('submenus')->insert(['id_menu' => 3, 'submenu' => 'Frontend', 'routing' => 'contents.frontend.read']);
			
    }
}
