<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Client;
use App\Models\Project;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('pages.home', [
            'services' => Service::active()->orderBy('order')->get(),
            'projects' => Project::featured()->latest()->take(6)->get(),
            'testimonials' => Testimonial::publishable()->get(),
            'clients' => Client::active()->get()->filter(fn (Client $client) => $client->logo_url),
            'articles' => Article::published()->latest('published_at')->take(3)->get(),
            'team' => TeamMember::active()->take(4)->get(),
        ]);
    }
}
