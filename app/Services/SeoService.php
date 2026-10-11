<?php

namespace App\Services;

use Artesaos\SEOTools\Facades\SEOTools;

class SeoService
{
    public const DEFAULT_IMAGE = 'images/og-default.jpg';

    /**
     * @param  string|null  $image  URL absolue d'une image de partage propre à la page
     *                              (1200×630 conseillé) ; à défaut, l'image OYETECH par défaut.
     */
    public function set(string $title, string $description, ?string $image = null): void
    {
        // false : nos titres incluent déjà "— OYETECH", sans quoi seotools
        // l'ajoute une deuxième fois (ex: "... à Abidjan — OYETECH — OYETECH").
        SEOTools::setTitle($title, false);
        SEOTools::setDescription($description);

        $image ??= asset(self::DEFAULT_IMAGE);

        SEOTools::opengraph()
            ->setTitle($title)
            ->setDescription($description)
            ->setUrl(url()->current())
            ->addProperty('locale', 'fr_CI')
            ->addImage($image, $image === asset(self::DEFAULT_IMAGE) ? ['width' => 1200, 'height' => 630] : []);

        SEOTools::twitter()
            ->setType('summary_large_image')
            ->setTitle($title)
            ->setDescription($description)
            ->setImage($image);
    }
}
