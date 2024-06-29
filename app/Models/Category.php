<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = "categories"; // binding nama table categories dengan model Category
    protected $primaryKey = "id"; // primary_key dari table categories adalah id
    protected $keyType = "int"; // type_data id adalah integer
    public $incrementing = true; // primary_key di set auto_increment
    public $timestamps = true; // implementasi created_at dan created_at pada table categories

    // relasi ke products (many)
    // buat method untuk relasi one to many
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id'); // hasMany(Model_Relasi_Many, column_relasi_category, id_tabel_category)
    }

}
