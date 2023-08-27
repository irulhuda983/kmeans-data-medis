<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use App\Models\User;

class AuthController extends Controller
{
    
    public function issueToken(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();

        if(!$user) {
            return response()->json([
                'message' => 'Username or password not found'
            ], 403);
        }

        $token = $user->createToken($request->username);
        return response()->json(['token' => $token->plainTextToken, 'userInfo' => new UserResource($user)]);
    }

    public function getMe(Request $request)
    {
        $user = $request->user();

        return new UserResource($user);
    }

    public function updateProfil(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'nama' => 'required',
            'username' => 'required|min:10',
            'foto' => 'nullable'
        ]);

        $user->update([
            'nama' => $request->nama,
            'username' => $request->username,
        ]);

        return response()->json([
            'status' => true,
        ], 200);
    }

    public function ubahPassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'oldPassword' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        if (!password_verify($request->oldPassword, $user->password))
            return response()->json(['error' => 'Password lama tidak sesuai'], 422);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
        ], 200);
    }

    public function logout(Request $request) {
        $user = $request->user();

        if (!$user->currentAccessToken()->delete())
            return response()->json(['error' => 'Terjadi kesalahan'], 500);

        return response()->json(['success' => true]);
    }
}
