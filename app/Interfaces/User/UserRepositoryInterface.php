<?php

namespace App\Interfaces\User;

use App\DTOs\UserDto\LoginDto;
use App\DTOs\UserDto\UserDto;
use App\Models\User;
use Illuminate\Auth\Events\Login;

interface UserRepositoryInterface
{
    public function create(UserDto $userDto): User;
    public function findByEmail(string $email): ?User;
}
