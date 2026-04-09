<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    private function checkAdmin(): ?JsonResponse
    {
        if (!Auth::user()->isAdmin()) {
            return response()->json(['message' => 'Nincs jogosultságod ehhez a művelethez.'], 403);
        }
        return null;
    }

    public function index(): JsonResponse
    {
        if ($denied = $this->checkAdmin()) return $denied;

        $users = User::all();

        return response()->json(['users' => $users]);
    }

    public function show(User $user): JsonResponse
    {
        if ($denied = $this->checkAdmin()) return $denied;

        return response()->json(['user' => $user]);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        if ($denied = $this->checkAdmin()) return $denied;

        $data = $request->validated();

        if (empty($data['password'])) {
            unset($data['password']);
        }
        unset($data['password_confirmation']);

        $user->update($data);

        return response()->json(['success' => true, 'user' => $user->fresh()]);
    }
}
