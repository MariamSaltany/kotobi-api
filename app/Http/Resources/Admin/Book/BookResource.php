<?php

namespace App\Http\Resources\Admin\Book;

use App\Http\Resources\Admin\Users\Author\AuthorResource;
use App\Http\Resources\Media\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'isbn'         => $this->isbn,
            'publish_year' => $this->publish_year,
            'stock_level'  => $this->stock,
            'status' => [
                'is_active' => (bool) $this->is_active,
                'label'     => $this->is_active ? 'Active' : 'Inactive',
            ],
            'price'        => [
                'raw'       => $this->price,
                'formatted' => number_format($this->price, 3) . ' LYD',
            ],

            'category' => CategoryResource::make($this->whenLoaded('category')),
            'authors'      => BookAuthorPivotResource::collection($this->whenLoaded('authors')),
            'cover' => MediaResource::make($this->whenLoaded('cover')),
        ];
    }
}
