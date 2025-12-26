<?php

namespace App\Traits;

use App\Models\Media\Media;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasMedia
{
    /**
     * Usage: $book->cover
     */
    public function cover()
    {
        return $this->morphOne(Media::class, 'mediable')
            ->where('collection', 'cover');
    }

    /**
     * Usage: $book->gallery
     */
    public function gallery()
    {
        return $this->morphMany(Media::class, 'mediable')
            ->where('collection', 'gallery');
    }

    public function photo()
    {
        return $this->morphOne(Media::class, 'mediable')
            ->where('collection', 'avatar');
    }
}