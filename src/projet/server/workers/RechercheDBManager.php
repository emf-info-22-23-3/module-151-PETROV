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

        // Étape 1 : Détermination des assortiments à INCLURE (logique inversée)
        $includedAssortiments = [];
        if ($vinsFilter) {
            $includedAssortiments[] = 'Vins';
        }
        if ($bieresFilter) {
            $includedAssortiments[] = 'Bières / Cidres';
        }
        if ($spiritueuxFilter) {
            $includedAssortiments[] = 'Spiritueux';
        }
        if ($noAlcoolFilter) {
            $includedAssortiments[] = 'Sans Alcool';
        }

        // Étape 2 : Requête de base
        $query = "SELECT DISTINCT boissons.*
        FROM T_Boisson boissons
        LEFT JOIN TR_Boisson_Assortiment tba ON boissons.pk_boisson = tba.fk_boisson_assortiment
        LEFT JOIN T_Assortiment assortiments ON tba.fk_assortiment = assortiments.pk_assortiment
        WHERE 1=1
    ";

        $params = [];

        // Étape 3 : Filtres à inclure (approche différente)
        if (!empty($includedAssortiments)) {
            $placeholders = implode(',', array_fill(0, count($includedAssortiments), '?'));
            $query .= " AND assortiments.nom IN ($placeholders)";
            $params = array_merge($params, $includedAssortiments);
        } else {
            // Si aucun filtre n'est sélectionné, ne retourner aucun résultat
            return [];
        }

        // Étape 4 : Recherche par nom
        if (!empty($searchQuery)) {
            $query .= " AND boissons.nom LIKE ?";
            $params[] = '%' . $searchQuery . '%';
        }

        // Étape 5 : Promotions
        if ($onlyPromotions) {
            $query .= " AND boissons.est_en_solde = 1";
        }

        // Étape 6 : Tri (sécurisé)
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
        return $boissons;
    }
}
?>