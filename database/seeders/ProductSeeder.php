<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Buat 30 produk random via factory
        Product::factory()->count(30)->create();

        // Atau tambahkan produk manual
        Product::firstOrCreate(
            ['sku' => 'SKU-DEFAULT-0001'],
            [
                'name' => 'Laptop Contoh',
                'category_id' => null,
                'stock' => 10,
                'price' => 7000000,
                'description' => 'Contoh produk untuk demo.',
            ]
        );
    }
}
