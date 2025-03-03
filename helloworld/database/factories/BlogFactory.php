<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // 블로그 생성할 때 소유자까지 함께 생성
            'name' => function (array $attributes) {
                return Str::slug($attributes['display_name']); //display_name이 Hello World라면 hello-world로 지정
            },
            'display_name' => fake()->unique()->words(3, true),
        ];
    }
}
