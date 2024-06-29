<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function getDetailCategory($id)
    {

        // impl Resource

        // sql: select * from `categories` where `categories`.`id` = ? limit 1
        $category = Category::query()->findOrFail($id); // find() & findOrFail() // find data berdasarkan id

        return new CategoryResource($category); // new CategoryResource() // instance hasil object di set ke resource (DTO) yang akan di transform bentuk Array atau JSON

    }

    public function getListCategories(){

        // impl Resource Collection

        // sql: select * from `categories`
        $categories = Category::all(); // all() // Dapatkan semua model dari database.

        return CategoryResource::collection($categories); // collection() // juga bisa parsing data ke resource (DTO) yang akan di transform bentuk Array atau JSON

    }

    public function getListCategoriesCustom(){

        // impl Custom Resource Collection

        // sql: select * from `categories`
        $categories = Category::all(); // all() // Dapatkan semua model dari database.

        return new CategoryCollection($categories); // new CategoryCollection() // instance hasil object di set ke resource (DTO) yang akan di transform bentuk Array atau JSON

    }

    public function getListCategoriesNested(){

        // impl Nested Resource

        // sql: select * from `categories`
        $categories = Category::all(); // all() // Dapatkan semua model dari database.

        return new CategoryCollection($categories); // new CategoryCollection() // instance hasil object di set ke resource (DTO) yang akan di transform bentuk Array atau JSON

    }

}
