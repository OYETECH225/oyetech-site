# Automatisation IA lancée comme livrable de Solutions Numériques, pas comme pôle indépendant

OYETECH lance une offre d'automatisation de processus par IA (n8n) et devait décider si elle constitue un 6ᵉ pôle indépendant ou un livrable du pôle Solutions Numériques existant. Créer un pôle implique de toucher ~10 fichiers codés en dur (routes, `ServiceController`, `Service::getUrlAttribute()`, 3 Filament Resources, navbar, footer, formulaire de contact, `GenerateSitemap`, compteur `Pôle 0X/05` dans `_pole.blade.php`) et de renuméroter "0X/05" en "0X/06".

Décision : ajouter "Automatisation IA" comme livrable du service Solutions Numériques (`Service::deliverables`), sans nouvelle route ni nouveau pôle. C'est réversible et sort en quelques minutes ; on promeut au rang de pôle plus tard si le volume de missions le justifie.

Conséquence : cette offre n'a pas de projet portfolio associé (aucune mission réelle livrée à ce jour). Ne pas créer de cas client fictif avec résultats chiffrés pour ce livrable tant qu'une mission réelle n'a pas été réalisée — voir [CONTEXT.md](../../CONTEXT.md).
