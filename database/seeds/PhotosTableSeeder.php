<?php

use Illuminate\Database\Seeder;

class PhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('photos')->insert([
            "user_id" => 2,
            "folder_id" => 1,
            "watermark" => "no",
            "photo_path" => "cars1.jpg",
            "created_at" => "2020-07-06 15:50:33"
        ]);
        DB::table('photos')->insert([
            "user_id" => 2,
            "folder_id" =>1,
            "watermark" => "no",
            "photo_path" => "cars2.jpg",
            "created_at" => "2020-07-06 15:51:33"
        ]);
        DB::table('photos')->insert([
            "user_id" => 2,
            "folder_id" => 1,
            "watermark" => "no",
            "photo_path" => "cars3.jpg",
            "created_at" => "2020-07-06 15:52:33"
        ]);
        DB::table('photos')->insert([
            "user_id" => 2,
            "folder_id" => 2,
            "watermark" => "no",
            "photo_path" => "roue1.jpg",
            "created_at" => "2020-07-06 15:53:33"
        ]);
    }
}
