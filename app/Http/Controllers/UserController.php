<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWT;

class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {

        $validatedData = $request->validated();
        $user = User::create([
            'name' => $validatedData['name'],
            'role' => $validatedData['role'] ?? 'user',
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        JWTAuth::factory()->setTTL(30);

        $token = JWTAuth::attempt([
            'email' => $validatedData['email'],
            'password' => $validatedData['password']
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ], 201);
    }

    public function login(LoginRequest $request)
    {

        $validatedData = $request->validated();
        $credentials = [
            'email' => $validatedData['email'],
            'password' => $validatedData['password']
        ];
        try {

            JWTAuth::factory()->setTTL(30);
            if (!$token = Auth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Invalid credentials',
                ], 401);
            }
            return response()->json([
                'message' => 'User logged in successfully',
                'user' => Auth::user(),
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'Could not create token',
                'error' => $e->getMessage(),
            ], 500);
        }
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
