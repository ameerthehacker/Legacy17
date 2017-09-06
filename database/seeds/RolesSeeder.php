<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['role_name' => 'root'],
            ['role_name' => 'hospitality'],
            ['role_name' => 'developer'],
            ['role_name' => 'organizer'],
            ['role_name' => 'registration']
        ]);
    }
}
