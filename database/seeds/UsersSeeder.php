<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['full_name' => 'Root User', 'email' => 'root@legacy.com', 'password' => bcrypt('test'), 'type' => 'admin']
        ]);
        DB::table('role_user')->insert([
            ['role_id' => 1, 'user_id' => 1],
            ['role_id' => 2, 'user_id' => 1],            
        ]);
    }
}
