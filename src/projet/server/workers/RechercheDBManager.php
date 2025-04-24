<?php
class RechercheDBManager
{
    private $connexion;
    public function __construct()
    {
        $this->connexion = Connexion::getInstance();
    }

    public function effectuerRecherche($searchQuery, $vinsFilter, $bieresFilter, $spiritueuxFilter, $noAlcoolFilter, $order, $onlyPromotions)
    {
        $boissons = [];
        //Requête de base sans filtres d'assortiment pour le moment
        $query = "SELECT DISTINCT boissons.* FROM T_Boisson boissons";
        $params = [];

        //On ajoute un tableau de conditions WHERE
        $whereConditions = [];

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