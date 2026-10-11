<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
{
    public const POLES = [
        'conseil' => 'Conseil & Stratégie',
        'communication' => 'Communication & Publicité',
        'marketing' => 'Marketing Digital',
        'solutions' => 'Solutions Numériques',
        'ilepay' => 'Ilepay',
    ];

    /** Slugs d'URL des pages pôles, acceptés dans ?pole= pour présélectionner le formulaire */
    public const POLE_SLUGS = [
        'conseil-strategie' => 'conseil',
        'communication-publicite' => 'communication',
        'marketing-digital' => 'marketing',
        'solutions-numeriques' => 'solutions',
        'ilepay' => 'ilepay',
    ];

    // Tranches proposées, à valider par l'agence
    public const BUDGETS = [
        'Moins de 1 M FCFA',
        '1 à 3 M FCFA',
        '3 à 10 M FCFA',
        'Plus de 10 M FCFA',
        'Je ne sais pas encore',
    ];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'company' => 'nullable|string|max:100',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'pole' => ['nullable', 'string', Rule::in(array_keys(self::POLES))],
            'budget' => ['nullable', 'string', Rule::in(self::BUDGETS)],
            'message' => 'required|string|min:20|max:2000',
            // Honeypot anti-spam : champ invisible pour les humains, doit rester vide
            'website' => 'prohibited',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Le champ :attribute est obligatoire.',
            'email' => 'Merci d\'indiquer une adresse email valide.',
            'max' => 'Le champ :attribute ne doit pas dépasser :max caractères.',
            'message.min' => 'Votre message doit contenir au moins :min caractères.',
            'in' => 'La valeur choisie pour le champ :attribute n\'est pas valide.',
            'website.prohibited' => 'Votre message n\'a pas pu être envoyé.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nom complet',
            'email' => 'email',
            'phone' => 'téléphone',
            'pole' => 'pôle concerné',
            'budget' => 'budget estimé',
            'message' => 'message',
        ];
    }
}
