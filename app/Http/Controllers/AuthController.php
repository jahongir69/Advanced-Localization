<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return $this->successResponse([
            'user' => $user,
            'token' => $user->createToken('API Token')->plainTextToken,
        ], __('auth.register_success'));
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return $this->errorResponse(__('auth.invalid_credentials'), 401);
        }

        $user = Auth::user();

        return $this->successResponse([
            'user' => $user,
            'token' => $user->createToken('API Token')->plainTextToken,
        ], __('auth.login_success'));
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->successResponse([], __('auth.logout_success'));
    }
}
