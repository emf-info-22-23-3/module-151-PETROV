<?php
require_once 'controllers/SessionManager.php';
require_once 'controllers/BoissonManager.php';
//require_once 'controllers/CommandeManager.php';
require_once 'controllers/CompteManager.php';
require_once 'controllers/PanierManager.php';
require_once 'controllers/RechercheManager.php';
require_once 'beans/Compte.php';
require_once 'beans/Boisson.php';


$action = "";
if (isset($_POST["action"])) {
    $action = $_POST["action"];
}

if (isset($_GET["action"])) {
    $action = $_GET["action"];
}

switch ($action) {
    case "recherche":
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $query = '';
            if (isset($_GET["query"])) {
                $query = $_GET["query"];
            }

            $filtres = array("Vins", "Bières / Cidres", "Spiritueux", "Sans Alcool");
            if (isset($_GET["disabledFilters"])) {
                $filtresDesactives = $_GET["disabledFilters"];
                $filtresDesactives = explode(',', $filtresDesactives);
                $filtres = $filtresDesactives;
            }

            $ordre = "AZ";
            if (isset($_GET["ordre"])) {
                $ordre = $_GET["ordre"];
                switch ($ordre) {
                    case "AZ":
                        $ordre = "boissons.nom ASC";
                        break;
                    case "ZA":
                        $ordre = "boissons.nom DESC";
                        break;
                    case "PrixCroissant":
                        $ordre = "prix ASC";
                        break;
                    case "PrixDecroissant":
                        $ordre = "prix DESC";
                        break;
                    default:
                        http_response_code(400);
                        echo json_encode(array("resultat" => false, "error" => "Identifiants invalides"));
                        exit;
                }
            }

            $uniquementEnPromotion = false;
            if (isset($_GET["uniquementEnPromotion"])) {
                $ordre = $_GET["uniquementEnPromotion"];
            }

            $messageManager = new RechercheManager();
            $boissons = $messageManager->getBoissons($query, $filtres, $ordre, $uniquementEnPromotion);
            if (count($boissons) > 0) {
                http_response_code(200);
                echo json_encode(array("resultat" => true, "boissons" => $boissons));
            } else {
                http_response_code(404);
                echo json_encode(array("resultat" => false, "error" => "Aucune boisson trouvée"));
            }
        }
        break;
    case "login":
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sessionManager = new SessionManager();
            
            if (!$sessionManager->isConnected()) {

                if (!isset($_POST['username']) || !isset($_POST['password']) || empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
                    http_response_code(400);
                    echo json_encode(array("resultat" => false, "error" => "Champ(s) vides"));
                    break;
                }

                $compteManager = new CompteManager();
                $compte = $compteManager->checkLogin(trim($_POST['username']), $_POST['password']);

                if ($compte != null) {
                    $sessionManager->openSession($compte->getNomUtilisateur(), $compte->getPkCompte(), $compte->getEstAdmin());
                    http_response_code(200);
                    echo json_encode(array("resultat" => true, "success" => "Connexion réussie"));
                   
                } else {
                    http_response_code(400);
                    echo json_encode(array("resultat" => false, "error" => "Identifiants invalides"));
                }
            } else {
                http_response_code(409);
                echo json_encode(array("resultat" => false, "error" => "Vous êtes déjà connectés"));
            }

        }
        break;
    case "checkUser":
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $sessionManager = new SessionManager();
            if ($sessionManager->isConnected()) {
                http_response_code(200);
                echo json_encode(array("resultat" => true, "estAdmin" => $sessionManager->getEstAdmin()));
                break;
            } else {
                http_response_code(200);
                echo json_encode(array("resultat" => false, "estAdmin" => false));
                break;
            }
        }
        break;
    case "deconnecter":
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sessionManager = new SessionManager();
            if ($sessionManager->isConnected()) {
                $sessionManager->destroySession();
                http_response_code(200);
                echo json_encode(array("resultat" => true, "success" => "Déconnexion réussie"));
                break;
            } else {
                http_response_code(401);
                echo json_encode(array("resultat" => false, "error" => "Vous n'êtes pas connectés"));
                break;
            }
        }
        break;
    case "creationCompte":
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sessionManager = new SessionManager();
            if ($sessionManager->isConnected()) {
                if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['passwordConfirm']) || empty(trim($_POST['username'])) || empty(trim($_POST['password'])) || empty(trim($_POST['passwordConfirm']))) {
                    http_response_code(400);
                    echo json_encode(array("resultat" => false, "error" => "Identifiants invalides"));
                }
                $username = "";
                $password = "";
                $passwordConfirm = "";
                if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['passwordConfirm'])) {
                    $compteManager = new CompteManager();
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $passwordConfirm = $_POST['passwordConfirm'];
                    if ($password !== $passwordConfirm) {
                        http_response_code(400);
                        echo json_encode(array("resultat" => false, "error" => "Les mots de passent ne sont pas identiques"));
                    } else {
                        if (!$compteManager->ajouterCompte($username, $password)) {
                            http_response_code(409);
                            echo json_encode(array("resultat" => false, "error" => "Le nom d'utilisater entré existe déjà"));
                        } else {
                            http_response_code(201);
                            echo json_encode(array("resultat" => true, "error" => "Le compte a été créé"));
                        }
                    }
                }
            } else {
                http_response_code(403);
                echo json_encode(array("resultat" => false, "error" => "Veuillez vous déconnecter avant de créer un compte."));
            }
        }
        break;
    case "ajouterBoisson":
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['pk_boisson']) && isset($_POST['quantite'])) {
                $pk_boisson = $_POST['pk_boisson'];
                $quantite = $_POST['quantite'];
                $sessionManager = new SessionManager();
                if ($sessionManager->isConnected(/*.......*/)) {
                    $boissonManager = new BoissonManager();
                    $boisson = $boissonManager->getBoisson($pk_boisson);
                    if ($boisson != null) {
                        if ($boisson->getQuantite() >= $quantite) {
                            $panierManager = new PanierManager();
                            $panier = $panierManager->getPanierUnvalidated($sessionManager->getPk());
                            if ($panier === null) {
                                $panier = $panierManager->ajouterPanier(/*pk_compte*/);
                            }
                            $panierManager->ajouterBoisson($pk_boisson, $quantite, $panier->getPk());
                            $boissonManager->setQuantite($pk_boisson, $quantite);
                            http_response_code(200);
                            echo json_encode(array("resultat" => false, "error" => "Boisson ajoutée au panier"));
                        } else {
                            http_response_code(400);
                            echo json_encode(array("resultat" => false, "error" => "Quantité choisie invalide"));
                        }
                    } else {
                        http_response_code(404);
                        echo json_encode(array("resultat" => false, "error" => "Boisson introuvable"));
                    }
                } else {
                    http_response_code(401);
                    echo json_encode(array("resultat" => false, "error" => "Session invalide"));
                }
            } else {
                http_response_code(400);
                echo json_encode(array("resultat" => false, "error" => "Paramètres de la requête invalides"));
            }
        }
        break;
    case "effectuerCommande":
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sessionManager = new SessionManager();
            if ($sessionManager->isConnected()) {
                if (isset($_POST['pk_panier'])) {
                    $pk_panier = $_POST['pk_panier'];
                    $commandeManager = new CommandeManager();
                    if (isset($_POST['code_reduction'])) {

                    }
                    if ($commandeManager->SetAsValidated(/*$pk_compte*/)) {
                        http_response_code(200);
                        echo json_encode(array("resultat" => false, "error" => "Commande effectuée"));
                    } else {
                        http_response_code(404);
                        echo json_encode(array("resultat" => false, "error" => "Panier introuvable"));
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(array("resultat" => false, "error" => "Paramètres de la requête invalides"));
                }

            } else {
                http_response_code(401);
                echo json_encode(array("resultat" => false, "error" => "Session invalide"));
            }
        }
        break;
}
?>