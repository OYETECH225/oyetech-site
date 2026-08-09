# Déploiement OYETECH — Hébergement mutualisé OVH (Perso, sans shell)

Cet hébergement ne donne **aucun accès shell** : la connexion SSH ne fournit
que du SFTP (transfert de fichiers), pas de terminal. Impossible donc de
lancer `composer install`, `git pull` ou `php artisan` directement sur le
serveur. Le déploiement repose sur le même mécanisme que celui utilisé pour
IlePay sur ce type d'hébergement : **build en CI (GitHub Actions), upload par
SFTP, puis un hook HTTP protégé par token qui termine le travail côté
serveur** (extraction, migrations, caches).

## Architecture

Deux dossiers frères sur l'hébergement :

```
www/                    <- racine web du domaine oyetech-ci.com (déjà en place chez OVH)
laravel-app/             <- code Laravel complet (non exposé publiquement)
   deploy/remote-deploy-hook.php
```

`www/index.php` est une version modifiée qui charge `laravel-app/vendor/autoload.php`
et `laravel-app/bootstrap/app.php` au lieu des chemins par défaut (voir
`deploy/www.index.php`). `www/deploy-hook.php` est le déclencheur HTTP protégé
par token (voir `deploy/www.deploy-hook.php`), qui appelle
`laravel-app/deploy/remote-deploy-hook.php`.

## Pourquoi des ZIP plutôt que du SFTP fichier par fichier

`vendor/` contient des dizaines de milliers de petits fichiers ; les envoyer
un par un en SFTP (pas de pipelining, pas de shell distant pour un vrai
`rsync`) serait beaucoup trop lent. Le workflow empaquette donc tout en deux
archives (`laravel-app.zip`, `www.zip`), envoyées chacune en un seul
aller-retour réseau, puis extraites côté serveur par
`deploy/remote-deploy-hook.php` via `ZipArchive`.

## Comment un déploiement se déroule (à chaque push sur `main`)

1. GitHub Actions installe les dépendances, build les assets Vite, fait tourner les tests.
2. Réinstalle les dépendances PHP en mode production (`--no-dev`).
3. Empaquette `laravel-app.zip` (tout le dépôt, sans `.git`, `node_modules`, `tests`, `.env`, et sans écraser les uploads déjà présents dans `storage/app/public`) et `www.zip` (contenu de `public/` + `index.php` et `deploy-hook.php` adaptés).
4. Injecte le secret `DEPLOY_HOOK_TOKEN` dans `deploy-hook.php` juste avant l'envoi (jamais committé — le dépôt ne contient qu'un placeholder `CHANGE-ME-AT-DEPLOY-TIME`).
5. Envoie les deux ZIP dans `laravel-app/`, le hook logique dans `laravel-app/deploy/`, et les 3 fichiers de bootstrap (`index.php`, `deploy-hook.php`, `.htaccess`) directement dans `www/` — ces 3 derniers hors ZIP, pour que le tout premier déploiement puisse s'amorcer tout seul.
6. Appelle `https://www.oyetech-ci.com/deploy-hook.php` avec l'en-tête `X-Deploy-Token`, ce qui déclenche côté serveur : extraction des deux ZIP, `migrate --force`, `optimize:clear`, `config:cache`, `route:cache`, `view:cache`.

## Photos / médias sans `storage:link`

Pas de shell = pas de `php artisan storage:link`, et un lien symbolique créé
par ZIP/SFTP ne survivrait de toute façon pas au transfert. Le disque
`public` a donc `'serve' => true` dans `config/filesystems.php` : Laravel sert
directement les fichiers de `storage/app/public` via sa route native
`storage/{path}`, sans symlink ni configuration serveur particulière — c'est
ce que fait déjà `remote-deploy-hook.php` (voir sa section "Lien storage").

## Secrets GitHub à configurer (Settings > Secrets and variables > Actions)

| Secret | Valeur |
|---|---|
| `OVH_SFTP_HOST` | hôte SFTP OVH, ex. `ftp.clusterXXX.hosting.ovh.net` |
| `OVH_SFTP_USERNAME` | identifiant FTP-SSH OVH |
| `OVH_SFTP_PORT` | généralement `22` |
| `OVH_SFTP_PASSWORD` | mot de passe FTP-SSH OVH |
| `DEPLOY_HOOK_TOKEN` | chaîne aléatoire longue, générée une fois (ex. `openssl rand -hex 32`) |
| `APP_URL` | `https://www.oyetech-ci.com` |

## À faire avant le tout premier déploiement automatique

1. **Pousser ce dépôt sur GitHub** (actuellement aucun commit / aucun remote configuré en local) et configurer les secrets ci-dessus.
2. Dans le manager OVH, vérifier que l'extension PHP **zip** est activée (Hébergement > PHP > Extensions) — `remote-deploy-hook.php` en dépend pour extraire les archives.
3. Vérifier que l'extension **gd** est activée (nécessaire aux conversions d'images Spatie Media Library, ex. webp).
4. Nettoyer le contenu par défaut actuellement présent dans `www/` (page OVH par défaut) avant le premier push.
5. Créer le fichier `.env` réel en le déposant manuellement dans `laravel-app/.env` par SFTP (il n'est jamais généré par la CI) — reprendre `.env.example`, renseigner `DB_*`, `MAIL_*`, `APP_KEY` (généré une fois en local avec `php artisan key:generate --show`), `GTM_ID`, `GA4_ID`, `META_PIXEL_ID`, `LINKEDIN_PARTNER_ID`, `CALENDLY_URL`.
6. `APP_ENV=production`, `APP_DEBUG=false` dans ce `.env`.
7. Premier push sur `main` : le workflow crée toute l'arborescence (`laravel-app/`, contenu de `www/`) et lance `migrate --force` — équivalent du `db:seed` à faire une fois manuellement si besoin (pas d'artisan CLI disponible ; possibilité d'ajouter un appel `Artisan::call('db:seed', ['--force' => true])` ponctuel dans le hook, à retirer ensuite).

## Queue & mail

`QUEUE_CONNECTION=sync` : les emails (formulaire de contact) sont envoyés
directement dans la requête HTTP, sans worker à superviser — obligatoire ici
puisqu'il n'y a ni shell ni cron garanti pour faire tourner un worker de queue.

## Sécurité

- `deploy-hook.php` reste accessible publiquement en permanence, protégé
  uniquement par le token (comparaison `hash_equals`, en-tête HTTP jamais en
  query string pour ne pas finir dans les logs Apache) — compromis inévitable
  sur un hébergement mutualisé sans shell.
- `.env` n'est jamais committé, jamais généré par la CI, et n'existe que sur
  le serveur (déposé manuellement une fois, jamais écrasé par les déploiements suivants).
- `APP_DEBUG=false` en production.
