<?php

namespace App\Services;

/**
 * Accès aux coordonnées d'OYETECH (config/entreprise.php) et valeurs dérivées.
 * Partagé dans toutes les vues sous la variable $entreprise.
 */
class Entreprise
{
    public const A_FOURNIR = '[À FOURNIR]';

    public const RESEAUX = [
        'linkedin' => 'LinkedIn',
        'facebook' => 'Facebook',
        'instagram' => 'Instagram',
        'x' => 'X (Twitter)',
    ];

    public function get(string $key, mixed $default = null): mixed
    {
        $value = config("entreprise.{$key}", $default);

        return $value === '' ? $default : $value;
    }

    /** Valeur configurée, ou le repère « [À FOURNIR] » (pages légales uniquement). */
    public function ouAFournir(string $key): string
    {
        return (string) ($this->get($key) ?? self::A_FOURNIR);
    }

    public function telephone(): ?string
    {
        return $this->get('telephone');
    }

    public function telephoneHref(): ?string
    {
        $tel = $this->telephone();

        return $tel ? 'tel:'.preg_replace('/[^\d+]/', '', $tel) : null;
    }

    public function whatsappUrl(string $message = 'Bonjour OYETECH, je souhaite échanger sur un projet.'): ?string
    {
        $numero = preg_replace('/\D/', '', (string) $this->get('whatsapp'));

        return $numero ? 'https://wa.me/'.$numero.'?text='.rawurlencode($message) : null;
    }

    public function email(): string
    {
        return $this->get('email');
    }

    public function anneeCreation(): int
    {
        return (int) $this->get('annee_creation');
    }

    /** Ancienneté en années, calculée à partir de l'année de création. */
    public function anciennete(): int
    {
        return now()->year - $this->anneeCreation();
    }

    /** « rue, Abidjan, Côte d'Ivoire », ou « Abidjan, Côte d'Ivoire » si la rue manque. */
    /**
     * L'ancienneté n'est mise en avant qu'à partir de 3 ans : « 1 année d'expertise »
     * dessert la crédibilité. Les blocs concernés réapparaissent automatiquement.
     */
    public function afficheAnciennete(): bool
    {
        return $this->anciennete() >= 3;
    }

    public function adresse(): string
    {
        return collect([
            $this->get('adresse.rue'),
            $this->get('adresse.ville'),
            $this->get('adresse.pays'),
        ])->filter()->implode(', ');
    }

    public function calendly(): ?string
    {
        return $this->get('calendly');
    }

    /** @return array<string, array{label: string, url: string}> réseaux configurés uniquement */
    public function reseaux(): array
    {
        return collect(self::RESEAUX)
            ->map(fn (string $label, string $key) => ['label' => $label, 'url' => $this->get("reseaux.{$key}")])
            ->filter(fn (array $reseau) => filled($reseau['url']))
            ->all();
    }

    /** JSON-LD Organization (ProfessionalService) ; les champs vides sont retirés. */
    public function jsonLd(): array
    {
        $url = rtrim($this->get('url'), '/');

        return self::sansVides([
            '@context' => 'https://schema.org',
            '@type' => 'ProfessionalService',
            '@id' => $url.'/#organization',
            'name' => $this->get('nom'),
            'legalName' => $this->get('raison_sociale'),
            'url' => $url.'/',
            'logo' => $url.'/images/logo-full.png',
            'image' => $url.'/images/og-default.jpg',
            'description' => $this->get('description'),
            'foundingDate' => (string) $this->anneeCreation(),
            'email' => $this->email(),
            'telephone' => $this->telephone(),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $this->get('adresse.rue'),
                'addressLocality' => $this->get('adresse.ville'),
                'addressCountry' => $this->get('adresse.code_pays'),
            ],
            'areaServed' => $this->get('zones_intervention'),
            'sameAs' => array_values(array_column($this->reseaux(), 'url')),
            'founder' => array_map(fn (array $f) => [
                '@type' => 'Person',
                'name' => $f['nom'],
                'jobTitle' => $f['fonction'],
            ], $this->get('fondateurs', [])),
        ]);
    }

    private static function sansVides(array $data): array
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = self::sansVides($value);
                $data[$key] = $value;
            }

            if ($value === null || $value === '' || $value === []) {
                unset($data[$key]);
            }
        }

        return $data;
    }
}
