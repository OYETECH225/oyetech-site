<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        // Membres réels uniquement (photo et LinkedIn à compléter dans l'admin).
        $members = [
            ['name' => 'Yamoussa KOUYATE', 'role' => 'Fondateur & DG', 'order' => 1],
        ];

        foreach ($members as $member) {
            TeamMember::updateOrCreate(['name' => $member['name']], $member);
        }
    }
}
