<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AuthorBook extends Pivot
{
public $incrementing = false;

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_owner' => 'boolean',
    ];
}