<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $adminRole = Role::where('name', 'Admin')->first();
        $userRole = Role::where('name', 'User')->first();

        // Default Admin
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'), // ganti sebelum submit tugas kalau perlu
                'role_id' => $adminRole? $adminRole->id : null,
                'email_verified_at' => now(),
            ]
        );

        // Sample normal user
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Sample User',
                'password' => Hash::make('password123'),
                'role_id' => $userRole? $userRole->id : null,
                'email_verified_at' => now(),
            ]
        );
    }
}
