<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Book;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

use App\Http\Resources\BookDetailResource;
use App\Http\Requests\StoreBookReques;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    /**
     * 書籍一覧取得
     * GET /api/v1/books
     */
    public function index(Request $request)
    {
        $query = Book::query()
            ->with('genres')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        // キーワード検索
        if ($keyword = $request->input('keyword')) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                ->orWhere('author', 'like', "%{$keyword}%")
                ->orWhere('isbn', 'like', "%{$keyword}%");
            });
        }

        // ジャンル絞り込み
        if ($genreId = $request->input('genre_id')) {
            $query->whereHas('genres', function ($q) use ($genreId) {
                $q->where('genres.id', $genreId);
            });
        }

        $books = $query
            ->latest()
            ->paginate(
                $request->integer('per_page', 10)
            );

        return BookResource::collection($books);
    }
    
    /**
     * 書籍詳細取得
     * GET /api/v1/books/{book}
     */
    public function show(int $id)
    {
        $book = Book::with([
                'genres',
                'reviews.user',
            ])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->find($id);

        if (!$book) {
            return response()->json([
                'message' => '指定された書籍が存在しません。'
            ], 404);
        }

        return new BookDetailResource($book);
    }
    /**
     * 書籍登録
     * POST /api/v1/books
     */
    public function store(StoreBookRequest $request)
    {
        $book = Book::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        return (new BookResource($book))
            ->response()
            ->setStatusCode(201);
    }


    /**
     * 書籍更新
     * PUT/PATCH /api/v1/books/{book}
     */
    public function update(
    UpdateBookRequest $request,
    Book $book
    )
    {
        $validated = $request->validated();

        $genreIds = $validated['genres'];

        unset($validated['genres']);

        $book->update($validated);

        $book->genres()->sync($genreIds);

        return (new BookResource(
            $book->load('genres')
        ))
        ->response()
        ->setStatusCode(200);
    }
    /**
     * 書籍削除
     * DELETE /api/v1/books/{book}
     */
    public function destroy(int $id): JsonResponse
    {
        $book = Book::find($id);
        $this->authorize('delete', $book);

        if (!$book) {
            return response()->json([
                'message' => '指定された書籍が存在しません。'
            ], 404);
        }

        DB::transaction(function () use ($book) {

            // ジャンル紐付け解除
            $book->genres()->detach();

            // お気に入り解除
            $book->favoriteUsers()->detach();

            // レビュー削除
            $book->reviews()->delete();

            // 書籍削除
            $book->delete();
        });

        return response()->json(null, 204);
    }
}