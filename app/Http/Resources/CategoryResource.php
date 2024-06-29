<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     *
     * method toArray yang akan Transform dari object php ke Array atau ke JSON
     * implementasi dari method toArray nya
     *
     * Cara Kerja Resource
     *  ● Resource adalah representasi dari single object data yang ingin kita transform menjadi Array / JSON
     *  ● Semua data attribute di model, bisa kita akses menggunakan $this, hal ini karena Resource akan
     *    melakukan proxy call ke model yang sedang digunakan
     *  ● Setelah resource dibuat, kita bisa kembalikan di Controller atau di Route, dan Laravel secara
     *    otomatis mengerti bahwa response ini berupa Resource
     *
     * Wrap Attribute
     *  ● Secara default, data JSON yang kita kembalikan dalam method toArray() akan di wrap dalam
     *    attribute bernama “data”
     *  ● Jika kita ingin ubah nama attribute di JSON nya, kita bisa ubah menggunakan attribute $wrap di
     *    Resource nya
     *
     * note:
     * // keyword $this get Semua data attribute di model
     *
     * // perlu di ingat hasil Tranform JSON dari toArray() akan di wraping/bungkus keyword data
     * contoh:
     * {
     * data: {
     *     // content object model category disini
     *     id: 13,
     *     name: "Food",
     *     description: "Description Food",
     *     created_at: "2024-06-29T11:15:29.000000Z",
     *     updated_at: "2024-06-29T11:15:29.000000Z"
     *   }
     * }
     */
    public function toArray(Request $request): array
    {
        // [key => value] menjadi {key:value}
        return [
            "id" => $this->id, // $this->id // akses attribute/filed/property yang ada di model Category
            "name" => $this->name,
            "description" => $this->description,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
