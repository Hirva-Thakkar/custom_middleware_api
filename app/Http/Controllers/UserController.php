<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class UserController extends Controller
{
    public function index()
    {
        $user = User::select('id', 'name', 'email', 'api_token')->paginate(3)->all();
        // return $user;

        if ($user) {
            return response()->json([
                'code' => 1,
                'message' => 'Users retrieved successfully',
                'data' => $user,
            ], 200);
        } else {
            return response()->json([
                'code' => 0,
                'message' => 'No users found',
                'data' => []
            ], 404);
        }
    }

    public function update(Request $request)
    {
        // $user = $request->token;
        // dd($user);
        $request->validate([
            'name' => 'required',
            'email' => 'required'
        ]);

        $user = $request->user;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        // dd($user);
        if ($user) {
            return response()->json([
                'code' => 1,
                'message' => 'User updated successfully',
                'data' => $user,
            ], 200);
        }else{
            return response()->json([
                'code' => 0,
               'message' => 'User not found',
            ], 404);
        }
    }

    public function destroy(Request $request)
    {
        $user = $request->user;
        $user->delete();
        
        return response()->json([
            'code' => 1,
            'message' => 'User deleted successfully',
        ], 200);
    }
}
