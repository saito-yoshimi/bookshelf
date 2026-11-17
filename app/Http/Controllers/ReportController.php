<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 自分のレビュー
        $reviews = Review::with(['book.genres'])
            ->where('user_id', $user->id)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | 基本統計
        |--------------------------------------------------------------------------
        */
        $summary = [
            'total_reviews' => $reviews->count(),
            'books_read' => $reviews->pluck('book_id')->unique()->count(),
            'average_rating' => $reviews->avg('rating') ?? 0,
        ];

        /*
        |--------------------------------------------------------------------------
        | 評価分布
        |--------------------------------------------------------------------------
        */
        $ratingDistribution = collect();

        for ($i = 1; $i <= 5; $i++) {
            $ratingDistribution->push(
                $reviews->where('rating', $i)->count()
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 高評価書籍 TOP5
        |--------------------------------------------------------------------------
        */
        $topRatedBooks = $reviews
            ->where('rating', '>=', 4)
            ->sortByDesc('rating')
            ->take(5)
            ->map(function ($review) {

                return [
                    'id' => $review->book->id,
                    'title' => $review->book->title,
                    'author' => $review->book->author,
                    'rating' => $review->rating,
                ];
            })
            ->values()
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | ジャンル別評価
        |--------------------------------------------------------------------------
        */
        $genreStats = [];

        foreach ($reviews as $review) {

            if (!$review->book) {
                continue;
            }

            foreach ($review->book->genres as $genre) {

                if (!isset($genreStats[$genre->id])) {
                    $genreStats[$genre->id] = [
                        'id' => $genre->id,
                        'name' => $genre->name,
                        'count' => 0,
                        'total_rating' => 0,
                    ];
                }

                $genreStats[$genre->id]['count']++;
                $genreStats[$genre->id]['total_rating'] += $review->rating;
            }
        }

        $genreRatings = collect($genreStats)
            ->map(function ($genre) {

                return [
                    'id' => $genre['id'],
                    'name' => $genre['name'],
                    'count' => $genre['count'],
                    'average_rating' =>
                        $genre['total_rating'] / $genre['count'],
                ];
            })
            ->sortByDesc('average_rating')
            ->take(5)
            ->values()
            ->toArray();

        $stats = [
            'summary' => $summary,
            'rating_distribution' => $ratingDistribution,
            'top_rated_books' => $topRatedBooks,
            'genre_ratings' => $genreRatings,
        ];

        return view('reports.index', compact('stats'));
    }
}
