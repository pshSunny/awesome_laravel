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
            // 블로그 소유자 제외한 3명 랜덤 사용자
            $subscribers = User::whereNot('id', $user->id)->get()->random(3);

            Blog::factory()->for($user)->hasAttached(
                factory: $subscribers,
                relationship: 'subscription' // 관계의 이름 지정(Blog::subscribers())
            )->create();
        });
    }
}
