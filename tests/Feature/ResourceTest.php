<?php

namespace Tests\Feature;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ResourceTest extends TestCase
{
    /**
     * Resource
     * ● Resource merupakan representasi dari cara melakukan transformasi dari Model menjadi Array /
     *   JSON yang kita inginkan
     * ● Untuk membuat Resource, kita bisa menggunakan perintah :
     *   php artisan make:resource NamaResource
     * ● Class Resource adalah class turunan dari class JsonResource, dan kita perlu mengubah
     *   implementasi dari method toArray nya
     *
     * Cara Kerja Resource
     * ● Resource adalah representasi dari single object data yang ingin kita transform menjadi Array / JSON
     * ● Semua data attribute di model, bisa kita akses menggunakan $this, hal ini karena Resource akan
     *   melakukan proxy call ke model yang sedang digunakan
     * ● Setelah resource dibuat, kita bisa kembalikan di Controller atau di Route, dan Laravel secara
     *   otomatis mengerti bahwa response ini berupa Resource
     *
     * Wrap Attribute
     * ● Secara default, data JSON yang kita kembalikan dalam method toArray() akan di wrap dalam
     *   attribute bernama “data”
     * ● Jika kita ingin ubah nama attribute di JSON nya, kita bisa ubah menggunakan attribute $wrap di
     *   Resource nya
     *
     * // buat resource untuk model category
     */

    public function testResourceModelCategory()
    {

        $this->seed([
            CategorySeeder::class
        ]);

        // sql: select * from `categories` where `categories`.`id` = ? limit 1
        $category = Category::query()->first();
        self::assertNotNull($category);

        $this->get("api/category/$category->id")
            ->assertStatus(200)
            ->assertJson([
                "data" => [
                    "id" => $category->id,
                    "name" => $category->name,
                    "description" => $category->description,
                    "created_at" => $category->created_at->toJSON(), // khusus created_at dan updated_at jika kita tidak konversi ke json akan terkena exception
                    "updated_at" => $category->updated_at->toJSON(),
                ]
            ]);

        Log::info(json_encode($category, JSON_PRETTY_PRINT));

        /**
         * result:
         * endpoint: api/category/{id}
         * {
         *  data: {
         *          id: 11,
         *          name: "Food",
         *          description: "Description Food",
         *          created_at: "2024-06-29T11:11:13.000000Z",
         *          updated_at: "2024-06-29T11:11:13.000000Z"
         *        }
         * }
         */

    }


}
