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
            ['name' => 'Mepco Schlenk Engineering College', 'location' => 'Sivakasi'],
            ['name' => 'Thiagaraja College of Engineering', 'location' => 'Madurai'],
            ['name' => 'Velammal College of Engineering', 'location' => 'Chennai']
        ]);
    }
}
