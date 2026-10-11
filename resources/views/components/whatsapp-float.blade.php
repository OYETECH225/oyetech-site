{{-- Bouton WhatsApp flottant : affiché uniquement si un numéro est configuré (config/entreprise.php) --}}
@if($entreprise->whatsappUrl())
    <a href="{{ $entreprise->whatsappUrl() }}" target="_blank" rel="noopener"
        aria-label="Écrire à OYETECH sur WhatsApp (nouvel onglet)"
        class="fixed bottom-5 right-5 z-40 flex h-12 w-12 items-center justify-center rounded-full bg-ink text-white shadow-lg shadow-black/30 ring-1 ring-white/15 transition hover:scale-105 motion-reduce:transition-none">
        <x-whatsapp-icon class="h-6 w-6" />
    </a>
@endif
