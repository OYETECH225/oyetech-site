<?php

namespace App\Services;

use Artesaos\SEOTools\Facades\SEOTools;

class SeoService
{
    public function set(string $title, string $description, ?string $image = null): void
    {
        // false : nos titres incluent déjà "— OYETECH", sans quoi seotools
        // l'ajoute une deuxième fois (ex: "... à Abidjan — OYETECH — OYETECH").
        SEOTools::setTitle($title, false);
        SEOTools::setDescription($description);
        SEOTools::opengraph()->setTitle($title);
        SEOTools::opengraph()->setDescription($description);
        SEOTools::twitter()->setTitle($title);
        SEOTools::twitter()->setDescription($description);

        if ($image) {
            SEOTools::opengraph()->addImage($image);
        }
    }
}
