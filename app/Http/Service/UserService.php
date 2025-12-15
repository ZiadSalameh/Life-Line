<?php

namespace App\Http\Service;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService
{
    public function register(array $data): array
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'bitrthdate' => $data['bitrthdate'] ?? null,
            'ScinceGrade' => $data['ScinceGrade'] ?? null,
            'role' => $data['role'] ?? 'user',
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'office_id' => $data['office_id'],
        ]);

        $token = JWTAuth::fromUser($user);
        return [
            'user' => $user,
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ];
    }

    public function login(array $data): array
    {
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password']
        ];
        if (!$token = JWTAuth::attempt($credentials)) {
            return [
                'message' => 'Invalid credentials'
            ];
        }
        return [
            'success' => true,
            'message' => 'User logged in successfully',
            'user' => JWTAuth::user(),
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ];
    }
}
