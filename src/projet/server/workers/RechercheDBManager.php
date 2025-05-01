<?php

/**
 * Classe de gestion des recherches de boissons dans la base de données
 * @author  Tsvetoslav Petrov
 * @version 2.0
 * @package workers
 */
class RechercheDBManager
{
    //Attributs
    private $connexion;

    //Constructeur
    public function __construct()
    {
        $this->connexion = Connexion::getInstance();
    }

    /**
     * Méthode permettant d'effectuer une recherche de boissons dans la base de données
     * 
     * @param string $query Le champ entré dans la recherche
     * @param bool $vinsFilter Filtre pour les vins
     * @param bool $bieresFilter Filtre pour les bières
     * @param bool $spiritueuxFilter Filtre pour les spiritueux
     * @param bool $noAlcoolFilter Filtre pour les boissons non alcoolisées
     * @param string $order Ordre de tri des résultats
     * @param bool $onlyPromotions Indique si seuls les produits en promotion doivent être affichés
     * @return array Résultats de la recherche
     */
    public function effectuerRecherche($searchQuery, $vinsFilter, $bieresFilter, $spiritueuxFilter, $noAlcoolFilter, $order, $onlyPromotions)
    {
        $boissons = [];
        //Requête de base sans filtres d'assortiment pour le moment
        $query = "SELECT DISTINCT boissons.* FROM T_Boisson boissons";
        $params = [];

        //On ajoute un tableau de conditions WHERE
        $whereConditions = [];
        $whereConditions[] = "boissons.quantite_disponible > 0"; //On ne prend que les boissons disponibles

        //Recherche par nom
        if (!empty($searchQuery) && $searchQuery !== '') {
            //Séparation de la recherceh en plusieurs mots
            $searchTerms = explode(' ', $searchQuery);
            $searchConditions = [];

            foreach ($searchTerms as $term) {
                if (strlen(trim($term)) > 0) {
                    $searchConditions[] = "boissons.nom LIKE ?";
                    $params[] = '%' . trim($term) . '%';
                }
            }

            if (!empty($searchConditions)) {
                $whereConditions[] = '(' . implode(' AND ', $searchConditions) . ')';
            }
        }

        //Promotions
        if ($onlyPromotions === 'true') {
            $whereConditions[] = "boissons.est_en_solde = 1";
        }

        //Ajout des conditions WHERE s'il y en a
        if (!empty($whereConditions)) {
            $query .= " WHERE " . implode(" AND ", $whereConditions);
        }

        //Tri
        switch ($order) {
            case 'alpha_asc':
                $query .= " ORDER BY boissons.nom ASC";
                break;
            case 'alpha_desc':
                $query .= " ORDER BY boissons.nom DESC";
                break;
            case 'prix_asc':
                $query .= " ORDER BY boissons.prix ASC";
                break;
            case 'prix_desc':
                $query .= " ORDER BY boissons.prix DESC";
                break;
            default:
                $query .= " ORDER BY boissons.nom ASC";
        }
        
        $resultats = $this->connexion->selectQuery($query, $params);
        //Construction des objets Boisson
        if (is_array($resultats) && !empty($resultats)) {
            foreach ($resultats as $row) {
                $boissons[] = new Boisson(
                    $row["pk_boisson"],
                    $row["nom"],
                    $row["quantite"],
                    $row["prix"],
                    base64_encode($row["image"]),
                    $row["quantite_disponible"],
                    $row["est_en_solde"],
                    $row["informations"],
                    $row["ingredients"],
                    $row["producteur"],
                    $row["region"]
                );
            }
        }

        //Filtrage des boissons par assortiment
        if ($vinsFilter !== 'true' || $bieresFilter !== 'true' || $spiritueuxFilter !== 'true' || $noAlcoolFilter !== 'true') {
            $filteredBoissons = [];
            foreach ($boissons as $boisson) {
                $assortiment = $this->getAssortimentForBoissons($boisson->getPkboisson());
                if (
                    ($assortiment === 'Vins' && $vinsFilter === 'true') ||
                    ($assortiment === 'Bières / Cidres' && $bieresFilter === 'true') ||
                    ($assortiment === 'Spiritueux' && $spiritueuxFilter === 'true') ||
                    ($assortiment === 'Sans Alcool' && $noAlcoolFilter === 'true')
                ) {
                    $filteredBoissons[] = $boisson;
                }
            }
            $boissons = $filteredBoissons;
        }
        return $boissons;
    }


    /**
     * Méthode permettant de récupérer l'assortiment d'une boisson à partir de son identifiant
     * 
     * @param int $pk_boisson Identifiant de la boisson
     * @return string Nom de l'assortiment de la boisson
     */
    private function getAssortimentForBoissons($pk_boisson)
    {
        $query = "SELECT nom
        FROM T_Assortiment assortiments
        JOIN TR_Boisson_Assortiment tba ON assortiments.pk_assortiment = tba.fk_assortiment
        WHERE tba.fk_boisson_assortiment = ?";

        $params = [$pk_boisson];
        $resultat = $this->connexion->selectSingleQuery($query, $params);
        return $resultat ? $resultat['nom'] : '';
    }
}
?>