<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * GET /api/categories
     */
    public function index()
    {
        return response()->json(Category::all());
    }

    /**
     * GET /api/categories/{id}
     */
    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                "message" => "Catégorie introuvable"
            ], 404);
        }

        return response()->json($category);
    }

    /**
     * POST /api/categories
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "image_url" => "nullable|url"
        ]);

        $category = Category::create($validated);

        return response()->json($category, 201);
    }

    /**
     * PUT /api/categories/{id}
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                "message" => "Catégorie introuvable"
            ], 404);
        }

        $validated = $request->validate([
            "name" => "sometimes|string|max:255",
            "image_url" => "sometimes|url"
        ]);

        $category->update($validated);

        return response()->json($category);
    }

    /**
     * DELETE /api/categories/{id}
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                "message" => "Catégorie introuvable"
            ], 404);
        }

        $category->delete();

        return response()->json([
            "message" => "Catégorie supprimée avec succès"
        ]);
    }
}


?>