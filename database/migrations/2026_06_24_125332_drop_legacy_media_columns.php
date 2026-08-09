<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('cover_image');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('images');
        });

        Schema::table('team_members', function (Blueprint $table) {
            $table->dropColumn('photo');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn('photo');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('cover_image')->nullable();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->json('images')->nullable();
        });

        Schema::table('team_members', function (Blueprint $table) {
            $table->string('photo')->nullable();
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('photo')->nullable();
        });
    }
};
