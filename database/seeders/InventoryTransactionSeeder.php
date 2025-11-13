<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\User;

class InventoryTransactionSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        $products = Product::take(10)->get();

        foreach ($products as $p) {
            InventoryTransaction::create([
                'product_id' => $p->id,
                'user_id' => $user->id,
                'type' => 'in',
                'quantity' => rand(1, 20),
                'note' => 'Initial stock via seeder',
            ]);
        }
    }
}
