<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\AuthController;
/**
 * Routes Users
 */
Route::get("/users", [UserController::class, "index"]);
Route::get("/users/{user_id}", [UserController::class, "show"]);
// Route::post("/users", [UserController::class, "store"]);
Route::put("/users/{user_id}", [UserController::class, "update"]);
Route::delete("/users/{user_id}", [UserController::class, "destroy"]);
Route::get("/users/{user_id}/avatar", [UserController::class, "avatar"]);

/**
 * Routes Products
 */
Route::get("/products", [ProductController::class, "index"]);
Route::get("/products/{product_id}", [ProductController::class, "show"]);
Route::post("/products", [ProductController::class, "store"]);
Route::put("/products/{product_id}", [ProductController::class, "update"]);
Route::delete("/products/{product_id}", [ProductController::class, "destroy"]);
/**
 * Routes Categories
 */
Route::get("/categories", [CategoryController::class, "index"]);
Route::post("/categories", [CategoryController::class, "store"]);
Route::put("/categories/{category_id}", [CategoryController::class, "update"]);
Route::delete("/categories/{category_id}", [CategoryController::class, "destroy"]);


/**
 * Routes Cart
 */

Route::get("/cart/{user_id}", [CartController::class, "show"]);
Route::get("/cart/{user_id}/items", [CartController::class, "items"]);
Route::post("/cart/{cart_id}", [CartController::class, "store"]);
Route::post("/cart/{cart_id}/item", [CartController::class, "addItem"]);
Route::put("/cart/{cart_id}/item", [CartController::class, "updateItem"]);
Route::delete("/cart/{cart_id}/item", [CartController::class, "removeItem"]);
/**
 * Routes Commands
 */
Route::get("/commands", [CommandController::class, "index"]);
Route::delete("/commands/{command_id}", [CommandController::class, "destroy"]);

/**
 * Auth routes
 */

Route::post("/login", [AuthController::class, "login"]);
Route::post("/register", [AuthController::class, "register"]);