<?php

namespace App\Http\Controllers;

use App\Models\Book;

class RankingController extends Controller
{
    /**
     * ランキング一覧
     */
    public function index()
    {
        $rankedBooks = Book::with('genres')
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->paginate(10);

        return view('ranking.index', compact('rankedBooks'));
    }
}