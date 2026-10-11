<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Refonte du site web CFTS Group',
                'slug' => 'refonte-site-web-cfts-group',
                'pole' => 'solutions',
                'client' => 'CFTS Group — siège à Dakar (Sénégal)',
                'sector' => 'Distribution industrielle (agriculture, hydraulique, assainissement, BTP)',
                'challenge' => 'CFTS Group, groupe industriel basé à Dakar avec des filiales dans 5 pays d\'Afrique de l\'Ouest, avait besoin d\'un site vitrine régional pour présenter son catalogue de plus de 200 produits techniques et son implantation multi-pays aux États, institutions et professionnels du secteur.',
                'solution' => 'Conception et développement d\'une plateforme web sur mesure : catalogue produits par secteur, cartographie de l\'implantation régionale, mise en avant des réalisations et partenaires, et demande de devis en ligne.',
                'results' => 'Projet livré, résultats en cours de mesure.',
                'is_featured' => true,
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(['slug' => $project['slug']], $project);
        }
    }
}
