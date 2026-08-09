<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('pages.services.index', [
            'services' => Service::active()->orderBy('order')->get(),
        ]);
    }

    public function conseil(): View
    {
        return $this->pole('conseil', 'services.conseil');
    }

    public function communication(): View
    {
        return $this->pole('communication', 'services.communication');
    }

    public function marketing(): View
    {
        return $this->pole('marketing', 'services.marketing');
    }

    public function solutions(): View
    {
        return $this->pole('solutions', 'services.solutions');
    }

    public function ilepay(): View
    {
        return $this->pole('ilepay', 'services.ilepay');
    }

    protected function pole(string $pole, string $view): View
    {
        $service = Service::active()->pole($pole)->firstOrFail();

        return view("pages.{$view}", [
            'service' => $service,
            'projects' => Project::pole($pole)->latest()->take(3)->get(),
            'otherServices' => Service::active()->where('id', '!=', $service->id)->orderBy('order')->get(),
        ]);
    }
}
