<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');

        // attempt login
        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah'
            ], 401);
        }
        $user = auth()->user();
        if (!$user->id_status) {
            auth()->logout();

            return response()->json([
                'success' => false,
                'message' => 'User tidak aktif'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'hakakses_id' => $user->hakakses_id,
                    'kd_kelurahan' => $user->kd_kelurahan
                ],
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        ]);
    }

    public function me()
    {
        $user = auth('api')->user()->load('hakakses');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'hakakses' => $user->hakakses->nama ?? null,
                'kd_kelurahan' => $user->kd_kelurahan,
                'photo_profile' => $user->photo_profile
            ]
        ]);
    }

    public function logout(Request $request)
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return response()->json([
            'success' => true,
            'token' => auth('api')->refresh(),
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
