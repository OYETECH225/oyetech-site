<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class JuridiqueTest extends TestCase
{
    use RefreshDatabase;

    public function test_mentions_legales(): void
    {
        config(['entreprise.rccm' => '', 'entreprise.hebergeur.nom' => '']);

        $this->get(route('legal.notice'))
            ->assertOk()
            ->assertSee('OYETECH SARL')
            ->assertSee('Yamoussa KOUYATE')
            ->assertSee('contact@oyetech.ci')
            ->assertSee('Hébergeur')
            ->assertSee('Propriété intellectuelle')
            ->assertSee('[À FOURNIR]');
    }

    public function test_mentions_legales_lues_depuis_la_configuration(): void
    {
        config(['entreprise.rccm' => 'CI-ABJ-2012-B-12345']);

        $this->get(route('legal.notice'))->assertSee('CI-ABJ-2012-B-12345');
    }

    public function test_politique_de_confidentialite(): void
    {
        $response = $this->get(route('legal.privacy'))->assertOk();

        foreach ([
            'Responsable du traitement', 'Données collectées', 'Finalités', 'base légale',
            'Durée de conservation', '3 ans', 'Destinataires', 'Transferts hors de Côte',
            'Vos droits', 'rectification', 'opposition', 'suppression', 'Cookies', '2013-450',
        ] as $section) {
            $response->assertSee($section, false);
        }
    }

    public function test_mention_rgpd_sous_le_formulaire(): void
    {
        $this->get(route('contact'))
            ->assertSee('Vos données sont utilisées uniquement pour répondre à votre demande.')
            ->assertSee(route('legal.privacy'), false);
    }

    public function test_aucun_script_tiers_charge_sans_consentement(): void
    {
        config(['services.gtm.id' => 'GTM-TEST', 'services.ga4.id' => 'G-TEST']);

        $html = $this->get(route('home'))->getContent();

        $this->assertStringNotContainsString('googletagmanager.com', $html);
        $this->assertStringContainsString("gtag('consent', 'default'", $html);
        $this->assertStringContainsString('"gtm":"GTM-TEST"', $html);
        $this->assertStringContainsString('x-data="cookieConsent"', $html);
    }

    public function test_footer_liens_legaux_sur_toutes_les_pages(): void
    {
        foreach ([route('home'), route('contact'), route('legal.notice'), route('legal.privacy')] as $url) {
            $this->get($url)
                ->assertSee('Mentions légales')
                ->assertSee('Politique de confidentialité')
                ->assertSee('Gérer les cookies')
                ->assertSee('&copy; '.now()->year, false);
        }
    }

    public function test_sitemap_contient_les_pages_legales(): void
    {
        $path = public_path('sitemap.xml');
        $backup = file_exists($path) ? file_get_contents($path) : null;

        Artisan::call('app:generate-sitemap');
        $xml = file_get_contents($path);

        $backup === null ? unlink($path) : file_put_contents($path, $backup);

        $this->assertStringContainsString(route('legal.notice'), $xml);
        $this->assertStringContainsString(route('legal.privacy'), $xml);
    }
}
