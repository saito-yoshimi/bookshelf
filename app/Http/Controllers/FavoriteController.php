<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * お気に入り一覧
     */
    public function index()
    {
        $books = Auth::user()
            ->favoriteBooks()
            ->with('genres')
            ->withAvg('reviews', 'rating')
            ->paginate(10);

        
        return view('favorites.index', compact('books'));
    }
     /**
     * お気に入り登録・解除
     */
    public function toggle(Request $request, Book $book)
    {
        $user = $request->user();

        // すでにお気に入り登録されているか確認
        $favorite = Favorite::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->first();

        if ($favorite) {
            // お気に入り解除
            $favorite->delete();

            return back()->with('success', 'お気に入りから削除しました。');
        }

        // お気に入り登録
        Favorite::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);

        return back()->with('success', 'お気に入りに登録しました。');
    }

}