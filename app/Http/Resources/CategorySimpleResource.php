<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategorySimpleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     *
     *  Nested Resource
     *  ● Saat kita menggunakan Resource, contoh pada Resource Collection, kita juga bisa menggunakan Resource lainnya
     *  ● Secara default, method toArray() akan dikonversi menjadi JSON
     *  ● Namun, kita bisa menggunakan Resource lain jika kita mau
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description
        ];
    }
}
