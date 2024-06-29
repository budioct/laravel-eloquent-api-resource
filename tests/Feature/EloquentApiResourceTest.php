<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EloquentApiResourceTest extends TestCase
{
    /**
     * Pengenalan
     *
     * Eloquent API Resource
     * ● Di kelas Laravel Eloquent, kita sudah belajar bagaimana cara melakukan proses Serialization untuk
     *   mengubah object Model menjadi data Array / JSON
     * ● Namun pada kasus tertentu, kita sering membuat jenis format Array / JSON yang berbeda-beda
     *   menggunakan Model yang sama
     * ● Atau misal menggunakan attribute yang berbeda antara Array / JSON, dan attribute yang terdapat di Model
     * ● Eloquent memiliki fitur bernama API Resource, yang bisa digunakan untuk melakukan
     *   transformasi dari data Model menjadi Array
     *
     * Membuat Model
     * ● Buatlah model Category dan Product, dimana Category memiliki relasi one to many ke Product
     * // buat model, migration, seed
     * php artisan make:model Category --migration --seed
     *
     * // setup migration Category
     * php artisan migrate
     *
     * // setup model Category
     */

    public function testTrue(){
        self::assertTrue(true);
    }
}
