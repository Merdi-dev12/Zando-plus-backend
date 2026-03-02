<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $categories = [
        ["id" => 1, "name" => "Électronique"],
        ["id" => 2, "name" => "Mode Homme"],
        ["id" => 3, "name" => "Mode Femme"],
        ["id" => 4, "name" => "Sport"],
    ];

    private $products;

    public function __construct()
    {
        $this->products = [
            [
                "name" => "Phone Screen Protector",
                "description" => "Tempered glass screen protector.",
                "category_id" => 1,
                "price" => "$6.74",
                "quantity" => 77,
                "image_url" => "https://pbtcstvmykfrrshzwiin.supabase.co/storage/v1/object/public/product_picture/Cafe-instantane-100g-0321bdf0-6b5b-405f-a0c9-b93ada5778f4.png"
            ],
            [
                "name" => "Elegant Maxi Skirt",
                "description" => "Beautiful floor-length skirt.",
                "category_id" => 3,
                "price" => "$24.99",
                "quantity" => 20,
                "image_url" => "https://pbtcstvmykfrrshzwiin.supabase.co/storage/v1/object/public/product_picture/chips-500g-5eb8f2ea-cdb3-447f-9cd8-2bebdd03e8d5.png"
            ],
            [
                "name" => "Luxury Leather Handbag",
                "description" => "Premium leather handbag.",
                "category_id" => 3,
                "price" => "$120.00",
                "quantity" => 15,
                "image_url" => "https://pbtcstvmykfrrshzwiin.supabase.co/storage/v1/object/public/product_picture/Iphone%2014-0ddb821d-080b-40fc-9bcc-58ccfff53b11.png"
            ],
            [
                "name" => "Wireless Headphones",
                "description" => "Noise-cancelling headphones.",
                "category_id" => 1,
                "price" => "$89.99",
                "quantity" => 40,
                "image_url" => "https://pbtcstvmykfrrshzwiin.supabase.co/storage/v1/object/public/product_picture/Lutosa-1kg-4b13234f-eb82-46f9-b1c3-8646fac6b8aa.png"
            ],
            [
                "name" => "Smart Fitness Watch",
                "description" => "Track your health and fitness.",
                "category_id" => 4,
                "price" => "$59.99",
                "quantity" => 50,
                "image_url" => "https://pbtcstvmykfrrshzwiin.supabase.co/storage/v1/object/public/product_picture/Savon-en-poudre-1kg-dd3ddefa-b25f-4292-8071-a809c7262627.png"
            ],
        ];
    }

    private function categoryExists($categoryId)
    {
        return collect($this->categories)
            ->contains('id', (int) $categoryId);
    }

    public function index()
    {
        return response()->json($this->products);
    }

    public function all()
    {
        return $this->index();
    }

    public function show(string $id)
    {
        if (!isset($this->products[$id])) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }

        return response()->json($this->products[$id]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "category_id" => "required|integer",
            "price" => "required|string",
            "image_url" => "required|url"
        ]);

        if (!$this->categoryExists($request->category_id)) {
            return response()->json([
                "message" => "category_id invalide"
            ], 400);
        }

        $newProduct = $request->all();
        $this->products[] = $newProduct;

        return response()->json($newProduct, 201);
    }

    public function update(Request $request, string $id)
    {
        if (!isset($this->products[$id])) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }

        if ($request->has('category_id') && !$this->categoryExists($request->category_id)) {
            return response()->json([
                "message" => "category_id invalide"
            ], 400);
        }

        $this->products[$id] = array_merge(
            $this->products[$id],
            $request->all()
        );

        return response()->json($this->products[$id]);
    }

    public function destroy(string $id)
    {
        if (!isset($this->products[$id])) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }

        unset($this->products[$id]);

        return response()->json(['message' => 'Produit supprimé']);
    }
}