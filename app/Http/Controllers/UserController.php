<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed'
        ]);
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_Token')->plainTextToken;

        return response()->json(
            [
                'message' => 'User Registered Successuflly',
                'User' => $user,
                "token" => $token
            ],
            201
        );
    }


    public function login(Request $request)
    {
        $request->validate([

            // 'email'=>'required|string|email',
            'email' => 'required|string|email|exists:users',
            'password' => 'required|string|min:8'
        ]);

        if (!Auth::attempt($request->only('email', 'password')))
            return response()->json(['message' => 'Invalid Email Or Password'], 401);

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_Token')->plainTextToken;
        return response()->json(
            [
                // 'error' => ['email' => ['The provider credentails are incorrect']],
                'message' => 'User Login Successuflly',
                'User' => new UserResource($user),
                'token' => $token
            ],
            200
        );
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(
            [
                'message' => 'User Logout Successuflly'
            ],
            200
        );
    }
    
    
    public function GetUser($id){
     try{
        $user = User::with('office')->findOrFail($id);
        return response()->json([
            'date' => new UserResource($user)
        ],200);
     }
     catch(ModelNotFoundException $e){
        return response()->json([
            'message' => 'User not found',
            'error' => $e->getMessage()
        ], 404);
     }
    }
     public function GetAllUsers(){
      $userData = User::with('office')->get();
      return  UserResource::collection($userData);
    }
}
