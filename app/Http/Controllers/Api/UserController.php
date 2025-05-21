<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function login(Request $request)
    {
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user = User::where('email', $request->email)
            ->select('id', 'name', 'email')
            ->first();
            
        $token = $user->createToken('auth_token')->accessToken;
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function users(Request $request)
    {
        $users = User::select('id', 'name', 'email')->get();
        return response()->json(['users' => $users]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out']);
    }
} 