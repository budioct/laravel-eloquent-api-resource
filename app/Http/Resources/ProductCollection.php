<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     *
     * method toArray yang akan Transform dari object php ke Array atau ke JSON
     * implementasi dari method toArray nya
     *
     * Data Wrap Collection
     *  ● Khusus untuk mengubah attribute $wrap untuk Collection, kita tidak bisa menggunakan
     *    NamaResource::collection(), hal ini karena kode tersebut sebenarnya akan membuat object
     *    AnonymousResourceCollection, bukan menggunakan Resource yang kita buat
     *  ● https://laravel.com/api/10.x/Illuminate/Http/Resources/Json/AnonymousResourceCollection.html
     *  ● Jika hasil result JSON di ResourceCollection.toArray() mengandung attribute yang terdapat di
     *    $wrap, maka Laravel tidak akan melakukan wrap, namun jika tidak ada, maka akan melakukan wrap
     *
     * Resource Response
     *  ● Di method toArray() terdapat parameter Request, yang artinya kita bisa mengambil informasi pada
     *    HTTP Request jika dibutuhkan
     *  ● Resource juga memiliki method withResponse() yang bisa kita override untuk mengubah Http Response
     */

    // jadi cara kerja attribute $wrap untuk merubah super wrap di laravel default adalah "data"
    // kita bisa set seperti ini
    // jika value attribute $wrap == method toArray return["value"] itu tidak akan bungkus membungkus.
    // tetapi jika value attribute $wrap != method toArray return["value"] itu akan bungkus embungkus.

    public static $wrap = "data";

    public function toArray(Request $request): array
    {
        return [
            "data" => ProductResource::collection($this->collection)
        ];
    }

    // kita untuk mengubah Http Response untuk client
    public function withResponse(Request $request, JsonResponse $response)
    {
        $response->header("X-Power-By", "Anak Om Mamat");
    }
}
