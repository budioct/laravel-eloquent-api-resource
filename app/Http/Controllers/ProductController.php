<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getDetailProductWrapCategory($id)
    {
        // impl Data Wrap

        // sql: select * from `products` where `products`.`id` = ? limit 1
        $products = Product::query()->findOrFail($id); // find() & findOrFail() // find data berdasarkan id

        return new ProductResource($products); // new ProductResource() // instance hasil object di set ke resource (DTO) yang akan di transform bentuk Array atau JSON
    }

    public function getListproductsCustom(){

        // impl Data Wrap Collection

        // sql: select * from `products`
        $products = Product::all(); // all() // Dapatkan semua model dari database.

        return new ProductCollection($products);

    }

}
