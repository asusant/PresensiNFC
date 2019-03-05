<?php

use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
				DB::table('levels')->insert(['level' => 'Super Admin']);
				DB::table('levels')->insert(['level' => 'Admin']);
				DB::table('levels')->insert(['level' => 'User']);
    }
}
