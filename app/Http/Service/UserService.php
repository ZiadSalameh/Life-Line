<?php

namespace App\Http\Service;


use App\DTOs\UserDto\UserDto;
use App\DTOs\UserDto\LoginDto;
use App\Interfaces\User\UserRepositoryInterface as UserUserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService
{
    public function __construct(
        private UserUserRepositoryInterface $userRepository
    ) {}

    public function register(UserDto $userDto)
    {
        $userDto = new UserDto(
            first_name: $userDto->first_name,
            last_name: $userDto->last_name,
            email: $userDto->email,
            password: Hash::make($userDto->password),
            birthdate: $userDto->birthdate,
            ScinceGrade: $userDto->ScinceGrade,
            role: $userDto->role,
            office_id: $userDto->office_id
        );

        $user = $this->userRepository->create($userDto);
        $token = JWTAuth::fromUser($user);
        return [
            'user' => $user,
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ];
    }

    public function login(LoginDto $loginDto)
    {
        $user = $this->userRepository->findByEmail($loginDto->email);

        if (!$user || !Hash::check($loginDto->password, $user->password)) {
            return [
                'success' => false,
                'message' => 'Invalid credentials',
            ];
        }

        $token = JWTAuth::fromUser($user);

        return [
            'success' => true,
            'message' => 'User logged in successfully',
            'user' => $user,
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ];
    }
}
