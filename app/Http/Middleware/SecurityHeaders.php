<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * En-têtes de sécurité HTTP, dont une Content-Security-Policy appliquée.
 * Couvre le site public (GTM/GA4 après consentement, Google Fonts, Google Maps)
 * et l'admin Filament (Alpine/Livewire : 'unsafe-eval', polices fonts.bunny.net).
 * Ajouter ici tout nouveau service tiers, sinon le navigateur le bloquera.
 */
class SecurityHeaders
{
    private const CSP = [
        "default-src 'self'",
        "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.googletagmanager.com https://www.google-analytics.com https://connect.facebook.net https://snap.licdn.com https://assets.calendly.com",
        "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://fonts.bunny.net",
        "font-src 'self' data: https://fonts.gstatic.com https://fonts.bunny.net",
        "img-src 'self' data: blob: https:",
        "connect-src 'self' https://www.google-analytics.com https://*.google-analytics.com https://*.analytics.google.com https://www.googletagmanager.com https://*.g.doubleclick.net https://www.google.com https://px.ads.linkedin.com https://www.facebook.com",
        "worker-src 'self' blob:",
        "frame-src https://www.googletagmanager.com https://calendly.com https://maps.google.com https://www.google.com",
        "object-src 'none'",
        "base-uri 'self'",
        "form-action 'self'",
        "frame-ancestors 'self'",
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $headers = [
            'X-Content-Type-Options' => 'nosniff',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'X-Frame-Options' => 'SAMEORIGIN',
            'Permissions-Policy' => 'camera=(), microphone=(), geolocation=(), payment=(), usb=(), interest-cohort=()',
            'Content-Security-Policy' => implode('; ', self::CSP),
        ];

        // HSTS uniquement en HTTPS (sans effet, et trompeur, en HTTP local)
        if ($request->isSecure()) {
            $headers['Strict-Transport-Security'] = 'max-age=31536000; includeSubDomains';
        }

        foreach ($headers as $name => $value) {
            if (! $response->headers->has($name)) {
                $response->headers->set($name, $value);
            }
        }

        return $response;
    }
}
