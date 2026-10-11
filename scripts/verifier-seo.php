<?php

/**
 * Vérification SEO de toutes les pages du sitemap.
 *
 * Usage :
 *   php artisan app:generate-sitemap      # génère public/sitemap.xml
 *   php artisan serve                     # dans un autre terminal
 *   php scripts/verifier-seo.php [URL de base, défaut http://127.0.0.1:8000]
 *
 * Les URL du sitemap sont rejouées sur l'URL de base (même chemin), ce qui permet
 * de tester en local un sitemap généré avec l'URL de production.
 *
 * Contrôles par page : code 200, exactement un <h1>, <html lang="fr">, title et
 * meta description non vides et uniques, au moins un JSON-LD valide, absence des
 * motifs interdits (numéro factice, liens vides, « à venir », snippet ns.html).
 * Code de sortie 1 si au moins une erreur.
 */

$base = rtrim($argv[1] ?? 'http://127.0.0.1:8000', '/');

function fetch(string $url): array
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => false, CURLOPT_TIMEOUT => 30]);
    $body = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    return [$status, $body === false ? '' : $body];
}

[$status, $xml] = fetch($base.'/sitemap.xml');
if ($status !== 200 || ! $xml) {
    fwrite(STDERR, "Sitemap introuvable sur {$base}/sitemap.xml (code {$status}). Lancez php artisan app:generate-sitemap.\n");
    exit(1);
}

$sitemap = simplexml_load_string($xml);
$sitemap->registerXPathNamespace('s', 'http://www.sitemaps.org/schemas/sitemap/0.9');
$urls = array_map('strval', $sitemap->xpath('//s:loc'));

$errors = [];
$titles = [];
$descriptions = [];

foreach ($urls as $url) {
    $path = parse_url($url, PHP_URL_PATH) ?: '/';
    [$status, $html] = fetch($base.$path);
    $fail = function (string $message) use (&$errors, $path) {
        $errors[] = "{$path} : {$message}";
    };

    if ($status !== 200) {
        $fail("code HTTP {$status}");
        continue;
    }

    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="UTF-8">'.$html);
    libxml_clear_errors();
    $xpath = new DOMXPath($dom);

    $h1 = $xpath->query('//h1')->length;
    if ($h1 !== 1) {
        $fail("{$h1} balise(s) <h1> au lieu d'une");
    }

    if ($xpath->query('//html[@lang="fr"]')->length !== 1) {
        $fail('<html lang="fr"> absent');
    }

    $title = trim($xpath->query('//title')->item(0)?->textContent ?? '');
    $description = trim($xpath->query('//meta[@name="description"]/@content')->item(0)?->nodeValue ?? '');
    $title === '' ? $fail('title vide') : $titles[$title][] = $path;
    $description === '' ? $fail('meta description vide') : $descriptions[$description][] = $path;

    $jsonLd = $xpath->query('//script[@type="application/ld+json"]');
    if ($jsonLd->length === 0) {
        $fail('aucun JSON-LD');
    }
    foreach ($jsonLd as $script) {
        json_decode($script->textContent);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $fail('JSON-LD invalide : '.json_last_error_msg());
        }
    }

    // Texte visible : sans <script>, <style>, <noscript>
    foreach ($xpath->query('//script|//style|//noscript') as $node) {
        $node->parentNode->removeChild($node);
    }
    $text = $xpath->query('//body')->item(0)?->textContent ?? '';
    foreach (['00 00 00 00', 'ns.html', 'à venir'] as $pattern) {
        if (str_contains($text, $pattern)) {
            $fail("texte interdit visible : « {$pattern} »");
        }
    }
    if (str_contains($html, 'href="#"')) {
        $fail('lien vide href="#"');
    }

    echo ($status === 200 ? '✓' : '✗')." {$path}\n";
}

foreach (['title' => $titles, 'meta description' => $descriptions] as $label => $values) {
    foreach ($values as $value => $paths) {
        if (count($paths) > 1) {
            $errors[] = "{$label} en double (« {$value} ») : ".implode(', ', $paths);
        }
    }
}

echo "\n".count($urls)." page(s) vérifiée(s).\n";

if ($errors) {
    echo count($errors)." erreur(s) :\n - ".implode("\n - ", $errors)."\n";
    exit(1);
}

echo "Aucune erreur.\n";
