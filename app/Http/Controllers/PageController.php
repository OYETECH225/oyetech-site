<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return view('pages.about', [
            'team' => TeamMember::active()->get(),
        ]);
    }

    public function legalNotice(): View
    {
        return view('pages.legal.notice');
    }

    public function privacy(): View
    {
        return view('pages.legal.privacy');
    }
}
