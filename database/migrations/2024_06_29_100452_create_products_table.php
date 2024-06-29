<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable(false);
            $table->bigInteger('price')->nullable(false)->default(0);
            $table->integer('stock')->nullable(false)->default(0);
            $table->unsignedBigInteger("category_id")->nullable(false);
            $table->timestamps();
            $table->foreign('category_id')->on("categories")->references('id'); // CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)

            /**
             * show create table
             *
             * CREATE TABLE `products` (
             * `id` bigint unsigned NOT NULL AUTO_INCREMENT,
             * `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
             * `price` bigint NOT NULL DEFAULT '0',
             * `stock` int NOT NULL DEFAULT '0',
             * `category_id` bigint unsigned NOT NULL,
             * `created_at` timestamp NULL DEFAULT NULL,
             * `updated_at` timestamp NULL DEFAULT NULL,
             * PRIMARY KEY (`id`),
             * KEY `products_category_id_foreign` (`category_id`),
             * CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
             * ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
             */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
