<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;


class Favorite extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'book_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    
    public function toggle(Book $book)
    {
        Auth::user()
            ->favoriteBooks()
            ->toggle($book->id);

        return back();
    }
}
