<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MenuSeeder::class);
        $this->call(SubmenuSeeder::class);
        $this->call(LevelSeeder::class);
        $this->call(PrevilegeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UserLevelSeeder::class);
    }
}
