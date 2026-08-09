<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_about_page_loads(): void
    {
        $this->get(route('about'))->assertOk();
    }

    public function test_services_index_loads(): void
    {
        $this->get(route('services.index'))->assertOk();
    }

    public function test_service_pole_page_loads(): void
    {
        Service::factory()->create(['pole' => 'ilepay', 'is_active' => true]);

        $this->get(route('services.ilepay'))->assertOk();
    }

    public function test_portfolio_index_and_show_load(): void
    {
        $project = Project::factory()->create();

        $this->get(route('portfolio.index'))->assertOk();
        $this->get(route('portfolio.show', $project))->assertOk();
    }

    public function test_blog_index_and_show_load(): void
    {
        $article = Article::factory()->create([
            'is_published' => true,
            'published_at' => now(),
        ]);

        $this->get(route('blog.index'))->assertOk();
        $this->get(route('blog.show', $article))->assertOk();
    }

    public function test_contact_page_loads(): void
    {
        $this->get(route('contact'))->assertOk();
    }
}
