<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewLikeSeeder extends Seeder
{
    public function run(): void
    {
        $likes=[
            1=>[2,3],
            2=>[1,4,5],
            3=>[],
            4=>[2],
            5=>[1,3],
            6=>[2,4],
            7=>[1],
            8=>[5],
            9=>[],
            10=>[1,2,3],
        ];
        
        foreach($likes as $reviewId=>$userIds){
            
            $review=Review::find($reviewId);

            if($review){
                $review->likedByUsers()
                    ->syncWithoutDetaching($userIds);
            }
        }
    }
}
