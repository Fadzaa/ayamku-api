<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest\LoginRequest;
use App\Http\Requests\UserRequest\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(RegisterRequest $request) : JsonResponse
    {
        $data = $request->validated();

        $user = new User($data);
        $user->password = Hash::make($data['password']);

        $user->save();

        return response()->json([
            'message' => 'User created successfully',
            'data' => new UserResource($user)
        ], 201);

    }

    public function login(LoginRequest $request) : JsonResponse
    {
        $data = $request->validated();

        if (!Auth::attempt($data)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = User::all()->where('email', $data['email'])->first();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'data' => new UserResource($user),
            'token' => $token
        ], 200);

    }

    public function currentUser() : JsonResponse
    {
        $user = Auth::user();

        return response()->json([
            'data' => new UserResource($user)
        ], 200);
    }

    public function updateUser(Request $request) : JsonResponse
    {
        $user = User::all()->where('id', Auth::id())->first();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone_number');

        $user->save();

        return response()->json([
            'message' => 'User updated successfully',
            'data' => new UserResource($user)
        ], 200);
    }

    public function logout() : JsonResponse
    {
        $user = User::all()->where('id', Auth::id())->first();

        $user->tokens()->delete();

        return response()->json([
            'message' => 'Logout successful'
        ], 200);
    }
}
