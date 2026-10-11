<?php

/*
|--------------------------------------------------------------------------
| Coordonnées et informations légales d'OYETECH
|--------------------------------------------------------------------------
|
| Source unique pour le header, le footer, la page contact, les mentions
| légales, la politique de confidentialité et le JSON-LD. Ne jamais réécrire
| ces valeurs en dur dans les vues : passer par App\Support\Entreprise.
|
| Valeurs en dur (et non via env()) : le .env du serveur n'est pas déployé
| depuis ce dépôt (voir .github/workflows/deploy.yml).
|
| Une chaîne vide = information pas encore fournie par l'agence :
|   - l'élément d'interface correspondant (bouton, icône…) n'est pas affiché ;
|   - les pages légales affichent un repère « [À FOURNIR] ».
|
*/

return [

    'nom' => 'OYETECH',
    'raison_sociale' => 'OYETECH SARL',
    'forme_juridique' => 'Société à responsabilité limitée (SARL)',
    'rccm' => '',
    'capital' => '', // ex. « 1 000 000 FCFA »

    'url' => 'https://www.oyetech-ci.com',

    'adresse' => [
        'rue' => '', // quartier, rue
        'ville' => 'Abidjan',
        'pays' => "Côte d'Ivoire",
        'code_pays' => 'CI',
    ],

    // Format d'affichage : +225 XX XX XX XX XX
    'telephone' => '',

    // Format international sans « + » ni espaces : 225XXXXXXXXXX
    'whatsapp' => '',

    'email' => 'contact@oyetech.ci',

    'responsable_publication' => [
        'nom' => 'Yamoussa KOUYATE',
        'fonction' => 'Fondateur & DG',
    ],

    'fondateurs' => [
        ['nom' => 'Yamoussa KOUYATE', 'fonction' => 'Fondateur & DG'],
    ],

    'hebergeur' => [
        'nom' => '',
        'adresse' => '',
        'site' => '',
    ],

    // URL complète du profil ; vide = réseau non affiché
    'reseaux' => [
        'linkedin' => '',
        'facebook' => '',
        'instagram' => '',
        'x' => '',
    ],

    'annee_creation' => 2012,

    'calendly' => 'https://calendly.com/oyetech',

    // Codes pays ISO 3166-1 alpha-2 (JSON-LD areaServed)
    'zones_intervention' => ['CI', 'SN', 'ML', 'BF', 'TG', 'BJ'],

    'description' => 'Cabinet stratégique et agence digitale à Abidjan : conseil, communication, marketing digital et solutions numériques.',

];
