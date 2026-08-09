<?php

// Déclencheur HTTP de déploiement — appelé automatiquement par GitHub Actions
// après chaque upload SFTP réussi (voir .github/workflows/deploy.yml).
//
// Ce fichier est déployé en tant que www/deploy-hook.php. Le workflow CI
// remplace le placeholder ci-dessous par le secret GitHub `DEPLOY_HOOK_TOKEN`
// juste avant l'upload — la vraie valeur n'est donc jamais committée dans Git.

$secret = 'CHANGE-ME-AT-DEPLOY-TIME';

// Le token passe par un en-tête HTTP (pas en query string) pour éviter qu'il ne
// finisse en clair dans les logs d'accès Apache/OVH.
if (! hash_equals($secret, $_SERVER['HTTP_X_DEPLOY_TOKEN'] ?? '')) {
    http_response_code(404);
    exit('Not found');
}

require __DIR__.'/../oyetech-app/deploy/remote-deploy-hook.php';
