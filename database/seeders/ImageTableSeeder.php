<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Image::create([
            "user_id" => 1,
            "title" => "テスト投稿",
            "content" => "これはテスト投稿です",
            "src" => "sample.png",
        ]);


    }
}
