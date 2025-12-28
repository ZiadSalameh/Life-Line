<?php

namespace App\Http\Controllers;

use App\DTOs\UserDto\LoginDto;
use App\DTOs\UserDto\UserDto;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Http\Service\UserService;
use App\Interfaces\User\UserRole;
use App\Models\User;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    // private UserService $userService;
    public function __construct(private UserService $userService)
    {
        $this->userService = $userService;
    }
    public function register(RegisterRequest $request)
    {

        $data = $request->validated();

        $userDto = new UserDto(
            first_name: $data['first_name'],
            last_name: $data['last_name'],
            email: $data['email'],
            password: $data['password'],
            birthdate: isset($data['birthdate']) ? Carbon::parse($data['birthdate']) : null,
            ScinceGrade: $data['ScinceGrade'] ?? null,
            role: isset($data['role']) ? UserRole::from($data['role']) : UserRole::USER,
            office_id: $data['office_id']
        );

        $user = $this->userService->register($userDto);

        return response()->json([
            'data' => new UserResource($user['user']),
            'token' => $user['token'],
            'expires_in' => $user['expires_in']
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $loginDto = new LoginDto(
            email: $data['email'],
            password: $data['password']
        );

        $user = $this->userService->login($loginDto);
        if ($user['success'] === false) {
            return response()->json([
                'message' => $user['message']
            ], 401);
        }
        return response()->json([
            'data' => new UserResource($user['user']),
            'token' => $user['token'],
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ], 200);
    }



    public function getuser($id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            'user' => $user
        ], 200);
    }
    public function getallusers()
    {
        $users = User::all();
        return response()->json([
            'users' => $users,
        ], 200);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json([
            'message' => 'User logged out successfully',
        ], 200);
    }
}
