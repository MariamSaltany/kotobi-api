<?php

namespace App\Eunms\User;
use App\Traits\EnumToArray;

enum UserType: string
{
    case Admin = 'admin';
    case Author = 'author';
    case Customer = 'customer';

    public function is(string $type): bool
    {
        return $this->value === $type;
    }
}
