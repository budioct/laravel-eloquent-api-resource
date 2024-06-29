<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductDebugResource;
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

        return new ProductCollection($products); // new CategoryCollection() // instance hasil object di set ke resource (DTO) yang akan di transform bentuk Array atau JSON

    }

    public function getListProductsPaginate(Request $request){

        // impl Pagination

        $page = $request->get("page", 1); // get(key, default) // key get value untuk page yang di input user, jika tidak di input user maka akan set value default 1

        // sql: select * from `products` limit 2 offset 0
        $products = Product::paginate(perPage: 2, page: $page); // paginate() // membuat offset dan limit untuk pagination

        return new ProductCollection($products); // new CategoryCollection() // instance hasil object di set ke resource (DTO) yang akan di transform bentuk Array atau JSON

    }

    public function getListProductsAddContentObject($id){

        // impl Additional Metadata

        // sql: select * from `products` where `products`.`id` = ? limit 1
        $products = Product::query()->findOrFail($id); // find() & findOrFail() // find data berdasarkan id

        return new ProductDebugResource($products); // new ProductDebugResource() // instance hasil object di set ke resource (DTO) yang akan di transform bentuk Array atau JSON

    }

}
