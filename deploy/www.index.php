<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

// TEMPORAIRE — diagnostic d'une erreur 500 muette (pas d'accès aux logs serveur
// sans shell sur cet hébergement). À retirer une fois la cause identifiée.
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
@ini_set('memory_limit', '512M');

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
        echo "\n\n=== ERREUR FATALE CAPTURÉE (www/index.php) ===\n";
        echo "Type: {$error['type']}\n";
        echo "Message: {$error['message']}\n";
        echo "Fichier: {$error['file']}:{$error['line']}\n";
    }
});

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../oyetech-app/storage/framework/maintenance.php')) {
    require $maintenance;
}

try {
    // Register the Composer autoloader...
    require __DIR__.'/../oyetech-app/vendor/autoload.php';

    // Bootstrap Laravel and handle the request...
    /** @var Application $app */
    $app = require_once __DIR__.'/../oyetech-app/bootstrap/app.php';

    $app->handleRequest(Request::capture());
} catch (\Throwable $e) {
    echo "\n=== EXCEPTION (www/index.php) ===\n";
    echo get_class($e).': '.$e->getMessage()."\n";
    echo $e->getFile().':'.$e->getLine()."\n";
    echo $e->getTraceAsString()."\n";
}
