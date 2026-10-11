<?php

use App\Models\Project;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Supprime les 4 études de cas fictives du seeder initial (clients anonymisés,
 * résultats chiffrés non vérifiables). Seule la mission CFTS Group est réelle.
 * Suppression via Eloquent pour retirer aussi les médias (couvertures).
 * down() recrée les fiches texte (sans les images).
 */
return new class extends Migration
{
    private const SLUGS = [
        'campagne-notoriete-made-in-ci',
        'acquisition-digitale-fintech-regionale',
        'plateforme-ecommerce-distributeur-regional',
        'digitalisation-gestion-locative-agence-immobiliere',
    ];

    public function up(): void
    {
        Project::whereIn('slug', self::SLUGS)->get()->each->delete();
    }

    public function down(): void
    {
        $projects = [
                [
                    'title' => 'Campagne de notoriété "Made in CI"',
                    'slug' => 'campagne-notoriete-made-in-ci',
                    'pole' => 'communication',
                    'client' => 'Groupe agro-industriel ivoirien',
                    'sector' => 'Agro-industrie',
                    'challenge' => 'Renforcer la notoriété d\'un acteur agro-industriel auprès du grand public et valoriser la production locale.',
                    'solution' => 'Conception d\'une identité de campagne forte, production audiovisuelle et déploiement multicanal (TV, digital, affichage) sur 6 mois.',
                    'results' => 'Notoriété spontanée de la marque en hausse de 28%, plus de 2M de vues sur les contenus digitaux.',
                    'is_featured' => true,
                ],
                [
                    'title' => 'Acquisition digitale pour une fintech régionale',
                    'slug' => 'acquisition-digitale-fintech-regionale',
                    'pole' => 'marketing',
                    'client' => 'Fintech régionale',
                    'sector' => 'Services financiers',
                    'challenge' => 'Accélérer l\'acquisition d\'utilisateurs sur un marché concurrentiel avec un budget média maîtrisé.',
                    'solution' => 'Stratégie SEA et social ads ciblée, mise en place d\'un funnel de conversion et automatisation du nurturing par email.',
                    'results' => 'Coût d\'acquisition réduit de 40%, +18 000 nouveaux utilisateurs en 6 mois.',
                    'is_featured' => true,
                ],
                [
                    'title' => 'Plateforme e-commerce pour distributeur régional',
                    'slug' => 'plateforme-ecommerce-distributeur-regional',
                    'pole' => 'solutions',
                    'client' => 'Distributeur régional',
                    'sector' => 'Distribution',
                    'challenge' => 'Digitaliser un réseau de distribution physique et proposer une expérience d\'achat en ligne fiable à grande échelle.',
                    'solution' => 'Développement d\'une plateforme e-commerce sur mesure avec gestion multi-entrepôts, paiement intégré et application de suivi de commande.',
                    'results' => 'Mise en ligne en 4 mois, 99,9% de disponibilité, +60% de ventes en ligne dès le premier trimestre.',
                    'is_featured' => true,
                ],
                [
                    'title' => 'Digitalisation de la gestion locative pour une agence immobilière',
                    'slug' => 'digitalisation-gestion-locative-agence-immobiliere',
                    'pole' => 'ilepay',
                    'client' => 'Agence de gestion immobilière',
                    'sector' => 'Immobilier',
                    'challenge' => 'L\'agence devait centraliser le suivi de ses contrats de location et sécuriser l\'encaissement des loyers auprès de plusieurs dizaines de propriétaires et locataires.',
                    'solution' => 'Déploiement d\'Ilepay pour la gestion des contrats de location, l\'encaissement digital des loyers et le suivi en temps réel des paiements pour chaque bien.',
                    'results' => 'Plus de 300 contrats de location gérés sur la plateforme, taux d\'impayés réduit de 60%.',
                    'is_featured' => true,
                ],
        ];

        foreach ($projects as $project) {
            if (! DB::table('projects')->where('slug', $project['slug'])->exists()) {
                DB::table('projects')->insert($project + ['created_at' => now(), 'updated_at' => now()]);
            }
        }
    }
};
