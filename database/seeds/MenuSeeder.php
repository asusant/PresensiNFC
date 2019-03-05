<?php

use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
			DB::table('menus')->insert(['menu' => 'Dashboard', 'route' => 'dashboard', 'routing' => 'dashboard.read']);
			DB::table('menus')->insert(['menu' => 'Users', 'route' => 'users', 'routing' => 'users.read']);
			DB::table('menus')->insert(['menu' => 'Content', 'route' => 'content', 'routing' => 'content.read']);
    }
}
