<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Import du modèle Eloquent

class UserController extends Controller
{
    /**
     * Liste tous les utilisateurs
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Crée un nouvel utilisateur
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'email' => 'required|email|unique:users',
            'role' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'uid' => uniqid(),
            'name' => $validated['name'],
            'address' => $validated['address'] ?? null,
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => bcrypt($validated['password']), // hash du mot de passe
        ]);

        return response()->json($user, 201);
    }

    /**
     * Affiche un utilisateur par son ID
     */
    public function show(string $id)
    {
        $user = User::where('uid', $id)->first();

        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        return response()->json($user);
    }

    /**
     * Met à jour un utilisateur
     */
    public function update(Request $request, string $id)
    {
        $user = User::where('uid', $id)->first();

        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        $user->update($request->all());

        return response()->json($user);
    }

    /**
     * Supprime un utilisateur
     */
    public function destroy(string $id)
    {
        $user = User::where('uid', $id)->first();

        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Utilisateur supprimé']);
    }

    /**
     * Méthode all() (similaire à index)
     */
    public function all()
    {
        $users = User::all();
        return response()->json($users);
    }
}

?>