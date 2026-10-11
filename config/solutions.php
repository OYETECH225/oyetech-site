<?php

/*
|--------------------------------------------------------------------------
| Pôle Solutions Numériques : technologies et offres
|--------------------------------------------------------------------------
|
| Contenu de la page /services/solutions-numeriques, modifiable ici sans
| toucher aux vues. Pas de logo de marque (autorisation d'usage requise).
|
*/

return [

    // Technologies maîtrisées, regroupées par usage — liste à ajuster par l'agence
    'technologies' => [
        [
            'usage' => 'Sites vitrines et CMS',
            'phrase' => 'Des sites rapides et faciles à mettre à jour par vos équipes, sans dépendre d\'un développeur.',
            'technos' => ['WordPress'],
        ],
        [
            'usage' => 'Applications web métier',
            'phrase' => 'Des outils sur mesure qui épousent vos processus : back-offices, portails clients, plateformes SaaS.',
            'technos' => ['Laravel', 'React / Next.js'],
        ],
        [
            'usage' => 'E-commerce',
            'phrase' => 'Des boutiques en ligne pensées pour les usages locaux, du catalogue au paiement.',
            'technos' => ['WordPress', 'Laravel'],
        ],
        [
            'usage' => 'Applications mobiles',
            'phrase' => 'Une seule base de code pour Android et iOS, publiée sur les stores.',
            'technos' => ['Flutter', 'React Native'],
        ],
        [
            'usage' => 'Automatisations',
            'phrase' => 'Des tâches répétitives confiées à des flux automatisés et connectés à vos outils.',
            'technos' => ['n8n', 'Laravel'],
        ],
    ],

    // Offres : 'delai' (texte, ex. « 4 à 6 semaines ») reste à null tant que
    // l'agence ne l'a pas validé — il n'est alors pas affiché. Pas de prix.
    'offres' => [
        'site-vitrine' => [
            'titre' => 'Site vitrine',
            'pour_qui' => 'PME, indépendants et institutions qui veulent une présence en ligne crédible et autonome.',
            'livrables' => ['Design sur mesure, adapté au mobile', 'Gestion des contenus par vos équipes', 'Référencement naturel de base', 'Formulaire de contact', 'Mise en ligne et prise en main'],
            'delai' => null,
        ],
        'site-e-commerce' => [
            'titre' => 'Site e-commerce',
            'pour_qui' => 'Commerçants, distributeurs et marques qui veulent vendre en ligne.',
            'livrables' => ['Catalogue produits', 'Panier et commande', 'Paiement en ligne (mobile money, carte)', 'Suivi des commandes et des stocks', 'Prise en main de la boutique'],
            'delai' => null,
        ],
        'application-web-metier' => [
            'titre' => 'Application web métier',
            'pour_qui' => 'Entreprises et institutions dont les processus ne rentrent pas dans un logiciel standard.',
            'livrables' => ['Cadrage fonctionnel', 'Application sur mesure', 'Gestion des rôles et des accès', 'Connexion à vos outils (API)', 'Documentation'],
            'delai' => null,
        ],
        'application-mobile' => [
            'titre' => 'Application mobile',
            'pour_qui' => 'Organisations qui veulent servir leurs clients ou leurs équipes directement sur smartphone.',
            'livrables' => ['Application Android et iOS', 'Back-office de gestion', 'Notifications', 'Publication sur les stores'],
            'delai' => null,
        ],
        'maintenance-tma' => [
            'titre' => 'Maintenance & TMA',
            'pour_qui' => 'Sites et applications en production qui doivent rester sûrs, à jour et évoluer.',
            'livrables' => ['Mises à jour de sécurité', 'Sauvegardes et supervision', 'Corrections', 'Évolutions planifiées', 'Support'],
            'delai' => null,
        ],
    ],

];
