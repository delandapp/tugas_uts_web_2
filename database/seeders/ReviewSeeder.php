<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $user1 = DB::table('users')->where('email', 'user1@example.com')->value('id');
        $user2 = DB::table('users')->where('email', 'user2@example.com')->value('id');

        $place1 = DB::table('m_place')->where('name', 'Tasty Corner - Main Hall')->value('id');
        $place2 = DB::table('m_place')->where('name', 'Tasty Corner - Rooftop')->value('id');
        $place3 = DB::table('m_place')->where('name', 'City Fun Park - Arena')->value('id');

        $reviews = [
            ['id' => (string) Str::uuid(), 'm_users_id' => $user1, 'm_place_id' => $place1, 'rating' => 5, 'comment' => 'Great food and fast service!', 'photo_url' => null, 'status' => 'published'],
            ['id' => (string) Str::uuid(), 'm_users_id' => $user2, 'm_place_id' => $place1, 'rating' => 4, 'comment' => 'Nice ambience.', 'photo_url' => null, 'status' => 'published'],
            ['id' => (string) Str::uuid(), 'm_users_id' => $user1, 'm_place_id' => $place2, 'rating' => 4, 'comment' => 'Rooftop view is amazing.', 'photo_url' => null, 'status' => 'published'],
            ['id' => (string) Str::uuid(), 'm_users_id' => $user2, 'm_place_id' => $place3, 'rating' => 5, 'comment' => 'Kids loved it!', 'photo_url' => null, 'status' => 'published'],
        ];

        foreach ($reviews as $r) {
            DB::table('c_review')->updateOrInsert(
                ['m_users_id' => $r['m_users_id'], 'm_place_id' => $r['m_place_id']],
                $r + ['created_at' => $now, 'updated_at' => $now, 'deleted_at' => null]
            );
        }

        // Recalculate aggregates on m_place
        $aggregates = DB::table('c_review')
            ->select('m_place_id', DB::raw('AVG(rating) as avg_rating'), DB::raw('COUNT(*) as review_count'))
            ->where('status', 'published')
            ->groupBy('m_place_id')
            ->get();

        foreach ($aggregates as $agg) {
            DB::table('m_place')
                ->where('id', $agg->m_place_id)
                ->update([
                    'avg_rating' => round($agg->avg_rating, 2),
                    'review_count' => (int) $agg->review_count,
                    'updated_at' => now(),
                ]);
        }
    }
}
