<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            ['name' => 'Kouamé Oyetech', 'role' => 'Fondateur & CEO', 'bio' => 'Plus de 15 ans d\'expérience en stratégie digitale en Afrique de l\'Ouest.', 'order' => 1],
            ['name' => 'Aminata Sylla', 'role' => 'Directrice Conseil & Stratégie', 'bio' => 'Experte en transformation organisationnelle et gouvernance digitale.', 'order' => 2],
            ['name' => 'David Traoré', 'role' => 'Directeur Technique', 'bio' => 'Architecte logiciel, pilote l\'ensemble des solutions numériques d\'OYETECH.', 'order' => 3],
            ['name' => 'Marie-Claire N\'Guessan', 'role' => 'Directrice Communication', 'bio' => 'Spécialiste de la stratégie de marque et des campagnes 360°.', 'order' => 4],
        ];

        foreach ($members as $member) {
            TeamMember::updateOrCreate(['name' => $member['name']], $member);
        }
    }
}
