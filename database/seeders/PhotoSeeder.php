<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PhotoSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $merchant1 = DB::table('m_merchant')->where('name', 'Tasty Corner')->value('id');
        $merchant2 = DB::table('m_merchant')->where('name', 'City Fun Park')->value('id');

        $place1 = DB::table('m_place')->where('name', 'Tasty Corner - Main Hall')->value('id');
        $place2 = DB::table('m_place')->where('name', 'Tasty Corner - Rooftop')->value('id');
        $place3 = DB::table('m_place')->where('name', 'City Fun Park - Arena')->value('id');

        $merchantPhotos = [
            ['id' => (string) Str::uuid(), 'm_merchant_id' => $merchant1, 'photo_url' => 'https://picsum.photos/seed/merchant1a/800/600', 'sequence' => 1],
            ['id' => (string) Str::uuid(), 'm_merchant_id' => $merchant1, 'photo_url' => 'https://picsum.photos/seed/merchant1b/800/600', 'sequence' => 2],
            ['id' => (string) Str::uuid(), 'm_merchant_id' => $merchant2, 'photo_url' => 'https://picsum.photos/seed/merchant2a/800/600', 'sequence' => 1],
        ];

        $placePhotos = [
            ['id' => (string) Str::uuid(), 'm_place_id' => $place1, 'photo_url' => 'https://picsum.photos/seed/place1a/800/600', 'sequence' => 1],
            ['id' => (string) Str::uuid(), 'm_place_id' => $place1, 'photo_url' => 'https://picsum.photos/seed/place1b/800/600', 'sequence' => 2],
            ['id' => (string) Str::uuid(), 'm_place_id' => $place2, 'photo_url' => 'https://picsum.photos/seed/place2a/800/600', 'sequence' => 1],
            ['id' => (string) Str::uuid(), 'm_place_id' => $place3, 'photo_url' => 'https://picsum.photos/seed/place3a/800/600', 'sequence' => 1],
        ];

        foreach ($merchantPhotos as $row) {
            DB::table('c_merchant_photo')->updateOrInsert(
                ['m_merchant_id' => $row['m_merchant_id'], 'sequence' => $row['sequence']],
                $row + ['created_at' => $now, 'updated_at' => $now, 'deleted_at' => null]
            );
        }

        foreach ($placePhotos as $row) {
            DB::table('c_place_photo')->updateOrInsert(
                ['m_place_id' => $row['m_place_id'], 'sequence' => $row['sequence']],
                $row + ['created_at' => $now, 'updated_at' => $now, 'deleted_at' => null]
            );
        }
    }
}
