<?php

namespace App\Models\UsersType;

use App\Models\AuthorBook;
use App\Models\Book\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id', 'bio', 'country',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'author_book', 'user_id', 'book_id')
                    ->withPivot('is_owner')
                    ->withTimestamps();
    }
}
