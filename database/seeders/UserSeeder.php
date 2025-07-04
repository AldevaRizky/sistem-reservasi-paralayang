<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // === PENGGUNA ADMIN ===
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        $admin->detail()->create([
            'full_name' => $admin->name,
            'is_active' => 'active',
        ]);

        // === PENGGUNA BIASA ===
        $user = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
        $user->detail()->create([
            'full_name' => $user->name,
            'is_active' => 'active',
        ]);

        // === BEBERAPA PENGGUNA STAF (INI BAGIAN PENTING) ===
        $staffs = [
            ['name' => 'Budi Tandem', 'email' => 'budi@example.com'],
            ['name' => 'Citra Pilot', 'email' => 'citra@example.com'],
            ['name' => 'Dedi Angkasa', 'email' => 'dedi@example.com'],
        ];

        foreach ($staffs as $staffData) {
            $staffUser = User::create([
                'name' => $staffData['name'],
                'email' => $staffData['email'],
                'password' => Hash::make('password'),
                'role' => 'staff',
            ]);
            $staffUser->detail()->create([
                'full_name' => $staffUser->name,
                'is_active' => 'active',
            ]);
        }
    }
}
