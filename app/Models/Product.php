<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $table = "products"; // binding nama table products dengan model Product
    protected $primaryKey = "id"; // primary_key dari table products adalah id
    protected $keyType = "int"; // type_data id adalah integer
    public $incrementing = true; // primary_key di set auto_increment
    public $timestamps = true; // implementasi created_at dan created_at pada table products

    // balikan method
    // relasi ke category (one)
    // buat method untuk relasi many to one
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id'); // belongsTo(Model_Relasi_One, column_relasi_category, id_reference_table_category)
    }
}
