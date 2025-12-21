<?php

namespace App\Interfaces\User;

enum UserRole: string
{
    case USER = 'user';
    case ADMIN = 'admin';
}
