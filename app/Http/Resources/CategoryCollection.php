<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     *
     * method toArray yang akan Transform dari object php ke Array atau ke JSON
     * implementasi dari method toArray nya
     *
     * Resource Collection
     * ● Kadang, kita ingin membuat class Resource Collection secara manual, tanpa menggunakan
     *   Resource Class yang sudah kita buat
     * ● Pada kasus ini, kita bisa membuat Resource, namun menggunakan tambahan parameter
     *   --collection :
     *   php artisan make:resource NamaCollection --collection
     * ● Secara otomatis class Resource adalah turunan dari class ResourceCollection
     * ● Untuk mengambil informasi collection nya, kita bisa menggunakan attribute $collection
     *
     * // note: $collection get Semua data attribute di model/collection
     */
    public function toArray(Request $request): array
    {
        return [
            "data" => $this->collection,
            "total" => count($this->collection),
        ];
    }
}
