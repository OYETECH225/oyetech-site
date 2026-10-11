<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Retire les résultats chiffrés non vérifiables des études de cas d'origine
 * (clients anonymisés). Seuls les textes exacts du seeder initial sont visés :
 * un résultat déjà modifié dans l'admin n'est pas touché. Le bloc « Résultats »
 * est masqué quand le champ est vide.
 */
return new class extends Migration
{
    private const RESULTATS_INITIAUX = [
        'campagne-notoriete-made-in-ci' => 'Notoriété spontanée de la marque en hausse de 28%, plus de 2M de vues sur les contenus digitaux.',
        'acquisition-digitale-fintech-regionale' => 'Coût d\'acquisition réduit de 40%, +18 000 nouveaux utilisateurs en 6 mois.',
        'plateforme-ecommerce-distributeur-regional' => 'Mise en ligne en 4 mois, 99,9% de disponibilité, +60% de ventes en ligne dès le premier trimestre.',
        'digitalisation-gestion-locative-agence-immobiliere' => 'Plus de 300 contrats de location gérés sur la plateforme, taux d\'impayés réduit de 60%.',
    ];

    public function up(): void
    {
        foreach (self::RESULTATS_INITIAUX as $slug => $results) {
            DB::table('projects')->where('slug', $slug)->where('results', $results)->update(['results' => '']);
        }
    }

    public function down(): void
    {
        foreach (self::RESULTATS_INITIAUX as $slug => $results) {
            DB::table('projects')->where('slug', $slug)->where('results', '')->update(['results' => $results]);
        }
    }
};
