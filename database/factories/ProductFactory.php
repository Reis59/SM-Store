<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Faker untuk menghasilkan nama barang acak
        $name = $this->faker->unique()->words(3, true); 

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name).'-'.Str::random(5), // Membuat slug unik dengan tambahan random string
            'description' => $this->faker->paragraph(3),
            'price' => $this->faker->numberBetween(10000, 5000000), // Harga antara Rp 10.000 s/d Rp 5.000.000
            'stock' => $this->faker->numberBetween(5, 100),
            'image' => 'products/default.jpg', // Placeholder image path
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
