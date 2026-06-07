<?php

namespace App;
use App\Concerns\EnumTrait;

enum RoleEnum : string
{
    use EnumTrait;

    case ADMIN = 'admin';
    case USER = 'user';
}



