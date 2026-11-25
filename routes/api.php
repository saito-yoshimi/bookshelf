<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BookController;
use Illuminate\Support\Facades\Route;


Route::post(
    'v1/token',
    [AuthController::class, 'token']
);

Route::prefix('v1')->group(function () {

    // 公開API
    Route::get('books', [BookController::class, 'index']);
    Route::get('books/{book}', [BookController::class, 'show']);

    // 認証必須API
    Route::middleware('auth:sanctum')->group(function () {

        Route::post('books', [BookController::class, 'store']);
        Route::put('books/{book}', [BookController::class, 'update']);
        Route::patch('books/{book}', [BookController::class, 'update']);
        Route::delete('books/{book}', [BookController::class, 'destroy']);
    });
});

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/v1/books/{book}', [BookController::class, 'show'])
        ->missing(function () {
            return response()->json([
                'message' => '指定された書籍は存在しません。'
            ], 404);
        });

    Route::put('/v1/books/{book}', [BookController::class, 'update'])
        ->missing(function () {
            return response()->json([
                'message' => '指定された書籍は存在しません。'
            ], 404);
        });

    Route::patch('/v1/books/{book}', [BookController::class, 'update'])
        ->missing(function () {
            return response()->json([
                'message' => '指定された書籍は存在しません。'
            ], 404);
        });

    Route::delete('/v1/books/{book}', [BookController::class, 'destroy'])
        ->missing(function () {
            return response()->json([
                'message' => '指定された書籍は存在しません。'
            ], 404);
        });
});