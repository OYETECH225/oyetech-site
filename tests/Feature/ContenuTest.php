<?php

namespace Tests\Feature;

use App\Mail\NewLeadNotification;
use App\Models\Client;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContenuTest extends TestCase
{
    use RefreshDatabase;

    private function solutionsPage()
    {
        Service::factory()->create(['pole' => 'solutions', 'is_active' => true]);

        return $this->get(route('services.solutions'))->assertOk();
    }

    public function test_section_technologies_alimentee_par_la_configuration(): void
    {
        config(['solutions.technologies' => [
            ['usage' => 'Applications mobiles', 'phrase' => 'Une base de code.', 'technos' => ['Flutter', 'TechnoDeTest']],
        ]]);

        $this->solutionsPage()
            ->assertSee('Technologies')
            ->assertSee('Applications mobiles')
            ->assertSee('TechnoDeTest');
    }

    public function test_blocs_offre_avec_lien_devis_vers_le_pole(): void
    {
        $response = $this->solutionsPage();

        foreach (['Site vitrine', 'Site e-commerce', 'Application web métier', 'Application mobile', 'Maintenance &amp; TMA'] as $offre) {
            $response->assertSee($offre, false);
        }
        $response->assertSee('Pour qui')
            ->assertSee('Ce qui est livré')
            ->assertSee(e(route('contact', ['pole' => 'solutions-numeriques', 'offre' => 'site-vitrine'])), false)
            ->assertDontSee('FCFA');
    }

    public function test_le_formulaire_preselectionne_le_pole_depuis_l_url(): void
    {
        $this->get(route('contact', ['pole' => 'solutions-numeriques', 'offre' => 'site-vitrine']))
            ->assertSee('<option value="solutions" selected>', false)
            ->assertSee('devis pour : Site vitrine');

        $this->get(route('contact', ['pole' => 'conseil']))
            ->assertSee('<option value="conseil" selected>', false);

        $this->get(route('contact', ['pole' => 'inconnu']))
            ->assertDontSee('selected>', false);
    }

    public function test_temoignages_masques_sans_temoignage_reel_autorise(): void
    {
        Testimonial::create([
            'author_name' => 'Awa TEST', 'author_role' => 'DG', 'company' => 'Entreprise Test',
            'content' => 'Citation non autorisée.', 'rating' => 5, 'is_active' => true,
        ]);

        $this->get(route('home'))->assertDontSee('Témoignages clients')->assertDontSee('Citation non autorisée.');
    }

    public function test_temoignage_reel_autorise_affiche(): void
    {
        Testimonial::create([
            'author_name' => 'Awa TEST', 'author_role' => 'DG', 'company' => 'Entreprise Test',
            'content' => 'Citation autorisée.', 'rating' => 5, 'is_active' => true, 'publication_authorized' => true,
        ]);

        $this->get(route('home'))->assertSee('Témoignages clients')->assertSee('Citation autorisée.');
    }

    public function test_clients_sans_logo_jamais_affiches(): void
    {
        Client::create(['name' => 'Groupe agro-industriel ivoirien', 'is_active' => true]);
        Client::create(['name' => 'Fintech régionale', 'is_active' => true]);

        $this->get(route('home'))
            ->assertDontSee('Ils nous font confiance')
            ->assertDontSee('Groupe agro-industriel ivoirien');
    }

    public function test_equipe_photo_absente_initiales_et_linkedin(): void
    {
        TeamMember::create([
            'name' => 'Yamoussa KOUYATE', 'role' => 'Fondateur & DG', 'is_active' => true,
            'linkedin_url' => 'www.linkedin.com/in/exemple',
        ]);

        $this->get(route('about'))
            ->assertSee('>YK</span>', false)
            ->assertSee('href="https://www.linkedin.com/in/exemple"', false)
            ->assertSee('Profil LinkedIn de Yamoussa KOUYATE');
    }

    public function test_budget_propose_en_liste_fcfa(): void
    {
        $this->get(route('contact'))
            ->assertSee('<select id="contact-budget" name="budget"', false)
            ->assertSee('Moins de 1 M FCFA')
            ->assertSee('Je ne sais pas encore');
    }

    public function test_envoi_valide_avec_budget(): void
    {
        Mail::fake();

        $this->post(route('contact.store'), [
            'name' => 'Awa Koné',
            'email' => 'awa@example.com',
            'pole' => 'solutions',
            'budget' => '1 à 3 M FCFA',
            'message' => 'Bonjour, nous souhaitons refondre notre site vitrine.',
        ])->assertRedirect(route('contact'))->assertSessionHas('success');

        $this->assertDatabaseHas('leads', ['email' => 'awa@example.com', 'budget' => '1 à 3 M FCFA']);
        Mail::assertQueued(NewLeadNotification::class);

        $this->get(route('contact'))->assertSee('votre message a bien été envoyé');
    }

    public function test_champs_requis_manquants_422(): void
    {
        $this->postJson(route('contact.store'), [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'message']);

        $this->assertDatabaseCount('leads', 0);
    }

    public function test_message_d_erreur_affiche(): void
    {
        $this->from(route('contact'))
            ->followingRedirects()
            ->post(route('contact.store'), ['name' => '', 'email' => 'x', 'message' => 'court'])
            ->assertSee("Votre message n'a pas pu être envoyé", false)
            ->assertSee('Le champ nom complet est obligatoire.');
    }

    public function test_budget_hors_liste_refuse(): void
    {
        $this->postJson(route('contact.store'), [
            'name' => 'Awa Koné', 'email' => 'awa@example.com', 'budget' => '1 milliard',
            'message' => 'Bonjour, nous souhaitons refondre notre site vitrine.',
        ])->assertStatus(422)->assertJsonValidationErrors(['budget']);
    }

    public function test_anti_spam_honeypot_et_limitation(): void
    {
        $payload = [
            'name' => 'Spam Bot', 'email' => 'bot@example.com',
            'message' => 'Ceci est un message envoyé par un robot spammeur.',
            'website' => 'https://spam.example.com',
        ];

        $this->postJson(route('contact.store'), $payload)->assertStatus(422)->assertJsonValidationErrors(['website']);
        $this->assertDatabaseCount('leads', 0);

        // throttle:5,1 sur la route d'envoi
        for ($i = 0; $i < 4; $i++) {
            $this->postJson(route('contact.store'), $payload);
        }
        $this->postJson(route('contact.store'), $payload)->assertStatus(429);
    }
}
