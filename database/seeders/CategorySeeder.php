<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::query()->create([
            "name" => "Food",
            "description" => "Description Food",
        ]);
        Category::query()->create([
            "name" => "Gadget",
            "description" => "Description Gadget",
        ]);
    }
}
