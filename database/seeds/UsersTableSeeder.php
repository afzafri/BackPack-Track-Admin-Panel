<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => "Administrator",
            'username' => "admin",
            'phone' => "0123456789",
            'address' => "localhost",
            'country_id' => "134",
            'email' => "admin@gmail.com",
            'password' => bcrypt('admin123'),
            'role' => "admin",
        ]);
    }
}
