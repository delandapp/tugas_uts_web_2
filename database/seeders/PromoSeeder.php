<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $merchant1 = DB::table('m_merchant')->where('name', 'Tasty Corner')->value('id');
        $merchant2 = DB::table('m_merchant')->where('name', 'City Fun Park')->value('id');

        $promos = [
            [
                'id' => (string) Str::uuid(),
                'm_merchant_id' => $merchant1,
                'title' => 'Lunch Combo Discount',
                'description' => 'Save 20% for lunch menu 11:00–14:00.',
                'starts_at' => $now->copy()->subDays(2),
                'ends_at' => $now->copy()->addDays(10),
                'active' => true,
            ],
            [
                'id' => (string) Str::uuid(),
                'm_merchant_id' => $merchant2,
                'title' => 'Weekend Family Pack',
                'description' => 'Bundle tickets for 4 at special price.',
                'starts_at' => $now->copy()->subWeek(),
                'ends_at' => $now->copy()->addWeeks(2),
                'active' => true,
            ],
        ];

        foreach ($promos as $p) {
            DB::table('c_promo')->updateOrInsert(
                ['m_merchant_id' => $p['m_merchant_id'], 'title' => $p['title']],
                $p + ['created_at' => now(), 'updated_at' => now(), 'deleted_at' => null]
            );
        }
    }
}
