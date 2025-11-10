<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $rows = [
            ['id' => (string) Str::uuid(), 'name' => 'Food & Beverage', 'icon' => 'utensils'],
            ['id' => (string) Str::uuid(), 'name' => 'Lodging',         'icon' => 'hotel'],
            ['id' => (string) Str::uuid(), 'name' => 'Attractions',     'icon' => 'map-pin'],
        ];

        foreach ($rows as $row) {
            DB::table('m_category')->updateOrInsert(
                ['name' => $row['name']],
                $row + ['created_at' => $now, 'updated_at' => $now, 'deleted_at' => null]
            );
        }
    }
}
