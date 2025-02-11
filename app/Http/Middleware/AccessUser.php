<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AccessUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $api_token = $request->header('api_token');
        // $api_token = $request->api_token;

        if (!$api_token) {
            return response()->json([
                'message' => 'API token is required',
            ], 401);
        }

        $user = User::where('api_token', $api_token)->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 401);
        }

        // Auth::login($user);
        $request->user = $user;
        // dd($request->user);

        return $next($request);
    }
}
