<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\NewLeadNotification;
use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('pages.contact');
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        $lead = Lead::create($request->validated());

        Mail::to(config('mail.from.address'))->queue(new NewLeadNotification($lead));

        return redirect()
            ->route('contact')
            ->with('success', 'Merci, votre message a bien été envoyé. Notre équipe vous recontactera très rapidement.');
    }
}
