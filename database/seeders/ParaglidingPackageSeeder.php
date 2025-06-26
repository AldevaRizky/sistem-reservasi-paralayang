<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParaglidingPackage;

class ParaglidingPackageSeeder extends Seeder
{
    public function run(): void
    {
        ParaglidingPackage::insert([
            [
                'package_name' => 'Paket Sunrise Flight',
                'description' => 'Terbang menikmati matahari terbit dari atas bukit.',
                'duration' => '30 menit',
                'price' => 500000,
                'requirements' => 'Usia minimal 17 tahun, berat maksimal 90kg.',
                'capacity_per_slot' => 2,
                'image' => 'sunrise.jpg',
                'is_active' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'package_name' => 'Paket Adventure Flight',
                'description' => 'Terbang lebih lama dan lebih tinggi untuk sensasi petualangan.',
                'duration' => '1 jam',
                'price' => 850000,
                'requirements' => 'Usia minimal 17 tahun, sehat jasmani.',
                'capacity_per_slot' => 3,
                'image' => 'adventure.jpg',
                'is_active' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'package_name' => 'Paket Family Fun',
                'description' => 'Paket santai untuk keluarga dan pemula.',
                'duration' => '20 menit',
                'price' => 350000,
                'requirements' => 'Anak usia 10 tahun ke atas ditemani orang tua.',
                'capacity_per_slot' => 4,
                'image' => 'family.jpg',
                'is_active' => 'inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
