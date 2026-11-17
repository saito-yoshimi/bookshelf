<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    /**
     * 編集権限
     */
    public function update(User $user, Book $book): bool
    {
        return $user->id === $book->user_id;
    }

    /**
     * 削除権限
     */
    public function delete(User $user, Book $book): bool
    {
        return $user->id === $book->user_id;
    }
}