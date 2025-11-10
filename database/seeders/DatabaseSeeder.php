<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            MerchantSeeder::class,
            PlaceSeeder::class,
            PhotoSeeder::class,
            PromoSeeder::class,
            ReviewSeeder::class, // keep last to recalc aggregates
        ]);
    }
}
