<?php

use Illuminate\Database\Seeder;

class CollegesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colleges')->insert([
            ['name' => 'Mepco Schlenk Engineering College'],
            ['name' => 'Thiagaraja College of Engineering'],
            ['name' => 'Velammal College of Engineering']
        ]);
    }
}
