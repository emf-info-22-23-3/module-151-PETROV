<?php


class SessionManager
{

    // Démarre la session si ce n'est pas déjà fait
    public function destroySession(){
        session_unset();
        session_destroy();
    }

    public function openSession($username, $pk_compte, $est_admin){
        $_SESSION["pk_compte"] = $pk_compte;
        $_SESSION["username"] = $username;
        $_SESSION["est_admin"] = $est_admin;
    }
    public function isConnected(){
        return isset($_SESSION["pk_compte"]);
    }

    public function getPk()
    {
        $retour = 0;
        if (isset($_SESSION["pk_compte"])) {
            $retour = $_SESSION["pk_compte"];
        }
        return (int) $retour;
    }

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