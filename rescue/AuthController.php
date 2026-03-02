<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Fake users avec mot de passe hashé
    private $fakeUsers = [
        [
            "uid" => "user_1",
            "name" => "Alice",
            "address" => "Kinshasa",
            "email" => "alice@example.com",
            "role" => "customer",
            "password" => null, // sera rempli dans le constructeur
        ],
        [
            "uid" => "user_2",
            "name" => "Bob",
            "address" => "Paris",
            "email" => "bob@example.com",
            "role" => "admin",
            "password" => null,
        ],
    ];

    public function __construct()
    {
        // On hash les mots de passe en dur pour la simulation
        $this->fakeUsers[0]["password"] = Hash::make("password123");
        $this->fakeUsers[1]["password"] = Hash::make("admin456");
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        // Recherche dans le tableau fakeUsers
        foreach ($this->fakeUsers as $user) {
            if ($user["email"] === $credentials["email"] &&
                Hash::check($credentials["password"], $user["password"])) {

                // Génération d’un token factice (ici juste une chaîne aléatoire)
                $token = base64_encode(random_bytes(24));

                $response_model = [
                    "token" => $token,
                    "user" => $user,
                    "message" => "successfully authenticated"
                ];

                return response()->json($response_model, 200);
            }
        }

        $response_message = [
            "message" => "Email ou mot de passe incorrect",
            "error_code" => 401
        ];

        return response()->json($response_message, 401);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'email' => 'required|email',
            'role' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $newUser = [
            "uid" => uniqid(),
            "name" => $validated['name'],
            "address" => $validated['address'] ?? null,
            "email" => $validated['email'],
            "role" => $validated['role'],
            "password" => Hash::make($validated['password']),
        ];

        // Ici on simule l’ajout en mémoire
        $this->fakeUsers[] = $newUser;

        return response()->json($newUser, 201);
    }
}