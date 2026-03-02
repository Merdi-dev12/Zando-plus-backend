<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // 🔹 Variable de classe
    private $users;

    // 🔹 Initialisation dans le constructeur
    public function __construct()
    {
        $this->users = [
            [
                "uid" => "7f8e20fa-1b21-4d75-aa3d-eb708fc97a0e",
                "name" => "Chiquia",
                "address" => "PO Box 97097",
                "email" => "cbagnall0@tamu.edu",
                "role" => "Construction Manager",
                "password" => "zJ2{\"#1ad7r"
            ],
            [
                "uid" => "4c98934f-fa40-4612-80b3-b55e26d5517f",
                "name" => "Cindie",
                "address" => "Suite 18",
                "email" => "cpettingall1@naver.com",
                "role" => "Project Manager",
                "password" => "nD2},DXtZe\\nBN2H"
            ],
            // … autres utilisateurs …
        ];
    }

    /**
     * Liste tous les utilisateurs
     */
    public function index()
    {
        return response()->json($this->users);
    }

    /**
     * Crée un nouvel utilisateur (simulation)
     */


    /**
     * Affiche un utilisateur par son ID
     */
    public function show(string $id)
    {
        $user = collect($this->users)->firstWhere('uid', $id);

        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        return response()->json($user);
    }

    /**
     * Met à jour un utilisateur (simulation)
     */
    public function update(Request $request, string $id)
    {
        $index = collect($this->users)->search(fn($u) => $u['uid'] === $id);

        if ($index === false) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        $this->users[$index] = array_merge($this->users[$index], $request->all());

        return response()->json($this->users[$index]);
    }

    /**
     * Supprime un utilisateur (simulation)
     */
    public function destroy(string $id)
    {
        $this->users = array_filter($this->users, fn($u) => $u['uid'] !== $id);

        return response()->json(['message' => 'Utilisateur supprimé']);
    }

    /**
     * Méthode all() (similaire à index)
     */
    public function all()
    {
        return response()->json($this->users);
    }
}