<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reply;
//跳过model监听
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RepliesTableSeeder extends Seeder
{
    use WithoutModelEvents;
    public function run()
    {
        Reply::factory()->count(100)->create();
    }
}

