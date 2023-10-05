<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $data = $request->validated();

        $user = User::whereEmail($data['email'])->first();

        $token = $user->createToken('admin_token')->plainTextToken;

        return response()
            ->json(['access_token' => $token])
            ->withCookie(cookie('token', $token));
    }

    public function logout(): void
    {
        auth()->user()->currentAccessToken()->delete();
    }
}
