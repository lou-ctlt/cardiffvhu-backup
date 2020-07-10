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
        DB::table('users')->insert([
            ["name" => "Admin",
            "role" => "administrateur",
            "watermark" => "NULL",
            "email" => "adminemail@admin.com",
            "password" => Hash::make("00000000")],
            ["name" => "User1",
            "role" => "client",
            "watermark" => "watermark.png",
            "email" => "useremail@user.com",
            "password" => Hash::make("12345678")],
        ]);
    }
}