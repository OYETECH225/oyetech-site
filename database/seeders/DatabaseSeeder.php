<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'OYETECH Admin',
            'email' => 'admin@oyetech.ci',
        ]);

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
