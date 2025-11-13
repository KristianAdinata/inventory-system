<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\User;

class InventoryTransactionFactory extends Factory
{
    protected $model = InventoryTransaction::class;

    public function definition()
    {
        $type = $this->faker->randomElement(['in','out']);
        $qty = $this->faker->numberBetween(1, 20);
        return [
            'product_id' => Product::inRandomOrder()->value('id') ?? Product::factory(),
            'user_id' => User::inRandomOrder()->value('id') ?? User::factory(),
            'type' => $type,
            'quantity' => $qty,
            'note' => $this->faker->optional()->sentence(),
        ];
    }
}