<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use App\Models\Book;
use App\Models\Genre;

class BookController extends Controller
{
    /**
     * 書籍一覧
     */
    public function index()
    {
        $books = Book::with('genres')
            ->withAvg('reviews', 'rating')
            ->paginate(10);
        
        return view('books.index', compact('books'));
    }

    /**
     * 書籍詳細
     */
    public function show(string $id)
    {
        $book = Book::with([
                'genres',
                'reviews.user',
                'reviews.likedByUsers'
            ])
            ->withAvg('reviews', 'rating')
            ->findOrFail($id);

        return view('books.show', compact('book'));
    }

    /**
     * 書籍登録画面
     */
    public function create()
    {
        $genres = Genre::orderBy('name')->get();

        return view('books.create', compact('genres'));
    }

    /**
     * 書籍登録処理
     */
    public function store(
        StoreBookRequest $request
    ): RedirectResponse
    {
        $book = Book::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'author' => $request->author,
            'isbn' => $request->isbn,
            'published_date' => $request->published_date,
            'description' => $request->description,
            'image_url' => $request->image_url,
        ]);

        $book->genres()->sync($request->genres);

        return redirect()
            ->route('books.index')
            ->with(
                'success',
                '書籍を登録しました。'
            );
    }

    
    /**
     * 編集画面
     */
    public function edit(string $id)
    {
        $book = Book::with('genres')->findOrFail($id);
        $genres = Genre::orderBy('name')->get();

        return view('books.edit', compact('book', 'genres'));
    }

    /**
     * 更新処理
     */
    public function update(UpdateBookRequest $request, string $id)
    {
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'published_date' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
            'image_url' => ['nullable', 'url', 'max:2048'],
            'genres' => ['nullable', 'array'],
            'genres.*' => ['exists:genres,id'],
        ]);

        $genreIds = $validated['genres'] ?? [];
        unset($validated['genres']);

        // 書籍情報を更新
        $book->update($validated);

        // ジャンルを更新
        $book->genres()->sync($genreIds);

        return redirect()
            ->route('books.show', $book)
            ->with('success', '書籍を更新しました。');
    }

    /**
     * 削除
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);

        // ジャンルとの関連を削除
        $book->genres()->detach();

        $book->delete();

        return redirect()
            ->route('books.index')
            ->with('success', '書籍を削除しました。');
    }

 
}
