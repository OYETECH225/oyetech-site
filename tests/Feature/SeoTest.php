<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Project;
use App\Models\Service;
use App\Services\Faq;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    /** @return array<int, array<string, mixed>> blocs JSON-LD décodés de la page */
    private function jsonLd(string $html): array
    {
        preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m);

        return array_map(function (string $json) {
            $data = json_decode($json, true);
            $this->assertIsArray($data, 'JSON-LD invalide : '.$json);

            return $data;
        }, $m[1]);
    }

    private function ofType(array $blocks, string $type): ?array
    {
        return collect($blocks)->firstWhere('@type', $type);
    }

    public function test_robots_txt_sitemap_en_url_absolue(): void
    {
        $this->assertStringContainsString(
            'Sitemap: https://www.oyetech-ci.com/sitemap.xml',
            file_get_contents(public_path('robots.txt'))
        );
    }

    public function test_balises_communes_sur_toutes_les_pages(): void
    {
        foreach ([route('home'), route('about'), route('contact'), route('legal.notice')] as $url) {
            $html = $this->get($url)->getContent();

            $this->assertStringContainsString('<html lang="fr"', $html);
            $this->assertStringContainsString('<meta property="og:locale" content="fr_CI"', $html);
            $this->assertStringContainsString('<meta property="og:image" content="'.asset('images/og-default.jpg').'"', $html);
            $this->assertStringContainsString('<meta name="twitter:card" content="summary_large_image"', $html);
        }
    }

    public function test_json_ld_organization_sans_champs_vides(): void
    {
        config(['entreprise.telephone' => '', 'entreprise.reseaux.linkedin' => '', 'entreprise.adresse.rue' => '']);

        $org = $this->ofType($this->jsonLd($this->get(route('home'))->getContent()), 'ProfessionalService');

        $this->assertSame('OYETECH SARL', $org['legalName']);
        $this->assertSame((string) config('entreprise.annee_creation'), $org['foundingDate']);
        $this->assertSame('Yamoussa KOUYATE', $org['founder'][0]['name']);
        $this->assertArrayNotHasKey('telephone', $org);
        $this->assertArrayNotHasKey('sameAs', $org);
        $this->assertArrayNotHasKey('streetAddress', $org['address']);
    }

    public function test_faq_json_ld_identique_a_la_faq_affichee(): void
    {
        $html = $this->get(route('home'))->getContent();
        $faq = $this->ofType($this->jsonLd($html), 'FAQPage');

        $expected = array_column(app(Faq::class)->accueil(), 'q');
        $this->assertSame($expected, array_column($faq['mainEntity'], 'name'));

        foreach ($expected as $question) {
            $this->assertStringContainsString(e($question), $html);
        }
    }

    public function test_faq_json_ld_sur_les_pages_services(): void
    {
        $service = Service::factory()->create(['pole' => 'solutions', 'is_active' => true]);

        $blocks = $this->jsonLd($this->get(route('services.solutions'))->getContent());

        $this->assertSame(
            array_column(app(Faq::class)->pole($service->name), 'q'),
            array_column($this->ofType($blocks, 'FAQPage')['mainEntity'], 'name')
        );
        $this->assertNotNull($this->ofType($blocks, 'BreadcrumbList'));
    }

    public function test_article_et_fil_d_ariane_sur_les_insights(): void
    {
        $article = Article::factory()->create(['is_published' => true, 'published_at' => now()->subDay()]);

        $blocks = $this->jsonLd($this->get(route('blog.show', $article))->getContent());
        $json = $this->ofType($blocks, 'Article');

        foreach (['headline', 'datePublished', 'dateModified', 'author', 'image', 'publisher'] as $key) {
            $this->assertArrayHasKey($key, $json, $key);
        }
        $this->assertNotNull($this->ofType($blocks, 'BreadcrumbList'));
    }

    public function test_fil_d_ariane_sur_les_realisations(): void
    {
        $project = Project::factory()->create();

        $this->assertNotNull($this->ofType($this->jsonLd($this->get(route('portfolio.show', $project))->getContent()), 'BreadcrumbList'));
    }

    public function test_titles_et_descriptions_uniques(): void
    {
        foreach (['conseil', 'communication', 'marketing', 'solutions', 'ilepay'] as $pole) {
            Service::factory()->create(['pole' => $pole, 'is_active' => true]);
        }

        $titles = $descriptions = [];
        foreach ([
            'home', 'about', 'contact', 'services.index', 'services.conseil', 'services.communication',
            'services.marketing', 'services.solutions', 'services.ilepay', 'portfolio.index', 'blog.index',
            'legal.notice', 'legal.privacy',
        ] as $name) {
            $html = $this->get(route($name))->assertOk()->getContent();
            preg_match('#<title>(.*?)</title>#s', $html, $t);
            preg_match('#<meta name="description" content="(.*?)"#s', $html, $d);

            $this->assertNotEmpty($t[1] ?? null, $name);
            $this->assertNotEmpty($d[1] ?? null, $name);
            $titles[$name] = $t[1];
            $descriptions[$name] = $d[1];
        }

        $this->assertSame(count($titles), count(array_unique($titles)), 'Titles en double');
        $this->assertSame(count($descriptions), count(array_unique($descriptions)), 'Descriptions en double');
    }

    public function test_images_avec_alt_dimensions_et_logos_webp(): void
    {
        $html = $this->get(route('home'))->getContent();

        preg_match_all('/<img\b[^>]*>/', $html, $imgs);
        foreach ($imgs[0] as $img) {
            $this->assertMatchesRegularExpression('/\salt="/', $img, $img);
            $this->assertMatchesRegularExpression('/\swidth="\d+"/', $img, $img);
            $this->assertMatchesRegularExpression('/\sheight="\d+"/', $img, $img);
        }

        $this->assertSame(2, substr_count($html, 'images/logo-full.webp" type="image/webp"'));
        $this->assertMatchesRegularExpression('/<footer.*logo-full\.png"[^>]*loading="lazy"/s', $html);
        $this->assertFileExists(public_path('images/logo-full.webp'));
    }

    public function test_menu_services_utilisable_au_clavier(): void
    {
        $this->get(route('home'))
            ->assertSee('@click="servicesOpen = ! servicesOpen"', false)
            ->assertSee('aria-controls="services-menu"', false)
            ->assertSee('id="services-menu"', false)
            ->assertSee('@keydown.escape.stop', false);
    }

    public function test_en_tetes_de_securite(): void
    {
        $this->get(route('home'))
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('Permissions-Policy')
            ->assertHeader('Content-Security-Policy-Report-Only');

        $this->get('https://localhost/')->assertHeader('Strict-Transport-Security');
    }
}
