<x-mail::message>
# Nouvelle demande de contact

**Nom :** {{ $lead->name }}
**Entreprise :** {{ $lead->company ?? '—' }}
**Email :** {{ $lead->email }}
**Téléphone :** {{ $lead->phone ?? '—' }}
**Pays :** {{ $lead->country ?? '—' }}
**Pôle concerné :** {{ $lead->pole ?? '—' }}
**Budget estimé :** {{ $lead->budget ?? '—' }}

## Message

{{ $lead->message }}

<x-mail::button :url="route('contact')">
Voir le formulaire de contact
</x-mail::button>

Merci,<br>
OYETECH
</x-mail::message>
