<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
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




    /**
     * Data Wrap
     * ● Secara default, data JSON yang dibuat oleh Resource akan disimpan dalam attribute “data”
     * ● Jika kita ingin menggantinya, kita bisa ubah attribute $wrap di Resource dengan nama attribute
     *   yang kita mau
     * ● Secara default, jika dalam toArray() kita mengembalikan array yang terdapat attribute sama
     *   dengan $wrap, maka data JSON tidak akan di wrap
     */

    public function testResourceProductDataWrapCategory()
    {

        $this->seed([
            CategorySeeder::class,
            ProductSeeder::class
        ]);

        // sql: select * from `products` where `products`.`id` = ? limit 1
        $product = Product::query()->first(); // first // Dapatkan 1 data acak
        self::assertNotNull($product);

        $this->get("api/product/$product->id")
            ->assertStatus(200)
            ->assertJson([
                "wrap_custom" => [
                    "id" => $product->id,
                    "name" => $product->name,
                    "category" => [
                        "id" => $product->category->id,
                        "name" => $product->category->name,
                        "description" => $product->category->description,
                    ],
                    "price" => $product->price,
                    "stock" => $product->stock,
                    "created_at" => $product->created_at->toJSON(),
                    "updated_at" => $product->updated_at->toJSON(),
                ]
            ]);

        Log::info(json_encode($product, JSON_PRETTY_PRINT));

        /**
         * result:
         * endpoint: /api/product/{id}
         *
         * // versi tampilan log
         * {
         *   "id": 21,
         *   "name": "Product 0 of 47",
         *   "price": 902,
         *   "stock": 46,
         *   "category_id": 47,
         *   "created_at": "2024-06-29T14:36:47.000000Z",
         *   "updated_at": "2024-06-29T14:36:47.000000Z",
         *   "category": {
         *       "id": 47,
         *       "name": "Food",
         *       "description": "Description Food",
         *       "created_at": "2024-06-29T14:36:47.000000Z",
         *       "updated_at": "2024-06-29T14:36:47.000000Z"
         *     }
         * }
         *
         *  // versi tampilan JSON
         *  {
         *    wrap_custom: {
         *                  "id": 1,
         *                  "name": "Product 0 of 43",
         *                  "category" : {
         *                      "id": 43,
         *                      "name": "Food",
         *                      "description": "Description Food"
         *                  }
         *                  "price": 552,
         *                  "stock": 56,
         *                  "created_at": "2024-06-29T14:21:45.000000Z",
         *                   "updated_at": "2024-06-29T14:21:45.000000Z"
         *               }
         *  }
         */

    }




    /**
     * Data Wrap Collection
     * ● Khusus untuk mengubah attribute $wrap untuk Collection, kita tidak bisa menggunakan
     *   NamaResource::collection(), hal ini karena kode tersebut sebenarnya akan membuat object
     *   AnonymousResourceCollection, bukan menggunakan Resource yang kita buat
     * ● https://laravel.com/api/10.x/Illuminate/Http/Resources/Json/AnonymousResourceCollection.html
     * ● Jika hasil result JSON di ResourceCollection.toArray() mengandung attribute yang terdapat di
     *   $wrap, maka Laravel tidak akan melakukan wrap, namun jika tidak ada, maka akan melakukan wrap
     */

    public function testResourceCollectionProductWrap()
    {

        $this->seed([
            CategorySeeder::class,
            ProductSeeder::class
        ]);

        $response = $this->get('/api/products')
            ->assertStatus(200);

        Log::info(json_encode($response, JSON_PRETTY_PRINT));

        /**
         * result:
         * endpoint: /api/products
         */

    }




    /**
     * Pagination
     * ● Jika kita mengirim data Pagination ke dalam Resource Collection, secara otomatis Laravel akan
     *   menambahkan informasi link dan juga meta (paging) secara otomatis
     * ● Attribute links berisi informasi link menuju page sebelum dan setelahnya
     * ● Attribute meta berisi informasi paging
     */

    public function testResourceCollectionProductPaging()
    {

        $this->seed([
            CategorySeeder::class,
            ProductSeeder::class
        ]);

        $response = $this->get('/api/products-paging')
            ->assertStatus(200);

        self::assertNotNull($response->json("links"));
        self::assertNotNull($response->json("meta"));
        self::assertNotNull($response->json("data"));

        Log::info(json_encode($response, JSON_PRETTY_PRINT));

        /**
         * result:
         * endpoint: /api/products-paging
         *
         * {
         * "baseResponse": {
         * "headers": {},
         * "original": [
         * {
         * "id": 121,
         * "name": "Product 0 of 67",
         * "price": 166,
         * "stock": 29,
         * "category_id": 67,
         * "created_at": "2024-06-29T15:22:26.000000Z",
         * "updated_at": "2024-06-29T15:22:26.000000Z",
         * "category": {
         * "id": 67,
         * "name": "Food",
         * "description": "Description Food",
         * "created_at": "2024-06-29T15:22:26.000000Z",
         * "updated_at": "2024-06-29T15:22:26.000000Z"
         * }
         * },
         * {
         * "id": 122,
         * "name": "Product 1 of 67",
         * "price": 770,
         * "stock": 79,
         * "category_id": 67,
         * "created_at": "2024-06-29T15:22:26.000000Z",
         * "updated_at": "2024-06-29T15:22:26.000000Z",
         * "category": {
         * "id": 67,
         * "name": "Food",
         * "description": "Description Food",
         * "created_at": "2024-06-29T15:22:26.000000Z",
         * "updated_at": "2024-06-29T15:22:26.000000Z"
         * }
         * }
         * ],
         * "exception": null
         * },
         * "exceptions": []
         * }
         */

    }

}
