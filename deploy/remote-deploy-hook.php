<?php

// Point d'entrée de déploiement, appelé après chaque upload SFTP réussi par le
// workflow GitHub Actions (.github/workflows/deploy.yml). Rappelé à chaque
// déploiement : extraction des archives, migrations, nettoyage de l'ancien lien
// storage (voir config/filesystems.php, disque "public"), caches.
//
// Ce fichier vit dans oyetech-app/deploy/ (non exposé publiquement). Le point
// d'entrée HTTP protégé par token est deploy/www.deploy-hook.php, déployé en tant
// que www/deploy-hook.php.
//
// L'upload SFTP de milliers de petits fichiers vendor/ un par un est bien trop
// lent sur un hébergement mutualisé (pas de pipelining, pas de shell distant).
// Le workflow envoie donc deux archives ZIP (oyetech-app.zip, www.zip)
// qui sont extraites ici, côté serveur, via ZipArchive — un seul aller-retour
// réseau au lieu de plusieurs milliers.

header('Content-Type: text/plain');

// Les erreurs ne sont jamais affichées publiquement (endpoint accessible sans
// auth forte, protégé uniquement par le token) — elles sont journalisées dans
// oyetech-app/storage/logs/deploy-hook.log pour être consultées après coup.
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__.'/../storage/logs/deploy-hook.log');
error_reporting(E_ALL);
@ini_set('memory_limit', '512M');
@set_time_limit(120);

if (! class_exists('ZipArchive')) {
    http_response_code(500);
    exit("L'extension PHP zip (ZipArchive) n'est pas activée sur ce serveur. Active-la dans l'espace client OVH (PHP > Extensions) avant de redéployer.\n");
}

// 1) Extraction — AVANT tout require de vendor/autoload.php, pour ne jamais
//    charger l'ancien code en mémoire avant que les nouveaux fichiers soient en place.
function extractDeployZip(string $zipPath, string $target, string $label): bool
{
    if (! file_exists($zipPath)) {
        echo "=== {$label} : rien à extraire (fichier absent, pas de changement) ===\n";
        return true;
    }

    $zip = new ZipArchive();
    if ($zip->open($zipPath) !== true) {
        echo "=== {$label} : ÉCHEC ouverture {$zipPath} ===\n";
        return false;
    }

    $ok = $zip->extractTo($target);
    $zip->close();

    if ($ok) {
        unlink($zipPath);
        echo "=== {$label} : extrait avec succès dans {$target} ===\n";
    } else {
        echo "=== {$label} : ÉCHEC extraction dans {$target} ===\n";
    }

    return $ok;
}

$appOk = extractDeployZip(__DIR__.'/../oyetech-app.zip', __DIR__.'/..', 'Application (oyetech-app)');
$webrootOk = extractDeployZip(__DIR__.'/../www.zip', __DIR__.'/../../www', 'Dossier public (www)');

// Le ZIP exclut le contenu de storage/framework/{cache,sessions,testing,views}
// et storage/logs (voir .github/workflows/deploy.yml) pour ne jamais écraser
// les fichiers gérés par le serveur — mais ça veut dire que ces dossiers eux-
// mêmes peuvent ne pas exister après une extraction sur un dossier vierge, ce
// que Laravel exige (ex: le compilateur Blade échoue sans storage/framework/views).
foreach ([
    'storage/framework/cache/data',
    'storage/framework/sessions',
    'storage/framework/testing',
    'storage/framework/views',
    'storage/logs',
    'bootstrap/cache',
] as $dir) {
    $path = __DIR__.'/../'.$dir;
    if (! is_dir($path)) {
        mkdir($path, 0775, true);
    }
}

// OVH garde parfois en cache l'ancien contenu des fichiers réécrits.
if (function_exists('opcache_reset')) {
    @opcache_reset();
}

if (! $appOk) {
    http_response_code(500);
    exit("\nExtraction de l'application échouée — migrations et caches annulés par sécurité.\n");
}

// 2) Le nouveau code est en place : on démarre Laravel avec le vendor/ à jour.
try {
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
} catch (\Throwable $e) {
    error_log('Démarrage Laravel échoué : '.$e->getMessage()."\n".$e->getTraceAsString());
    http_response_code(500);
    exit("\nDémarrage de Laravel échoué — voir storage/logs/deploy-hook.log et storage/logs/laravel.log.\n");
}

echo "\n=== Migrations ===\n";
try {
    Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    echo Illuminate\Support\Facades\Artisan::output();
} catch (\Throwable $e) {
    error_log('Migrations échouées : '.$e->getMessage()."\n".$e->getTraceAsString());
    echo "ÉCHEC des migrations — voir storage/logs/deploy-hook.log.\n";
}

// Apache peut refuser de traverser www/storage (FollowSymLinks non permis via
// .htaccess sur ce plan OVH). Les fichiers sont servis par la route Laravel
// native storage/{path} (disque "public", 'serve' => true dans
// config/filesystems.php), donc ce lien n'est pas nécessaire — pire, s'il
// traîne, Apache peut bloquer /storage/... avant que la requête n'atteigne
// index.php. On le retire s'il existe.
echo "\n=== Lien storage (obsolète — servi par la route Laravel storage/{path} désormais) ===\n";
$link = __DIR__.'/../../www/storage';

if (is_link($link)) {
    if (unlink($link)) {
        echo "Ancien lien symbolique supprimé : {$link}\n";
    } else {
        echo "ÉCHEC de la suppression du lien symbolique.\n";
    }
} else {
    echo "Aucun lien à supprimer.\n";
}

echo "\n=== Rafraîchissement des caches ===\n";
$exitCodes = [
    'optimize:clear' => Illuminate\Support\Facades\Artisan::call('optimize:clear'),
    'config:cache' => Illuminate\Support\Facades\Artisan::call('config:cache'),
    'route:cache' => Illuminate\Support\Facades\Artisan::call('route:cache'),
    'view:cache' => Illuminate\Support\Facades\Artisan::call('view:cache'),
];

foreach ($exitCodes as $command => $exitCode) {
    if ($exitCode !== 0) {
        error_log("Commande {$command} a échoué (code {$exitCode}) : ".Illuminate\Support\Facades\Artisan::output());
        echo "ÉCHEC {$command} (code {$exitCode}) — voir storage/logs/deploy-hook.log.\n";
    }
}

echo "Caches config/route/view régénérés.\n";

echo "\n=== Terminé ===\n";
