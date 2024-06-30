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
     *
     * Conditional Attribute
     *  ● Pada beberapa kasus, ketika kita mengakses relation pada model di Resource, secara otomatis
     *    Laravel akan melakukan query ke database
     *  ● Kadang hal ini berbahaya kalo ternyata relasinya sangat banyak, sehingga ketika mengubah
     *    menjadi JSON, akan sangat lambat
     *  ● Kita bisa melakukan pengecekan conditional attribute, bisa kita gunakan untuk pengecekan
     *    boolean ataupun relasi
     *
     * Conditional Method
     *  ● Untuk melakukan pengecekan kondisi, kita bisa gunakan method berikut di Resource
     *  ● when(boolean, value, default)
     *  ● whenHas(attribute, default)
     *  ● whenNotNull(attribute)
     *  ● mergeWhen(boolean, array)
     *  ● whenLoaded(relation)
     */

    public static $wrap = "wrap_custom"; // $wrap attribute digunakan untuk merubah wrap custom // ini akan merubah default wrap object json "data" ke "wrap_custom"
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "category" => new CategorySimpleResource($this->whenLoaded("category")), // whenLoaded() // Conditional Attribute // attribute category adalah relasi method category(): BelongsTo, kita cukup panggil saja seperti attribute
            "price" => $this->price,
            "is_expensive" => $this->when($this->price > 1000, true, false), // when // Conditional Attribute
            "stock" => $this->stock,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
