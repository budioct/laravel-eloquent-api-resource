<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/category/{id}", [\App\Http\Controllers\CategoryController::class, 'getDetailCategory']);
Route::get("/categories", [\App\Http\Controllers\CategoryController::class, "getListCategories"]);
Route::get("/categories-custom", [\App\Http\Controllers\CategoryController::class, "getListCategoriesCustom"]);
Route::get("/categories-nested", [\App\Http\Controllers\CategoryController::class, "getListCategoriesNested"]);
Route::get("/product/{id}", [\App\Http\Controllers\ProductController::class, "getDetailProductWrapCategory"]);
Route::get("/products", [\App\Http\Controllers\ProductController::class, "getListproductsCustom"]);
Route::get("/products-paging", [\App\Http\Controllers\ProductController::class, "getListProductsPaginate"]);
Route::get("/products-debug/{id}", [\App\Http\Controllers\ProductController::class, "getListProductsAddContentObject"]);
