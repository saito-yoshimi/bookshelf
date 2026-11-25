<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'title' => $this->title,

            'author' => $this->author,

            'isbn' => $this->isbn,

            'description' => $this->description,

            'published_date' => optional(
                $this->published_date
            )->format('Y-m-d'),

            'image_url' => $this->image_url,

            'genres' => $this->genres->map(function ($genre) {
                return [
                    'id' => $genre->id,
                    'name' => $genre->name,
                ];
            }),

            'average_rating' => round(
                $this->reviews_avg_rating ?? 0,
                1
            ),

            'review_count' => $this->reviews_count ?? 0,

            'reviews' => ReviewResource::collection(
                $this->reviews
            ),
        ];
    }
}