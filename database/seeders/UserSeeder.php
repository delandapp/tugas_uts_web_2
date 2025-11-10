<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::query()->firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'email' => 'admin@example.com',
            ]
        );
        $admin->assignRole('admin');

        // Merchant owner
        $merchantOwner = User::query()->firstOrCreate(
            ['email' => 'merchant@example.com'],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Merchant Owner',
                'password' => Hash::make('password'),
                'email' => 'merchant@example.com',
            ]
        );
        $merchantOwner->assignRole('merchant');

        // End users
        $u1 = User::query()->firstOrCreate(
            ['email' => 'user1@example.com'],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Alice Customer',
                'password' => Hash::make('password'),
                'email' => 'user1@example.com',
            ]
        );
        $u1->assignRole('user');

        $u2 = User::query()->firstOrCreate(
            ['email' => 'user2@example.com'],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Bob Customer',
                'password' => Hash::make('password'),
                'email' => 'user2@example.com',
            ]
        );
        $u2->assignRole('user');
    }
}
