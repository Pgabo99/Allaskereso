<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\UserRoleEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {

        if (Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Már be vagy jelentkezve!'
            ], 403);
        }

        $userParams = $request->validated();
        $isAdminRegister = Auth::check() && Auth::user()->isAdmin();
        if (!$isAdminRegister) {
            $userParams['role'] = UserRoleEnum::USER;
        }

        $user = User::create($userParams);

        if (!$isAdminRegister) {
            Auth::guard('web')->login($user);
            $request->session()->regenerate();
        }

        return response()->json([
            'success' => true,
            'user' => $user,
            'isAdminRegister' => $isAdminRegister
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

    public function getLoggedInUser(): ?User
    {
        if (Auth::check()) {
            return Auth::user();
        }

        return null;
    }

    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $data = $request->validated();

        if (!$user->isAdmin()) {
            unset($data['role']);
        }

        if (empty($data['password'])) {
            unset($data['password']);
        }
        unset($data['password_confirmation']);

        $user->update($data);

        return response()->json([
            'success' => true,
            'user' => $user->fresh()
        ]);
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

    public function destroy(User $user): JsonResponse
    {
        $loggedInUser = Auth::user();
        if ($loggedInUser->getKey() !== $user->getKey() && !$loggedInUser->isAdmin()) {
            return response()->json(['message' => 'Nincs jogosultságod ehhez a művelethez.'], 403);
        }

        if ($loggedInUser->getKey() === $user->getKey()){
            $this->logout(request());
        }
        $user->delete();

        return response()->json(['success' => true]);
    }
}
