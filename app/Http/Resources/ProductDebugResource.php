<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDebugResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     *
     * method toArray yang akan Transform dari object php ke Array atau ke JSON
     * implementasi dari method toArray nya
     *
     * Additional Metadata
     *  ● Kadang, kita ingin menambahkan attribute tambahan selain “data”
     *  ● Untuk attribute tambahan yang statis, kita bisa tambahkan di Resource dengan meng-override properties $additional
     *
     * Additional Parameter Dinamis
     * ● Jika kita butuh tambahan additional parameter yang dinamis, kita bisa langsung saja buat di dalam toArray()
     * ● Yang penting adalah ada attribute yang sama dengan $wrap
     */

    // cara ini tidak dinamis
    //public $additional = [
    //    "author" => "budhi oct",
    //    "organization" => "Anak Om Mamat"
    //];

    // syarat jika ingin Additional Parameter Dinamis.. kita set super wrap
    public static $wrap = "data";

    public function toArray(Request $request): array
    {
        // ini lebih dinamis jika ingin membuat content body JSON
        return [
            "author" => "budhi oct",
            "organization" => "Anak Om Mamat",
            "data" => [
                "id" => $this->id,
                "name" => $this->name,
                "price" => $this->price,
            ],
            "server_time" => now()->toDateTimeString(),
        ];
    }
}
