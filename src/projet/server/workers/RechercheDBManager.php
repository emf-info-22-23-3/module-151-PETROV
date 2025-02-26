<?php
class RechercheDBManager
{
    public function __construct()
    {

    }

    public function getBoissons($query, $filtres, $ordre, $uniquementEnPromotion)
    {
        $boissons = array();
        $query = "";
        if ($uniquementEnPromotion) {
            $query = `SELECT * FROM T_Boisson boissons
                        LEFT JOIN 'TR_Boisson_Assortiment' 
                            ON pk_boisson = fk_boisson
                        LEFT JOIN 'mydb'.'T_Assortiment' assortiments
                            ON fk_assortiment = pk_assortiment
                    WHERE (assortiments.nom NOT IN ('?') OR assortiments.nom IS NULL)
                        AND boissons.nom LIKE ?
                        AND boissons.estEnSolde = 1
                    ORDER BY ?`;
        } else {
            $query = `SELECT * FROM T_Boisson boissons
                        LEFT JOIN 'TR_Boisson_Assortiment' 
                            ON pk_boisson = fk_boisson
                        LEFT JOIN 'mydb'.'T_Assortiment' assortiments
                            ON fk_assortiment = pk_assortiment
                    WHERE (assortiments.nom NOT IN ('?') OR assortiments.nom IS NULL)
                        AND boissons.nom LIKE ?
                    ORDER BY ?`;
        }
        
        $connexion = Connexion::getInstance();
        $filtresString = implode("', '", $filtres);
        $params = [$filtresString, $query, $ordre];

        $resultats = $connexion->selectQuery($query, $params);
        if ($resultats->rowCount() > 0) {
            foreach ($resultats as $row) {
                $boisson = new Boisson($row["pk_boisson"], $row["nom"], $row["quantite"], $row["prix"], $row["image"], $row["quantiteDisponible"], $row["estEnSolde"], $row["informations"], $row["ingredients"], $row["producteur"], $row["region"]);
                array_push($boissons,$boisson);
            }   
        }
        return $boissons;
    }
}
?>