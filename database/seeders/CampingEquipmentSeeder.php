<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CampingEquipment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CampingEquipmentSeeder extends Seeder
{
    public function run(): void
    {
        $equipments = [
            [
                'equipment_name' => 'Tenda Dome Pro (4 Orang)',
                'category' => 'Tenda',
                'description' => 'Kapasitas: 4 Orang|Tipe: Double Layer|Berat: 4.5 kg',
                'daily_rental_price' => 65000,
                'total_quantity' => 15,
                'available_quantity' => 5,
                'image' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=870',
                'equipment_status' => 'available',
            ],
            [
                'equipment_name' => 'Sleeping Bag Polar',
                'category' => 'Perlengkapan Tidur',
                'description' => 'Suhu Nyaman: 15°C|Bahan: Polar Fleece|Berat: 0.8 kg',
                'daily_rental_price' => 20000,
                'total_quantity' => 10,
                'available_quantity' => 2,
                'image' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=870',
                'equipment_status' => 'available',
            ],
            [
                'equipment_name' => 'Kompor Portable Mini',
                'category' => 'Perlengkapan Masak',
                'description' => 'Bahan Bakar: Gas|Fitur: Windshield|Berat: 0.5 kg',
                'daily_rental_price' => 15000,
                'total_quantity' => 8,
                'available_quantity' => 4,
                'image' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=870',
                'equipment_status' => 'available',
            ],
            [
                'equipment_name' => 'Tenda Ultralight (2 Orang)',
                'category' => 'Tenda',
                'description' => 'Kapasitas: 2 Orang|Tipe: Single Layer|Berat: 1.8 kg',
                'daily_rental_price' => 45000,
                'total_quantity' => 12,
                'available_quantity' => 3,
                'image' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=870',
                'equipment_status' => 'available',
            ],
            [
                'equipment_name' => 'Kursi Lipat Gunung',
                'category' => 'Lainnya',
                'description' => 'Beban Maks: 120 kg|Rangka: Aluminium|Berat: 1.1 kg',
                'daily_rental_price' => 10000,
                'total_quantity' => 10,
                'available_quantity' => 5,
                'image' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=870',
                'equipment_status' => 'available',
            ],
            [
                'equipment_name' => 'Matras Angin Otomatis',
                'category' => 'Perlengkapan Tidur',
                'description' => 'Ketebalan: 5 cm|Fitur: Self-Inflating|Berat: 1.5 kg',
                'daily_rental_price' => 25000,
                'total_quantity' => 7,
                'available_quantity' => 3,
                'image' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=870',
                'equipment_status' => 'available',
            ],
            [
                'equipment_name' => 'Nesting Set (Panci & Piring)',
                'category' => 'Perlengkapan Masak',
                'description' => 'Material: Aluminium|Isi: 4 Pcs|Berat: 0.7 kg',
                'daily_rental_price' => 20000,
                'total_quantity' => 9,
                'available_quantity' => 6,
                'image' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=870',
                'equipment_status' => 'available',
            ],
            [
                'equipment_name' => 'Headlamp LED Terang',
                'category' => 'Lainnya',
                'description' => 'Terang: 300 Lumens|Baterai: AAA x3|Mode: 3 (Terang, Redup, SOS)',
                'daily_rental_price' => 15000,
                'total_quantity' => 6,
                'available_quantity' => 2,
                'image' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=870',
                'equipment_status' => 'available',
            ],
        ];
        foreach ($equipments as $data) {
            // Perbaikan: gunakan key 'image' bukan 'image_url'
            if (!isset($data['image'])) {
                continue;
            }

            $imageContents = Http::get($data['image'])->body();

            $filename = 'equipment/' . Str::random(20) . '.jpg';
            Storage::disk('public')->put($filename, $imageContents);

            CampingEquipment::create([
                'equipment_name' => $data['equipment_name'],
                'category' => $data['category'],
                'description' => $data['description'],
                'daily_rental_price' => $data['daily_rental_price'],
                'total_quantity' => $data['total_quantity'],
                'available_quantity' => $data['available_quantity'],
                'image' => $filename, // Simpan path lokal
                'equipment_status' => $data['equipment_status'],
            ]);
        }
    }
}
