<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Un témoignage ne s'affiche que si l'auteur a autorisé sa publication.
 * Défaut à false : les témoignages existants sont masqués tant que
 * l'autorisation n'a pas été confirmée dans l'admin.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->boolean('publication_authorized')->default(false)->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn('publication_authorized');
        });
    }
};
