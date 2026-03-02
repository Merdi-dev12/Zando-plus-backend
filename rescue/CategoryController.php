<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // 🔥 Données fictives avec image_url
    private static $categories = [
        [
            "id" => 1,
            "name" => "Électronique",
            "image_url" => "https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=400&q=80"
        ],
        [
            "id" => 2,
            "name" => "Mode Homme",
            "image_url" => "https://images.unsplash.com/photo-1520974735194-8cdd7c8a9b5d?auto=format&fit=crop&w=400&q=80"
        ],
        [
            "id" => 3,
            "name" => "Mode Femme",
            "image_url" => "https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=400&q=80"
        ],
        [
            "id" => 4,
            "name" => "Sport",
            "image_url" => "https://images.unsplash.com/photo-1526401485004-1b1b0f9b2b15?auto=format&fit=crop&w=400&q=80"
        ],
    ];

    /**
     * GET /api/categories
     */
    public function index()
    {
        return response()->json(self::$categories);
    }

    /**
     * GET /api/categories/all
     */
    public function all()
    {
        return response()->json(self::$categories);
    }

    /**
     * GET /api/categories/{id}
     */
    public function show($id)
    {
        $category = collect(self::$categories)
            ->firstWhere('id', (int) $id);

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
        $request->validate([
            "name" => "required|string",
            "image_url" => "required|url"
        ]);

        $newCategory = [
            "id" => count(self::$categories) + 1,
            "name" => $request->name,
            "image_url" => $request->image_url
        ];

        self::$categories[] = $newCategory;

        return response()->json($newCategory, 201);
    }

    /**
     * PUT /api/categories/{id}
     */
    public function update(Request $request, $id)
    {
        $index = collect(self::$categories)->search(function ($item) use ($id) {
            return $item['id'] == $id;
        });

        if ($index === false) {
            return response()->json([
                "message" => "Catégorie introuvable"
            ], 404);
        }

        if ($request->has('name')) {
            self::$categories[$index]['name'] = $request->name;
        }

        if ($request->has('image_url')) {
            self::$categories[$index]['image_url'] = $request->image_url;
        }

        return response()->json(self::$categories[$index]);
    }

    /**
     * DELETE /api/categories/{id}
     */
    public function destroy($id)
    {
        $index = collect(self::$categories)->search(function ($item) use ($id) {
            return $item['id'] == $id;
        });

        if ($index === false) {
            return response()->json([
                "message" => "Catégorie introuvable"
            ], 404);
        }

        $deleted = self::$categories[$index];
        unset(self::$categories[$index]);

        return response()->json($deleted);
    }
}