<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\NewLeadNotification;
use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(Request $request): View
    {
        // ?pole= accepte le slug de la page pôle (solutions-numeriques) ou la clé (solutions)
        $pole = (string) $request->query('pole');
        $pole = ContactRequest::POLE_SLUGS[$pole] ?? (array_key_exists($pole, ContactRequest::POLES) ? $pole : null);

        // ?offre= (bloc « Demander un devis » de Solutions Numériques) pré-remplit le message
        $offre = config('solutions.offres.'.$request->query('offre').'.titre');

        return view('pages.contact', [
            'poles' => ContactRequest::POLES,
            'budgets' => ContactRequest::BUDGETS,
            'selectedPole' => $pole,
            'defaultMessage' => $offre ? "Bonjour, je souhaite recevoir un devis pour : {$offre}.\n\n" : '',
        ]);
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
