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
        $this->call(CategoriesSeeder::class);
        $this->call(EventsSeeder::class);     
        $this->call(CollegesSeeder::class); 
        $this->call(RolesSeeder::class);    
        $this->call(UsersSeeder::class);       
        $this->call(ConfigsSeeder::class);
    }
}
