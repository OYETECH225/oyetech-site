<?php

// TEMPORAIRE — supprime les résidus de l'ancienne installation WordPress dans
// www/ (demande explicite de l'utilisateur). Liste blanche explicite, jamais
// de suppression par motif générique, pour ne toucher à rien d'autre. Protégé
// par le même token que deploy-hook.php. À retirer du dépôt une fois exécuté.

$secret = 'CHANGE-ME-AT-DEPLOY-TIME';

if (! hash_equals($secret, $_SERVER['HTTP_X_DEPLOY_TOKEN'] ?? '')) {
    http_response_code(404);
    exit('Not found');
}

header('Content-Type: text/plain');

$dryRun = ($_GET['dry_run'] ?? '1') !== '0';

// Liste blanche exacte des entrées WordPress/OVH constatées dans www/ le
// 2026-08-10 (voir tail-log.php) — rien d'autre n'est touché.
$targets = [
    '.tmb',
    'index.html.ovh.old',
    'license.txt',
    'readme.html',
    'wp-activate.php',
    'wp-admin',
    'wp-blog-header.php',
    'wp-comments-post.php',
    'wp-config-sample.php',
    'wp-config.php',
    'wp-content',
    'wp-cron.php',
    'wp-includes',
    'wp-links-opml.php',
    'wp-load.php',
    'wp-login.php',
    'wp-mail.php',
    'wp-settings.php',
    'wp-signup.php',
    'wp-trackback.php',
    'xmlrpc.php',
];

function rrmdir(string $dir): void
{
    foreach (scandir($dir) as $entry) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }
        $path = $dir.'/'.$entry;
        if (is_dir($path) && ! is_link($path)) {
            rrmdir($path);
        } else {
            unlink($path);
        }
    }
    rmdir($dir);
}

echo $dryRun ? "=== MODE SIMULATION (dry_run) — rien n'est supprimé ===\n\n" : "=== SUPPRESSION RÉELLE ===\n\n";

foreach ($targets as $target) {
    $path = __DIR__.'/'.$target;

    if (! file_exists($path) && ! is_link($path)) {
        echo "absent   : {$target}\n";
        continue;
    }

    if ($dryRun) {
        echo (is_dir($path) ? '[dir]  ' : '[file] ')."serait supprimé : {$target}\n";
        continue;
    }

    if (is_dir($path) && ! is_link($path)) {
        rrmdir($path);
    } else {
        unlink($path);
    }
    echo "supprimé : {$target}\n";
}

echo "\n=== Terminé ".($dryRun ? '(simulation)' : '(réel)')." ===\n";
