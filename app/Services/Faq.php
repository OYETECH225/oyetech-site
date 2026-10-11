<?php

namespace App\Services;

/**
 * Source unique des FAQ : le composant <x-faq> affiche ces questions ET en
 * dérive le JSON-LD FAQPage, pour que les deux restent toujours identiques.
 *
 * Format d'un item : ['q' => question, 'a' => réponse en texte brut,
 * 'liens' => [texte présent dans la réponse => URL]] (liens optionnels).
 */
class Faq
{
    public function __construct(private Entreprise $entreprise) {}

    public function accueil(): array
    {
        $calendly = $this->entreprise->calendly();

        return [
            ['q' => 'Quels types d\'entreprises accompagnez-vous ?', 'a' => 'Nous travaillons avec des PME, grandes entreprises, institutions publiques et startups, en Afrique.'],
            ['q' => 'Combien de temps dure une mission type ?', 'a' => 'Cela dépend du pôle et du périmètre : de quelques semaines pour une campagne de communication à plusieurs mois pour une transformation digitale complète.'],
            ['q' => 'Travaillez-vous avec des clients hors de Côte d\'Ivoire ?', 'a' => 'Oui. Notre agence est implantée à Abidjan, mais nous intervenons auprès de clients partout en Afrique, à distance ou avec des déplacements ponctuels selon les besoins.'],
            [
                'q' => 'Comment se déroule la première prise de contact ?',
                'a' => $calendly
                    ? 'Vous remplissez le formulaire de contact ou réservez un créneau via Calendly. Notre équipe revient vers vous en moins de 48h pour cadrer votre besoin.'
                    : 'Vous remplissez le formulaire de contact. Notre équipe revient vers vous en moins de 48h pour cadrer votre besoin.',
                'liens' => array_filter(['formulaire de contact' => route('contact'), 'Calendly' => $calendly]),
            ],
        ];
    }

    public function pole(string $nomPole): array
    {
        return [
            ['q' => 'Comment se déroule le démarrage d\'une mission '.$nomPole.' ?', 'a' => 'Un premier échange permet de cadrer vos objectifs et votre contexte. Nous proposons ensuite une feuille de route avec un périmètre et un calendrier clairs.'],
            ['q' => 'Travaillez-vous avec des entreprises de toute taille ?', 'a' => 'Oui, nos méthodes s\'adaptent aussi bien aux startups qu\'aux grandes entreprises et institutions.'],
            ['q' => 'Peut-on combiner ce pôle avec d\'autres expertises OYETECH ?', 'a' => 'Tout à fait, c\'est même notre approche par défaut : nos pôles travaillent ensemble dès que votre projet le nécessite.'],
        ];
    }

    public function ilepay(): array
    {
        return [
            ['q' => 'Quels paiements puis-je effectuer avec Ilepay ?', 'a' => 'Ilepay permet le paiement des loyers, charges et frais de contrat de location, par carte bancaire ou mobile money.'],
            ['q' => 'Qui peut utiliser Ilepay ?', 'a' => 'Ilepay s\'adresse aux propriétaires individuels, aux agences et gestionnaires de biens immobiliers, ainsi qu\'aux locataires en Côte d\'Ivoire.'],
            ['q' => 'Combien de temps prend l\'intégration pour une agence ?', 'a' => 'La mise en place se fait généralement en quelques jours, avec l\'accompagnement de notre équipe pour la reprise des contrats existants.'],
            ['q' => 'Ilepay est-il sécurisé ?', 'a' => 'Oui, Ilepay respecte les standards de sécurité du secteur (chiffrement des transactions, conformité PCI-DSS des partenaires bancaires).'],
            ['q' => 'Ilepay proposera-t-il d\'autres paiements à l\'avenir ?', 'a' => 'Oui, Ilepay a vocation à évoluer progressivement pour faciliter d\'autres types de paiements et de services financiers du quotidien, avec une gestion centralisée des transactions et des justificatifs.'],
        ];
    }
}
