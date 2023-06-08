<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (!auth()->attempt($data)) {
            return response()->json([
                'message' => 'Invalid credentials.'
            ], 401);
        }

        $user = auth()->user();
        $token = $user->createToken('token')->plainTextToken;

        return (new UserResource($user))
            ->additional(['access_token' => $token])
            ->response();
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::create([
            'email' => $data['email'],
            'name' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        $token = $user->createToken('token')->plainTextToken;

        return (new UserResource($user))
            ->additional(['access_token' => $token])
            ->response();
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'data' => null,
            'message' => 'Logged out successfully.'
        ]);
    }

    public function profile(Request $request): JsonResponse
    {
        return (new UserResource($request->user()))
            ->response();
    }
}
