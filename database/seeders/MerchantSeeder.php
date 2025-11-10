<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MerchantSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $ownerId = DB::table('users')->where('email', 'merchant@example.com')->value('id');
        $foodCat = DB::table('m_category')->where('name', 'Food & Beverage')->value('id');
        $attrCat = DB::table('m_category')->where('name', 'Attractions')->value('id');

        $merchants = [
            [
                'id' => (string) Str::uuid(),
                'm_users_id' => $ownerId,
                'm_category_id' => $foodCat,
                'name' => 'Tasty Corner',
                'address' => '123 Market Street',
                'lat' => -6.2000000,
                'lng' => 106.8166667,
                'open_hours' => 'Mon-Sun 09:00–21:00',
                'whatsapp_number' => '+628123456789',
                'status' => 'active',
            ],
            [
                'id' => (string) Str::uuid(),
                'm_users_id' => $ownerId,
                'm_category_id' => $attrCat,
                'name' => 'City Fun Park',
                'address' => '88 Leisure Ave',
                'lat' => -6.1751100,
                'lng' => 106.8650395,
                'open_hours' => 'Daily 10:00–20:00',
                'whatsapp_number' => '+628987654321',
                'status' => 'active',
            ],
        ];

        foreach ($merchants as $m) {
            DB::table('m_merchant')->updateOrInsert(
                ['name' => $m['name']],
                $m + ['created_at' => $now, 'updated_at' => $now, 'deleted_at' => null]
            );
        }
    }
}
