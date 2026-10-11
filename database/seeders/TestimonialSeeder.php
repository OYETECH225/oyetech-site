<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        // Aucun témoignage par défaut : n'ajouter que des témoignages réels, avec
        // l'autorisation écrite de leur auteur (publication_authorized = true).
        $testimonials = [];

        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                ['author_name' => $testimonial['author_name'], 'company' => $testimonial['company']],
                $testimonial
            );
        }
    }
}
