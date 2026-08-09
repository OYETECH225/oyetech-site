<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
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
            'pole' => 'nullable|string|in:conseil,communication,marketing,solutions,ilepay',
            'budget' => 'nullable|string|max:50',
            'message' => 'required|string|min:20|max:2000',
            // Honeypot anti-spam : champ invisible pour les humains, doit rester vide
            'website' => 'prohibited',
        ];
    }
}
