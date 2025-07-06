<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParaglidingPackage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ParaglidingPackageSeeder extends Seeder
{
    public function run(): void
    {
        $imageUrls = [
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRxIGb-PoGeyLfiZ02U_GBz-inzPFdsJBchuw&s',
            'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/2b/91/74/33/xc-flying.jpg?w=1000&h=800&s=1',
            'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/2b/91/74/30/flying-in-pokhara.jpg?w=1000&h=800&s=1',
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTRhQ5tnWK1E5F_YSmzDxsN7SV6J3WnfumPxQ&s',
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT5bItw3o1w2moxKkj3VbciuOJe2mEFVKbggQ&s',
        ];

        $packages = [
            [
                'package_name' => 'Paket Sunrise Flight',
                'description' => 'Terbang menikmati matahari terbit dari atas bukit.',
                'duration' => '30 menit',
                'price' => 500000,
                'requirements' => 'Usia minimal 17 tahun, berat maksimal 90kg.',
                'capacity_per_slot' => 2,
                'is_active' => 'active',
            ],
            [
                'package_name' => 'Paket Adventure Flight',
                'description' => 'Terbang lebih lama dan lebih tinggi untuk sensasi petualangan.',
                'duration' => '1 jam',
                'price' => 850000,
                'requirements' => 'Usia minimal 17 tahun, sehat jasmani.',
                'capacity_per_slot' => 3,
                'is_active' => 'active',
            ],
            [
                'package_name' => 'Paket Family Fun',
                'description' => 'Paket santai untuk keluarga dan pemula.',
                'duration' => '20 menit',
                'price' => 350000,
                'requirements' => 'Anak usia 10 tahun ke atas ditemani orang tua.',
                'capacity_per_slot' => 4,
                'is_active' => 'inactive',
            ],
            [
                'package_name' => 'Paket Tandem Extreme',
                'description' => 'Pengalaman ekstrem dengan pilot profesional.',
                'duration' => '45 menit',
                'price' => 900000,
                'requirements' => 'Usia minimal 18 tahun, tidak takut ketinggian.',
                'capacity_per_slot' => 1,
                'is_active' => 'active',
            ],
            [
                'package_name' => 'Paket Sunset Romantic',
                'description' => 'Nikmati matahari terbenam dari udara bersama pasangan.',
                'duration' => '30 menit',
                'price' => 600000,
                'requirements' => 'Pasangan usia 17 tahun ke atas.',
                'capacity_per_slot' => 2,
                'is_active' => 'active',
            ],
        ];

        foreach ($packages as $index => $data) {
            $imageUrl = $imageUrls[$index % count($imageUrls)];
            $response = Http::get($imageUrl);

            if ($response->successful()) {
                $imageContent = $response->body();
                $filename = 'packages/' . Str::random(20) . '.jpg';
                Storage::disk('public')->put($filename, $imageContent);
                $data['image'] = $filename;
            } else {
                $data['image'] = 'packages/default.jpg'; // fallback jika gagal download
            }

            $data['created_at'] = now();
            $data['updated_at'] = now();

            ParaglidingPackage::create($data);
        }
    }
}
