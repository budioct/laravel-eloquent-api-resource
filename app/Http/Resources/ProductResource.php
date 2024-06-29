<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     *
     * method toArray yang akan Transform dari object php ke Array atau ke JSON
     * implementasi dari method toArray nya
     *
     * Data Wrap
     * ● Secara default, data JSON yang dibuat oleh Resource akan disimpan dalam attribute “data”
     * ● Jika kita ingin menggantinya, kita bisa ubah attribute $wrap di Resource dengan nama attribute
     *   yang kita mau
     * ● Secara default, jika dalam toArray() kita mengembalikan array yang terdapat attribute sama
     *   dengan $wrap, maka data JSON tidak akan di wrap
     */

    public static $wrap = "wrap_custom"; // $wrap attribute digunakan untuk merubah wrap custom // ini akan merubah default wrap object json "data" ke "wrap_custom"
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "category" => new CategorySimpleResource($this->category), // attribute category adalah relasi method category(): BelongsTo, kita cukup panggil saja seperti attribute
            "price" => $this->price,
            "stock" => $this->stock,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
