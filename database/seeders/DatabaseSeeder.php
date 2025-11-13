<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            \Database\Seeders\RoleSeeder::class,
            \Database\Seeders\UserSeeder::class,
            \Database\Seeders\CategorySeeder::class,
            \Database\Seeders\ProductSeeder::class,
            // optional: InventoryTransactionSeeder
            // \Database\Seeders\InventoryTransactionSeeder::class,
        ]);
    }
}
