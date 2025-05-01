<?php


/**
 * Contrôleur de gestion de la session
 * @author  Tsvetoslav Petrov
 * @version 2.0
 * @package controllers
 */
class SessionManager
{
    /**
     * Méthode permettant la suppresison d'une session
     * 
     * @return void
     */
    public function destroySession(){
        session_unset();
        session_destroy();
    }

    /**
     * Méthode permettant la création d'une session
     * 
     * @param string $username Nom d'utilisateur du compte
     * @param string $pk_compte Identifiant du compte
     * @param bool $est_admin Indique si l'utilisateur est un administrateur
     * @return void
     */
    public function openSession($username, $pk_compte, $est_admin){
        $_SESSION["pk_compte"] = $pk_compte;
        $_SESSION["username"] = $username;
        $_SESSION["est_admin"] = $est_admin;
    }

    /**
     * Méthode permettant de vérifier si l'utilisateur est connecté
     * 
     * @return bool l'état de la connexion
     */
    public function isConnected(){
        return isset($_SESSION["pk_compte"]);
    }

    /**
     * Méthode permettant de récupérer l'identifiant de l'utilisateur
     * 
     * @return int L'identifiant de l'utilisateur
     */
    public function getPk()
    {
        $retour = 0;
        if (isset($_SESSION["pk_compte"])) {
            $retour = $_SESSION["pk_compte"];
        }
        return (int) $retour;
    }

    /**
     * Méthode permettant de récupérer la variable "est_admin" de la session
     * 
     * @return mixed false si l'utilisateur n'est pas un administrateur, true sinon
     */
    public function getEstAdmin()
    {
        $retour = false;
        if (isset($_SESSION["est_admin"])) {
            $retour = $_SESSION["est_admin"];
        }
        return $retour;
    }
}
?>