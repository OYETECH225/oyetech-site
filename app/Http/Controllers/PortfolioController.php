<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        return view('pages.portfolio.index', [
            'projects' => Project::latest()->get(),
        ]);
    }

    public function show(Project $project): View
    {
        return view('pages.portfolio.show', [
            'project' => $project,
            'related' => Project::pole($project->pole)->where('id', '!=', $project->id)->take(3)->get(),
        ]);
    }
}
