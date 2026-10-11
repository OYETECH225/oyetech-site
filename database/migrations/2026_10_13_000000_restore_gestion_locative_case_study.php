<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

/**
 * Rétablit l'étude de cas Ilepay « gestion locative » (supprimée par
 * 2026_10_12_000000), sans résultats chiffrés non vérifiables. L'image de
 * couverture éventuelle est à remettre dans l'admin.
 */
return new class extends Migration
{
    private const SLUG = 'digitalisation-gestion-locative-agence-immobiliere';

    public function up(): void
    {
        if (DB::table('projects')->where('slug', self::SLUG)->exists()) {
            return;
        }

        DB::table('projects')->insert([
            'title' => 'Digitalisation de la gestion locative pour une agence immobilière',
            'slug' => self::SLUG,
            'pole' => 'ilepay',
            'client' => 'Agence de gestion immobilière',
            'sector' => 'Immobilier',
            'challenge' => 'L\'agence devait centraliser le suivi de ses contrats de location et sécuriser l\'encaissement des loyers auprès de plusieurs dizaines de propriétaires et locataires.',
            'solution' => 'Déploiement d\'Ilepay pour la gestion des contrats de location, l\'encaissement digital des loyers et le suivi en temps réel des paiements pour chaque bien.',
            'results' => '',
            'is_featured' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('projects')->where('slug', self::SLUG)->where('results', '')->delete();
    }
};
