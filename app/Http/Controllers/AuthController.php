<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'string|required|min:4',
                'last_name' => 'string|required|min:4',
                'address' => 'nullable|max:90|',
                'phone' => 'string|required|max:14|unique:users',
                'email' => 'string|required|email|unique:users',
                'password' => 'string|required|min: 8',
            ]);

            $formFields = [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password'])
            ];

            $user = User::create($formFields);

            $token = $user->createToken($user->phone)->plainTextToken;


            if (!$user) {
                return response()->json(['error' => "sorry, an error ocurred"], 400);
            }
            // return view('home', ['user' => $user]); for web
            return response()->json(['user' => $user, 'token' => $token], 201);
        } catch (Exception $e) {
            Log::error(['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required',
                'password' => 'required'
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['error' => 'incorrect data'], 401);
            }

            $token = $user->createToken($user->phone)->plainTextToken;

            return response()->json(['message' => $user, 'token' => $token], 200);
        } catch (Exception $e) {
            Log::error(['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        try {
            if (!$request->user()) {
                return response()->json(["error" => "Unauthenticated"]);
            }
            $request->user()->tokens()->delete();
            return response()->json(['mesage' => 'User logged out successfully'], 200);
        } catch (Exception $e) {
            Log::error('Logout error', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
