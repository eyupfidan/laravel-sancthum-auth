<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthController extends Controller
{
    use HttpResponses;
    public function register (Request $request) : JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);
        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password'])
            ]);
        } catch (Exception $exception)
        {
         return response()->json([
             'error' => 'An error occurred, please try again later.'
         ]);
        }


        return  $this->success([
            'user' => $user,
            'token' => $user->createToken($request->email ?? 'Unknown User')->plainTextToken
        ]);
    }

    public function login(Request $request) : JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        $user = User::where('email',$request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json( [
                'message' => 'The provided credentials are incorrect.'
            ], 401);
        }

        return $this->success([
            'user' => $user,
            'token' => $user->createToken($request->email
                ?? 'Unknown User')->plainTextToken
        ]);
    }

    public function logout (Request $request) {
        $request->user->tokens()-delete();
        return response()->json([
            'message' => 'User successfully logged out'
        ]);
    }
}
