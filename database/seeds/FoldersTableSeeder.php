<?php

use Illuminate\Database\Seeder;

class FoldersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('folders')->insert([
            "user_id" => 2,
            "name" => "Voitures"
        ]);
        DB::table('folders')->insert([
            "user_id" => 2,
            "name" => "Roues"
        ]);
    }
}
