<?php

namespace App\Http\Controllers;

use App\Models\Article;
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
            'testimonials' => Testimonial::active()->get(),
            'articles' => Article::published()->latest('published_at')->take(3)->get(),
            'team' => TeamMember::active()->take(4)->get(),
        ]);
    }
}
