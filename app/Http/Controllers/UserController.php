<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Http\Service\UserService;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    private UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function register(RegisterRequest $request)
    {
        $user = $this->userService->register($request->validated());

        return response()->json([
            'data' => new UserResource($user['user']),
            'token' => $user['token'],
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $user = $this->userService->login($request->validated());
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
            'user' => $user,
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
