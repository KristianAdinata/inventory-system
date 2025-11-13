<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Category;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        // pick random category id if exists
        $categoryId = Category::inRandomOrder()->value('id') ?? null;

        return [
            'name' => ucfirst($this->faker->words(3, true)),
            'sku' => strtoupper($this->faker->unique()->bothify('SKU-???-####')),
            'category_id' => $categoryId,
            'stock' => $this->faker->numberBetween(0, 200),
            'price' => $this->faker->randomFloat(2, 5, 2000),
            'description' => $this->faker->sentence(10),
            'image_path' => null,
        ];
    }
}
