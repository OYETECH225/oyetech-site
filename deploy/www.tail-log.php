<?php

// TEMPORAIRE — lecture des logs serveur sans accès shell (diagnostic 500 en
// prod). Protégé par le même token que deploy-hook.php. À supprimer (retirer
// du dépôt + laisser le prochain déploiement le nettoyer côté serveur) une
// fois le diagnostic terminé.

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

echo "=== Contenu du dossier racine (parent de www/) ===\n";
$root = __DIR__.'/..';
foreach (scandir($root) as $entry) {
    if ($entry === '.' || $entry === '..') {
        continue;
    }
    $full = $root.'/'.$entry;
    echo (is_dir($full) ? '[dir]  ' : '[file] ').$entry."\n";
}
echo "\n=== Contenu de oyetech-app/ (si présent) ===\n";
$appDir = __DIR__.'/../oyetech-app';
if (is_dir($appDir)) {
    foreach (scandir($appDir) as $entry) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }
        $full = $appDir.'/'.$entry;
        echo (is_dir($full) ? '[dir]  ' : '[file] ').$entry."\n";
    }
} else {
    echo "ABSENT\n";
}
echo "\n\n";

$envPath = __DIR__.'/../oyetech-app/.env';
echo "=== Vérification .env (sans exposer de secret) ===\n";
if (! file_exists($envPath)) {
    echo "ABSENT : {$envPath}\n";
} else {
    $envContent = file_get_contents($envPath);
    echo 'Présent, taille : '.filesize($envPath)." octets\n";
    echo 'Contient APP_KEY= non vide : '.(preg_match('/^APP_KEY=base64:.+/m', $envContent) ? 'OUI' : 'NON')."\n";
    echo 'Contient DB_DATABASE non vide : '.(preg_match('/^DB_DATABASE=.+/m', $envContent) ? 'OUI' : 'NON')."\n";
}
echo "\n\n";

echo tailFile(__DIR__.'/../oyetech-app/storage/logs/laravel.log');
echo "\n\n";
echo tailFile(__DIR__.'/../oyetech-app/storage/logs/deploy-hook.log');
