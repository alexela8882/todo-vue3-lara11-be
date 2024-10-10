<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// Models
use App\Models\User;

class AuthController extends Controller
{
    // Login method
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Generate a token for the user
            $token = $user->createToken('YourAppName')->plainTextToken;

            return response()->json(['token' => $token, 'user' => $user], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // Logout method
    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            // Revoke all tokens for the user
            $user->tokens()->delete();
            return response()->json(['message' => 'Logged out successfully'], 200);
        }

        return response()->json(['message' => 'User not authenticated'], 401);
    }
}
