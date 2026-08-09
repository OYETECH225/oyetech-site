<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Pourquoi la transformation digitale en Afrique de l\'Ouest doit partir de la stratégie',
                'slug' => 'transformation-digitale-afrique-ouest-strategie',
                'category' => 'Stratégie',
                'excerpt' => 'Trop d\'organisations digitalisent sans vision claire. Voici pourquoi la stratégie doit précéder la technologie.',
                'content' => '<p>La transformation digitale ne se résume pas à l\'adoption d\'outils. Elle commence par une vision stratégique claire, alignée sur les réalités des marchés ouest-africains...</p>',
                'is_published' => true,
                'published_at' => now()->subDays(20),
            ],
            [
                'title' => 'Mobile money et paiement digital : les tendances 2026 en Afrique de l\'Ouest',
                'slug' => 'mobile-money-paiement-digital-tendances-2026',
                'category' => 'Fintech',
                'excerpt' => 'Le paiement digital connaît une croissance soutenue. Tour d\'horizon des tendances qui façonnent le secteur.',
                'content' => '<p>L\'adoption du mobile money continue de progresser fortement en Afrique de l\'Ouest, portée par une jeunesse connectée et des besoins d\'inclusion financière...</p>',
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => '5 leviers pour réduire son coût d\'acquisition client en ligne',
                'slug' => 'leviers-reduire-cout-acquisition-client-ligne',
                'category' => 'Marketing',
                'excerpt' => 'Optimiser son funnel d\'acquisition digitale ne nécessite pas toujours plus de budget, mais plus de précision.',
                'content' => '<p>Réduire son coût d\'acquisition passe avant tout par une meilleure connaissance de son audience et une allocation budgétaire pilotée par la donnée...</p>',
                'is_published' => true,
                'published_at' => now()->subDays(3),
            ],
        ];

        foreach ($articles as $article) {
            Article::updateOrCreate(['slug' => $article['slug']], $article);
        }
    }
}
