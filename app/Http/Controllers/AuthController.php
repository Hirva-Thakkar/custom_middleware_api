<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // return "register";
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        // $fields['api_token'] = Str::random(40);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->api_token = Str::random(40);
        $user->save();

        // $token = $user->createToken($request->name);

        return response()->json([
            'message' => 'User Register successfully',
            'user' => $user,
        ], 201);
    }
    public function login(Request $request)
    {
        // return "login";
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ]);
        }

        $token = $user->api_token;

        return response()->json([
            'message' => 'User Login successfully',
            'user' => $user,
            'token' => $token
        ], 200);
    }
    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            // $user->api_token = null;
            $user->save();

            return response()->json([
                'code' => 1,
                'message' => 'User logged out successfully',
                'data' => []
            ], 200);
        } else {
            return response()->json([
                'message' => 'User not authenticated',
            ], 401);
        }
    }
}
