<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $adminRole = Role::where('name','Admin')->first();

        if (!$adminRole) {
            $this->command->info('Admin role not found, creating roles via RoleSeeder first.');
            $this->call(RoleSeeder::class);
            $adminRole = Role::where('name','Admin')->first();
        }

        // buat user admin default jika belum ada
        if (!User::where('email','admin@example.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password123'), // ganti sebelum submit tugas
                'role_id' => $adminRole->id,
            ]);
        }
    }
}
