<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Login avec Sanctum
     */
    public function login(Request $request)
    {
        
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'device_name' => 'required|string',
        ]);
        
        
        $user = User::where('email', $validated['email'])->first();

        // $cond = Hash::check($validated['password'], $user->password) ;
        

        if (!$user || !Hash::check($validated['password'], $user->password)) {
                        
            return response()->json(
                [
                "status" => false,
                "message" => "Email ou mot de passe incorrect",
                ],
                401);
            
        }

        
        $token = $user->createToken($validated['device_name'])->plainTextToken;

        return response()->json([
            "status" => true,
            "message" => "Successfully authenticated",
            "token_type" => "Bearer",
            "token" => $token,
            "user" => $user
        ], 200);

     return response()->json(
        [
         "message" => "logged in",
         "user" => $user
        ]
     );
     
    }

   
    

    /**
     * Register un nouvel utilisateur
     */
    public function register(Request $request)
    {
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        
        $newUser = User::create([
            "name" => $validated['name'],
            "address" => $validated['address'] ?? null,
            "email" => $validated['email'],
            "role" => $validated['role'],
            "password" => Hash::make($validated['password']),
        ]);

        
        $token = $newUser->createToken('register_device')->plainTextToken;

        return response()->json([
            "status" => true,
            "message" => "User registered successfully",
            "token_type" => "Bearer",
            "token" => $token,
            "user" => $newUser->only(['id', 'name', 'email', 'role', 'address'])
        ], 201);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }

        return response()->json([
            "status" => true,
            "message" => "Successfully logged out"
        ], 200);
    }
}

?>