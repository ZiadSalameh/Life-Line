<?php

namespace App\Repositories;

use App\DTOs\UserDto\UserDto;
use App\Interfaces\User\UserRepositoryInterface as UserUserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserUserRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function create(UserDto $userDto): User
    {
        return User::create([
            'first_name' => $userDto->first_name,
            'last_name' => $userDto->last_name,
            'birthdate' => $userDto->birthdate,
            'ScinceGrade' => $userDto->ScinceGrade,
            'role' => $userDto->role,
            'email' => $userDto->email,
            'password' => $userDto->password,
            'office_id' => $userDto->office_id,
        ]);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
