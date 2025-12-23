<?php

namespace App\Eunms\User;

enum UserStatus: string
{
    case Active = 'active';
    case Blocked = 'blocked';
    case Pending = 'pending';
}
