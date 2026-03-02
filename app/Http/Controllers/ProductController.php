<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        // Retourne tous les produits avec leur catégorie
        return response()->json(Product::with('category')->get());
    }

    public function show($id)
    {
        $product = Product::with('category')->find($id);

        if (!$product) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }

        return response()->json($product);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "description" => "nullable|string",
            "category_id" => "required|exists:categories,id",
            "price" => "required|numeric",
            "quantity" => "required|integer|min:0",
            "image_url" => "nullable|url"
        ]);

        $product = Product::create($validated);

        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }

        $validated = $request->validate([
            "name" => "sometimes|string|max:255",
            "description" => "sometimes|string",
            "category_id" => "sometimes|exists:categories,id",
            "price" => "sometimes|numeric",
            "quantity" => "sometimes|integer|min:0",
            "image_url" => "sometimes|url"
        ]);

        $product->update($validated);

        return response()->json($product);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Produit supprimé avec succès']);
    }
}