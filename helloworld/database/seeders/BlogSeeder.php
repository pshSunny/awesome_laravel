<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 모든 유저를 대상으로 블로그를 한 개씩 소유
        User::all()->each(function (User $user) {
            Blog::factory()->for($user)->create();
        });
    }
}
