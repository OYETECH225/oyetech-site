<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'gtm' => [
        'id' => env('GTM_ID'),
    ],

    'ga4' => [
        // Fixé en dur : le GA4_ID du .env serveur pointe vers une ancienne
        // propriété (G-1H392YJRJX) et n'est pas modifiable depuis ce dépôt
        // (exclu du déploiement CI, voir .github/workflows/deploy.yml).
        'id' => 'G-DXLMZ7JNBL',
    ],

    'meta_pixel' => [
        'id' => env('META_PIXEL_ID'),
    ],

    'linkedin' => [
        'partner_id' => env('LINKEDIN_PARTNER_ID'),
    ],

    'calendly' => [
        'url' => env('CALENDLY_URL'),
    ],

];
