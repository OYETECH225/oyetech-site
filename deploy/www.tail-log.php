<?php

// TEMPORAIRE — lecture des logs serveur sans accès shell (diagnostic).
// Protégé par le même token que deploy-hook.php. À supprimer une fois le
// diagnostic terminé.

$secret = 'CHANGE-ME-AT-DEPLOY-TIME';

if (! hash_equals($secret, $_SERVER['HTTP_X_DEPLOY_TOKEN'] ?? '')) {
    http_response_code(404);
    exit('Not found');
}

header('Content-Type: text/plain');

function tailFile(string $path, int $lines = 200): string
{
    if (! file_exists($path)) {
        return "=== {$path} : fichier absent ===\n";
    }

    $content = file_get_contents($path);
    $allLines = explode("\n", $content);
    $tail = array_slice($allLines, -$lines);

    return "=== {$path} (dernières ".count($tail)." lignes) ===\n".implode("\n", $tail)."\n";
}

echo tailFile(__DIR__.'/../oyetech-app/storage/logs/laravel.log');
