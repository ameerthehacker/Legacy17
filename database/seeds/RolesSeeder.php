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
            ['role_name' => 'organizing'],
            ['role_name' => 'registration'],
            ['role_name' => 'hospitality']
        ]);
    }
}
