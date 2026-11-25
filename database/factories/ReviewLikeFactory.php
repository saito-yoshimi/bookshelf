<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewLikeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'=>User::factory(),
            'review_id'=>Review::factory(),
        ];
    }
}
