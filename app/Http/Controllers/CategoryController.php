<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function getDetailCategory($id)
    {

        // sql: select * from `categories` where `categories`.`id` = ? limit 1
        $category = Category::query()->findOrFail($id); // find() & findOrFail() // find data berdasarkan id

        return new CategoryResource($category); // hasil object di set ke resource (DTO) yang akan di transform bentuk Array atau JSON

    }

}
