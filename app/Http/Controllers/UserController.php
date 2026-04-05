<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class UserController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse {

        if (Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Már be vagy jelentkezve!'
            ], 403);
        }

        $userParams = $request->validated();

        $user = User::create($userParams);

        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (!Auth::guard('web')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Hibás email vagy jelszó'
            ], 401);
        }

        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'user' => Auth::user()
        ]);
    }

    public function getLoggedInUser(): Authenticatable|null
    {
        if (Auth::check()) {
            return Auth::user();
        }

        return null;
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true
        ]);
    }
}
