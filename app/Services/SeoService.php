<?php

namespace App\Services;

use Artesaos\SEOTools\Facades\SEOTools;

class SeoService
{
    public function set(string $title, string $description, ?string $image = null): void
    {
        SEOTools::setTitle($title);
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
