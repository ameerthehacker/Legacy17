<?php

use Illuminate\Database\Seeder;

class ConfigsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configs')->insert([
            ['config' => 'registration_open', 'value' => true],
            ['config' => 'offline_link', 'value' => false]
        ]);
    }
}
