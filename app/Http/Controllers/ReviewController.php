<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;


class ReviewController extends Controller
{
    public function index(): View
    {
        $reviews = Review::with([
            'user',
            'book',
            'likedByUsers'
        ])->latest()->paginate(10);

        return view(
            'reviews.index',
            compact('reviews')
        );
    }

    /**
     * 書籍一覧＞（書籍の詳細）
     */
    public function like(Review $review): RedirectResponse
    {
        Auth::user()->likedReviews()->toggle($review->id);
        return back();
    }

    /**
     * レビュー登録
     */
    public function store(StoreReviewRequest $request, Book $book): RedirectResponse
    {
        $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'レビューを投稿しました。');
    }

        /**
     * レビュー編集画面
     */
    public function edit(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        return view('reviews.edit', compact('review'));
    }

    /**
     * レビュー更新
     */
    public function update(UpdateReviewRequest $request, Review $review): RedirectResponse
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()
            ->route('books.show', $review->book_id)
            ->with('success', 'レビューを更新しました。');
    }
    /**
     * レビュー削除
     */
    public function destroy(Review $review): RedirectResponse
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $review->delete();

        return back()->with('success', 'レビューを削除しました。');
    }

}