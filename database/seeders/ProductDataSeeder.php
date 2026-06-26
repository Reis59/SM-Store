<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Definisikan 5 kategori e-commerce
        $categories = [
            'Elektronik',
            'Pakaian Pria',
            'Pakaian Wanita',
            'Kesehatan & Kecantikan',
            'Buku & Alat Tulis'
        ];

        // 2. Looping kategori, simpan ke database, lalu buat produknya
        foreach ($categories as $categoryName) {
            $category = ProductCategory::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
            ]);

            // 3. Buat 10 produk untuk kategori yang sedang aktif saat ini
            Product::factory()
                ->count(10)
                ->create([
                    'product_category_id' => $category->id, // Mengunci foreign key ke kategori ini
                ]);
        }
    }
}
