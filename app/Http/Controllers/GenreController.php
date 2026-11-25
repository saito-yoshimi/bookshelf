<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\StoreGenreRequest;
use App\Http\Requests\UpdateGenreRequest;


class GenreController extends Controller
{
    /**
     * ジャンル一覧
     */
    public function index()
    {
        $genres = Genre::withCount('books')
            ->orderBy('name')
            ->get();

        return view('genres.index', compact('genres'));
    }

    /**
     * ジャンル別書籍一覧
     */
    public function show(Genre $genre): View
    {
        $books = $genre->books()
            ->with([
                'genres',
            ])
            ->withAvg('reviews', 'rating')
            ->paginate(10);

        return view('genres.show', compact(
            'genre',
            'books'
        ));
    }

    /**
     * ジャンル登録画面
     */
    public function create()
    {
        return view('genres.create');
    }

    /**
     * ジャンル登録処理
     */
    public function store(StoreGenreRequest $request)
    {
        Genre::create($request->validated());
        
        return redirect()
            ->route('genres.index')
            ->with('success', 'ジャンルを登録しました。');
    }

    
    /**
     * ジャンル編集画面
     */
    public function edit(Genre $genre)
    {
        return view('genres.edit', compact('genre'));
    }

    /**
     * ジャンル更新処理
     */
    public function update(UpdateGenreRequest $request, Genre $genre)
    {
        $validated = $request->validate();

        $genre->update($validated);

        return redirect()
            ->route('genres.index')
            ->with('success', 'ジャンルを更新しました。');
    }

    /**
     * ジャンル削除
     */
    public function destroy(Genre $genre)
    {
        // 書籍が登録されているジャンルは削除しない
        if ($genre->books()->exists()) {
            return redirect()
                ->route('genres.index')
                ->with('error', '書籍が登録されているジャンルは削除できません。');
        }

        $genre->delete();

        return redirect()
            ->route('genres.index')
            ->with('success', 'ジャンルを削除しました。');
    }
}