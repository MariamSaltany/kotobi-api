<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Eunms\User\UserStatus;
use Illuminate\Support\Facades\Hash; 
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthGenController extends Controller
{
    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::where('username', $validatedData['username'])->first();

        if (! $user || ! Hash::check($validatedData['password'], $user->password)) {
            throw ValidationException::withMessages([
                'username' => [__('auth.failed')],
            ]);
        }

        if ($user->status->value !== UserStatus::Active->value) {
            return response()->json([
                'data' => null,
                'message' => "Login denied. Your account is {$user->status}.",
                'errors' => ['status' => 'Account not active']
            ], 403);
        }

        $token = $user->createToken('auth_token', [$user->type->value])->plainTextToken;

        return response()->json([
            'data' => ['token' => $token, 'user' => $user->only(['id', 'name', 'username', 'type'])],
            'message' => 'Login successful',
            'errors' => null
        ]);
    }

    public function logout()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user?->currentAccessToken()?->delete();

     
        return response()->json([
            'data' => null,
            'message' => 'Successfully logged out.',
            'errors' => null
        ], 200);
    }
}
