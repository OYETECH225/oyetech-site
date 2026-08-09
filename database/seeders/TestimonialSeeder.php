<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'author_name' => 'Aïssata Koné',
                'author_role' => 'Directrice Générale',
                'company' => 'CFTS West Africa',
                'content' => 'OYETECH a su transformer notre vision stratégique en une feuille de route concrète et exécutable. Un partenaire d\'une rigueur remarquable.',
                'rating' => 5,
                'order' => 1,
            ],
            [
                'author_name' => 'Jean-Marc Adou',
                'author_role' => 'Directeur Marketing',
                'company' => 'Groupe agro-industriel ivoirien',
                'content' => 'La campagne menée par l\'équipe communication a dépassé toutes nos attentes en termes d\'impact et de notoriété.',
                'rating' => 5,
                'order' => 2,
            ],
            [
                'author_name' => 'Fatou Diabaté',
                'author_role' => 'Responsable Digital',
                'company' => 'Fintech régionale',
                'content' => 'Une équipe orientée résultats, qui pilote chaque euro investi avec une précision exemplaire.',
                'rating' => 5,
                'order' => 3,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                ['author_name' => $testimonial['author_name'], 'company' => $testimonial['company']],
                $testimonial
            );
        }
    }
}
