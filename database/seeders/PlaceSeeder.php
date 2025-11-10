<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PlaceSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $merchant1 = DB::table('m_merchant')->where('name', 'Tasty Corner')->first();
        $merchant2 = DB::table('m_merchant')->where('name', 'City Fun Park')->first();

        $foodCat = DB::table('m_category')->where('name', 'Food & Beverage')->value('id');
        $attrCat = DB::table('m_category')->where('name', 'Attractions')->value('id');

        $places = [
            [
                'id' => (string) Str::uuid(),
                'm_merchant_id' => $merchant1->id,
                'm_category_id' => $foodCat,
                'name' => 'Tasty Corner - Main Hall',
                'address' => 'Block A, 123 Market Street',
                'lat' => -6.2001000,
                'lng' => 106.8168000,
                'avg_rating' => 0.00,
                'review_count' => 0,
            ],
            [
                'id' => (string) Str::uuid(),
                'm_merchant_id' => $merchant1->id,
                'm_category_id' => $foodCat,
                'name' => 'Tasty Corner - Rooftop',
                'address' => 'Roof, 123 Market Street',
                'lat' => -6.2002000,
                'lng' => 106.8169000,
                'avg_rating' => 0.00,
                'review_count' => 0,
            ],
            [
                'id' => (string) Str::uuid(),
                'm_merchant_id' => $merchant2->id,
                'm_category_id' => $attrCat,
                'name' => 'City Fun Park - Arena',
                'address' => '88 Leisure Ave, Gate 2',
                'lat' => -6.1752000,
                'lng' => 106.8651000,
                'avg_rating' => 0.00,
                'review_count' => 0,
            ],
        ];

        foreach ($places as $p) {
            DB::table('m_place')->updateOrInsert(
                ['name' => $p['name']],
                $p + ['created_at' => $now, 'updated_at' => $now, 'deleted_at' => null]
            );
        }
    }
}
