<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Conseil & Stratégie',
                'slug' => 'conseil-strategie',
                'pole' => 'conseil',
                'icon' => 'heroicon-o-light-bulb',
                'summary' => 'Cabinet stratégique pour accompagner la transformation digitale des organisations en Afrique de l\'Ouest.',
                'description' => 'OYETECH accompagne dirigeants et institutions dans la définition de leur stratégie digitale, l\'audit organisationnel et la conduite du changement, avec une connaissance fine des marchés ouest-africains.',
                'deliverables' => ['Stratégie marketing', 'Branding', 'Transformation digitale', 'Pilotage de projets'],
                'order' => 1,
            ],
            [
                'name' => 'Communication & Publicité',
                'slug' => 'communication-publicite',
                'pole' => 'communication',
                'icon' => 'heroicon-o-megaphone',
                'summary' => 'Stratégies de marque et campagnes publicitaires à fort impact, du brief à la diffusion.',
                'description' => 'De l\'identité de marque aux campagnes 360°, notre pôle communication conçoit des dispositifs qui marquent les esprits et installent durablement la notoriété de nos clients.',
                'deliverables' => ['Stratégie de communication', 'Création de campagnes', 'Branding', 'Media planning', 'Production'],
                'order' => 2,
            ],
            [
                'name' => 'Marketing Digital',
                'slug' => 'marketing-digital',
                'pole' => 'marketing',
                'icon' => 'heroicon-o-chart-bar',
                'summary' => 'Acquisition, conversion et fidélisation pilotées par la donnée.',
                'description' => 'Nous concevons et pilotons des stratégies d\'acquisition digitale (SEO, SEA, social ads) mesurables et orientées performance, avec un reporting précis et actionnable.',
                'deliverables' => ['Social media', 'Performance marketing', 'SEO', 'Publicité en ligne', 'Analytics (GA4, GTM, Pixels)'],
                'order' => 3,
            ],
            [
                'name' => 'Solutions Numériques',
                'slug' => 'solutions-numeriques',
                'pole' => 'solutions',
                'icon' => 'heroicon-o-code-bracket',
                'summary' => 'Conception de plateformes web, mobiles et automatisations intelligentes sur mesure.',
                'description' => 'Notre pôle technique conçoit des sites, applications et plateformes robustes, sécurisées et évolutives, taillées pour les besoins spécifiques des entreprises africaines.',
                'deliverables' => ['Développement web', 'Applications mobiles', 'Plateformes SaaS', 'Intégration API', 'Automatisation IA', 'Fintech', 'Installation réseau d\'entreprise'],
                'order' => 4,
            ],
            [
                'name' => 'Ilepay',
                'slug' => 'ilepay',
                'pole' => 'ilepay',
                'icon' => 'heroicon-o-credit-card',
                'summary' => 'Solution digitale de paiement développée par OYETECH pour simplifier les paiements du quotidien, à commencer par le paiement de loyer.',
                'description' => 'Ilepay est une solution digitale de paiement développée par OYETECH, pensée pour simplifier les paiements du quotidien. Son premier usage est centré sur le paiement de loyer, avec une expérience simple, rapide et sécurisée permettant aux utilisateurs d\'effectuer leurs paiements en ligne. Ilepay a vocation à évoluer progressivement pour faciliter d\'autres types de paiements et de services financiers du quotidien, tout en proposant une gestion centralisée des transactions et des justificatifs.',
                'deliverables' => ['Paiement de loyer en ligne', 'Gestion des contrats de location', 'Suivi propriétaires & locataires', 'Gestion centralisée des transactions & justificatifs'],
                'order' => 5,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }
    }
}
