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
         * endpoint: /api/category/{id}
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




    /**
     * Resource Collection
     * ● Secara default, Resource yang sudah kita buat, bisa kita gunakan untuk menampilkan data multiple
     *   object atau dalam bentuk JSON Array
     * ● Kita bisa menggunakan static method collection() ketika membuat Resource nya, dan gunakan
     *   parameter berisi data collection
     */

    public function testResourceCollectionCategories()
    {

        $this->seed([
            CategorySeeder::class
        ]);

        // sql: select * from `categories` where `categories`.`id` = ? limit 1
        $category = Category::all(); // all() // Dapatkan semua model dari database.
        self::assertNotNull($category);

        $this->get("api/categories")
            ->assertStatus(200)
            ->assertJson([
                "data" => [
                    [
                        "id" => $category[0]->id,
                        "name" => $category[0]->name,
                        "description" => $category[0]->description,
                        "created_at" => $category[0]->created_at->toJSON(), // khusus created_at dan updated_at jika kita tidak konversi ke json akan terkena exception
                        "updated_at" => $category[0]->updated_at->toJSON(),
                    ],
                    [
                        "id" => $category[1]->id,
                        "name" => $category[1]->name,
                        "description" => $category[1]->description,
                        "created_at" => $category[1]->created_at->toJSON(), // khusus created_at dan updated_at jika kita tidak konversi ke json akan terkena exception
                        "updated_at" => $category[1]->updated_at->toJSON(),
                    ],
                ]
            ]);

        Log::info(json_encode($category, JSON_PRETTY_PRINT));

        /**
         * result:
         * endpoint: /api/categories
         *  {
         *   data:[
         *          {
         *           id: 11,
         *           name: "Food",
         *           description: "Description Food",
         *           created_at: "2024-06-29T11:11:13.000000Z",
         *           updated_at: "2024-06-29T11:11:13.000000Z"
         *         },
         *         {
         *          id: 12,
         *          name: "Gadget",
         *          description: "Description Gadget",
         *          created_at: "2024-06-29T11:11:13.000000Z",
         *          updated_at: "2024-06-29T11:11:13.000000Z"
         *         },
         *       ],
         *  }
         */

    }




    /**
     * Custom Resource Collection
     * ● Kadang, kita ingin membuat class Resource Collection secara manual, tanpa menggunakan
     *   Resource Class yang sudah kita buat
     * ● Pada kasus ini, kita bisa membuat Resource, namun menggunakan tambahan parameter
     *   --collection :
     *    php artisan make:resource NamaCollection --collection
     * ● Secara otomatis class Resource adalah turunan dari class ResourceCollection
     * ● Untuk mengambil informasi collection nya, kita bisa menggunakan attribute $collection
     */

    public function testResourceCollectionCustomCategories()
    {

        $this->seed([
            CategorySeeder::class
        ]);

        // sql: select * from `categories` where `categories`.`id` = ? limit 1
        $category = Category::all(); // all() // Dapatkan semua model dari database.
        self::assertNotNull($category);

        $this->get("api/categories-custom")
            ->assertStatus(200)
            ->assertJson([
                "total" => 2,
                "data" => [
                    [
                        "id" => $category[0]->id,
                        "name" => $category[0]->name,
                        "description" => $category[0]->description,
                        "created_at" => $category[0]->created_at->toJSON(), // khusus created_at dan updated_at jika kita tidak konversi ke json akan terkena exception
                        "updated_at" => $category[0]->updated_at->toJSON(),
                    ],
                    [
                        "id" => $category[1]->id,
                        "name" => $category[1]->name,
                        "description" => $category[1]->description,
                        "created_at" => $category[1]->created_at->toJSON(), // khusus created_at dan updated_at jika kita tidak konversi ke json akan terkena exception
                        "updated_at" => $category[1]->updated_at->toJSON(),
                    ],
                ]
            ]);

        Log::info(json_encode($category, JSON_PRETTY_PRINT));

        /**
         * result:
         * endpoint: /api/categories
         *  {
         *   data:[
         *          {
         *           id: 11,
         *           name: "Food",
         *           description: "Description Food",
         *           created_at: "2024-06-29T11:11:13.000000Z",
         *           updated_at: "2024-06-29T11:11:13.000000Z"
         *         },
         *         {
         *          id: 12,
         *          name: "Gadget",
         *          description: "Description Gadget",
         *          created_at: "2024-06-29T11:11:13.000000Z",
         *          updated_at: "2024-06-29T11:11:13.000000Z"
         *         },
         *       ],
         *   total: 2,
         *  }
         */

    }




    /**
     * Nested Resource
     * ● Saat kita menggunakan Resource, contoh pada Resource Collection, kita juga bisa menggunakan
     *   Resource lainnya
     * ● Secara default, method toArray() akan dikonversi menjadi JSON
     * ● Namun, kita bisa menggunakan Resource lain jika kita mau
     */

    public function testResourceCollectionNestedCategories()
    {

        $this->seed([
            CategorySeeder::class
        ]);

        // sql: select * from `categories` where `categories`.`id` = ? limit 1
        $category = Category::all(); // all() // Dapatkan semua model dari database.
        self::assertNotNull($category);

        $this->get("api/categories-nested")
            ->assertStatus(200)
            ->assertJson([
//                "total" => 2,
                "data" => [
                    [
                        "id" => $category[0]->id,
                        "name" => $category[0]->name,
                        "description" => $category[0]->description,
                    ],
                    [
                        "id" => $category[1]->id,
                        "name" => $category[1]->name,
                        "description" => $category[1]->description,
                    ],
                ]
            ]);

        Log::info(json_encode($category, JSON_PRETTY_PRINT));

        /**
         * result:
         * endpoint: /api/categories
         *  {
         *   data:[
         *          {
         *           id: 11,
         *           name: "Food",
         *           description: "Description Food",
         *         },
         *         {
         *          id: 12,
         *          name: "Gadget",
         *          description: "Description Gadget",
         *         },
         *       ],
         *   total: 2,
         *  }
         */

    }

}
