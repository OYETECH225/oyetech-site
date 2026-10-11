<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\TeamMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class CredibiliteTest extends TestCase
{
    use RefreshDatabase;

    private function pages(): array
    {
        Service::factory()->create(['pole' => 'solutions', 'is_active' => true]);

        return [route('home'), route('about'), route('contact'), route('services.solutions')];
    }

    public function test_aucun_numero_factice_ni_lien_vide(): void
    {
        foreach ($this->pages() as $url) {
            $html = $this->get($url)->assertOk()->getContent();

            $this->assertStringNotContainsString('00 00 00 00', $html, $url);
            $this->assertStringNotContainsString('href="#"', $html, $url);
        }
    }

    public function test_un_seul_h1_par_page_sans_double_espace(): void
    {
        foreach ($this->pages() as $url) {
            $html = $this->get($url)->getContent();

            $this->assertSame(1, substr_count($html, '<h1'), $url);
            preg_match('/<h1[^>]*>(.*?)<\/h1>/s', $html, $m);
            $this->assertStringNotContainsString('  ', trim(preg_replace('/\s*\n\s*/', ' ', strip_tags($m[1]))), $url);
        }
    }

    public function test_h1_accueil(): void
    {
        $this->get(route('home'))->assertSee('Stratégie, communication et solutions digitales pour faire grandir les entreprises africaines');
    }

    public function test_telephone_masque_si_non_configure(): void
    {
        config(['entreprise.telephone' => '']);

        $this->get(route('contact'))->assertDontSee('tel:', false);
    }

    public function test_telephone_affiche_avec_lien_tel_si_configure(): void
    {
        config(['entreprise.telephone' => '+225 07 12 34 56 78']);

        $this->get(route('contact'))
            ->assertSee('href="tel:+2250712345678"', false)
            ->assertSee('+225 07 12 34 56 78');
    }

    public function test_whatsapp_affiche_seulement_si_configure(): void
    {
        config(['entreprise.whatsapp' => '']);
        $this->get(route('contact'))->assertDontSee('wa.me', false);

        config(['entreprise.whatsapp' => '2250712345678']);
        $this->get(route('contact'))->assertSee('https://wa.me/2250712345678?text=', false);
    }

    public function test_reseaux_sociaux_seulement_si_configures(): void
    {
        config(['entreprise.reseaux' => ['linkedin' => 'https://www.linkedin.com/company/oyetech', 'facebook' => '', 'instagram' => '', 'x' => '']]);

        $this->get(route('home'))
            ->assertSee('href="https://www.linkedin.com/company/oyetech" target="_blank" rel="noopener"', false)
            ->assertDontSee('OYETECH sur Facebook');
    }

    public function test_adresse_sans_mention_a_venir(): void
    {
        config(['entreprise.adresse.rue' => '']);

        $this->get(route('contact'))
            ->assertDontSee('à venir')
            ->assertSee("Abidjan, Côte d&#039;Ivoire", false);
    }

    public function test_anciennete_calculee_depuis_annee_de_creation(): void
    {
        Carbon::setTestNow('2030-06-01');

        $this->get(route('home'))
            ->assertSee('depuis 2012')
            ->assertSee('>18</span>', false)
            ->assertDontSee('12+');
    }

    public function test_chiffres_rendus_cote_serveur(): void
    {
        $this->get(route('home'))
            ->assertSee('x-text="count">98</span>', false)
            ->assertDontSee('x-text="count"></span>', false);
    }

    public function test_maquette_signalee_comme_illustration(): void
    {
        $this->get(route('home'))->assertSee('Illustration');
    }

    public function test_calendly_cliquable_dans_la_faq(): void
    {
        $this->get(route('home'))->assertSee('href="https://calendly.com/oyetech"', false);
    }

    public function test_noms_equipe_au_format_prenom_nom(): void
    {
        TeamMember::create(['name' => 'KOUYATE Yamoussa', 'role' => 'Fondateur & DG', 'is_active' => true]);

        $this->get(route('home'))->assertSee('Yamoussa KOUYATE');
        $this->get(route('about'))->assertSee('Yamoussa KOUYATE');
    }
}
