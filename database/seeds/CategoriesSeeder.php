<?php

use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([ 
            ['name' => 'Single', 'first_prize' => 15, 'second_prize' => 10, 'third_prize' => 5],
            ['name' => 'Medium', 'first_prize' => 30, 'second_prize' => 20, 'third_prize' => 10],
            ['name' => 'Mega', 'first_prize' => 15, 'second_prize' => 10, 'third_prize' => 5] 
        ]);
    }
}
