<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReadingPlanController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login.form');

// ログイン実行
Route::post('/login', [LoginController::class, 'login'])->name('login');

//会員登録実行
Route::post('/register', [LoginController::class, 'store'])
->name('register');


Route::middleware(['auth'])->group(function () {
    
    /**
     * 書籍一覧、書籍登録
     */
    Route::resource('books', BookController::class);

    /**
     * ランキング
     */
    Route::get('/ranking', [RankingController::class, 'index']) 
        ->name('ranking.index');

    /**
     * お気に入り
     */
    Route::get('/favorites', [FavoriteController::class,'index'])
        ->name('favorites.index');
    
    /**
     * お気に入り登録・解除
     */
    Route::get(
        '/favorites',
        [FavoriteController::class, 'index']
    )->name('favorites.index');
    
    Route::post(
        '/favorites/{book}/toggle',
        [FavoriteController::class, 'toggle']
    )->name('favorites.toggle');

    /**
     * ジャンル管理
     */
    Route::resource('genres', GenreController::class);

        
    /**
     * レビュー
     */
    Route::post(
        '/reviews/{review}/like',
        [ReviewController::class, 'like']
    )->name('reviews.like');

    Route::post(
        '/books/{book}/reviews',
        [ReviewController::class, 'store']
    )->name('reviews.store');

    Route::resource('reviews', ReviewController::class)
        ->except(['store']);

    /**
     * マイレポート
     */
    Route::get(
        '/reports',
        [ReportController::class, 'index']
    )->name('reports.index');

    /**
     * 読書計画
     */
    Route::resource('reading-plans', ReadingPlanController::class)
        ->except(['show']);

    Route::post(
        'reading-plans/{readingPlan}/complete',
        [ReadingPlanController::class, 'complete']
    )->name('reading-plans.complete');

    
     Route::get('/notifications', [
        NotificationController::class,
        'index'
    ])->name('notifications.index');

    Route::post('/notifications/{id}/read', [
        NotificationController::class,
        'markAsRead'
    ])->name('notifications.read');

});