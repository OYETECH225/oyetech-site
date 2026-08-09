<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Project;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

#[Signature('app:generate-sitemap')]
#[Description('Génère le fichier sitemap.xml du site')]
class GenerateSitemap extends Command
{
    public function handle(): void
    {
        $sitemap = Sitemap::create()
            ->add(Url::create(route('home'))->setPriority(1.0))
            ->add(Url::create(route('about'))->setPriority(0.7))
            ->add(Url::create(route('services.index'))->setPriority(0.9))
            ->add(Url::create(route('services.conseil'))->setPriority(0.8))
            ->add(Url::create(route('services.communication'))->setPriority(0.8))
            ->add(Url::create(route('services.marketing'))->setPriority(0.8))
            ->add(Url::create(route('services.solutions'))->setPriority(0.8))
            ->add(Url::create(route('services.ilepay'))->setPriority(0.8))
            ->add(Url::create(route('portfolio.index'))->setPriority(0.7))
            ->add(Url::create(route('blog.index'))->setPriority(0.7))
            ->add(Url::create(route('contact'))->setPriority(0.6));

        Project::all()->each(function (Project $project) use ($sitemap) {
            $sitemap->add(
                Url::create(route('portfolio.show', $project))
                    ->setLastModificationDate($project->updated_at)
                    ->setPriority(0.6)
            );
        });

        Article::published()->get()->each(function (Article $article) use ($sitemap) {
            $sitemap->add(
                Url::create(route('blog.show', $article))
                    ->setLastModificationDate($article->updated_at)
                    ->setPriority(0.5)
            );
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap généré avec succès dans public/sitemap.xml');
    }
}
