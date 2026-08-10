<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créé directement (pas via User::factory()) : la factory appelle fake()
        // qui dépend de fakerphp/faker, une dépendance dev absente en production
        // (composer install --no-dev), ce qui fait planter le seed en prod.
        User::updateOrCreate(
            ['email' => 'admin@oyetech-ci.com'],
            [
                'name' => 'OYETECH Admin',
                'email_verified_at' => now(),
                'password' => Hash::make(env('ADMIN_SEED_PASSWORD', 'password')),
            ]
        );

        $this->call([
            ServiceSeeder::class,
            ProjectSeeder::class,
            ArticleSeeder::class,
            TestimonialSeeder::class,
            TeamMemberSeeder::class,
            ClientSeeder::class,
        ]);
    }
}
