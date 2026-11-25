<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $favorites=[
            1=>[1,2,3,4],
            2=>[2,4,5],
            3=>[1,3,5,7,9],
            4=>[2,6,8],
            5=>[1,4,7,10,11],
        ];

        foreach($favorites as $userId=>$bookIds){
            $user=User::find($userId);

            $user->favoriteBooks()
                ->syncWithoutDetaching($bookIds);
        }
    }
}
