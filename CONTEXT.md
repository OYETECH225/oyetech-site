# OYETECH — Site vitrine

Site vitrine Laravel de l'agence digitale et cabinet stratégique OYETECH, basée à Abidjan (Côte d'Ivoire). Présente l'offre de services, le portfolio et le blog de l'agence auprès de PME, grandes entreprises et institutions d'Afrique de l'Ouest.

## Language

**Pôle**:
Une division métier de l'agence (ex. Conseil & Stratégie, Solutions Numériques). Chaque pôle a sa propre page publique et regroupe un ou plusieurs services et projets. Le nombre de pôles est délibérément limité (5 actuellement) car chaque pôle implique une route, une entrée de navigation et une entrée dans plusieurs formulaires admin — ce n'est pas un simple tag.
_Avoid_: Département, division, catégorie

**Service**:
Une offre commerciale packagée, rattachée à un pôle, affichée avec un résumé, une description longue et une liste de livrables. Géré via Filament (`ServiceResource`).
_Avoid_: Offre, prestation (au singulier générique)

**Livrable**:
Un élément concret de ce qu'un service produit pour le client, affiché en liste courte (ex. "Développement web", "Automatisation IA"). Volontairement formulé en 1-3 mots, orienté bénéfice plutôt que jargon technique/outil.
_Avoid_: Feature, prestation, deliverable

**Projet** (portfolio):
Une étude de cas client réelle, rattachée à un pôle par jointure logique (pas de clé étrangère), affichée dans la section "Cas clients" de la page pôle correspondante.
_Avoid_: Case study, réalisation

## Relationships

- Un **Pôle** regroupe un ou plusieurs **Services** et **Projets** (jointure par le champ `pole`, pas de clé étrangère)
- Un **Service** a plusieurs **Livrables** (tableau JSON, pas une relation Eloquent)
- Un **Projet** est une preuve client réelle — ne jamais créer de projet avec des résultats chiffrés fictifs pour une offre sans mission réalisée

## Example dialogue

> **Dev:** "On ajoute l'automatisation IA/n8n comme nouveau **Pôle** ?"
> **Domain expert:** "Non, comme **Livrable** du **Service** Solutions Numériques — c'est réversible, ça sort en quelques minutes, on promeut en **Pôle** plus tard si le volume de missions le justifie." (voir [ADR 0001](docs/adr/0001-automatisation-ia-livrable-solutions-numeriques.md))

## Flagged ambiguities

- "Automatisation IA" est un **Livrable** sans **Projet** associé pour l'instant (offre nouvellement lancée, aucune mission réelle livrée) — ne pas fabriquer de cas client avec résultats chiffrés tant qu'une mission réelle n'a pas été réalisée.
