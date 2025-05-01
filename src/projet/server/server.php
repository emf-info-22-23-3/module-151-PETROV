<?php
session_start();
//header("Access-Control-Allow-Origin: http://127.0.0.1:5501");
//header("Access-Control-Allow-Methods: GET, POST, DELETE,OPTIONS");
//header("Access-Control-Allow-Headers: Content-Type");
//header("Access-Control-Allow-Credentials: true");
require_once 'controllers/SessionManager.php';
require_once 'controllers/BoissonManager.php';
require_once 'controllers/CompteManager.php';
require_once 'controllers/PanierManager.php';
require_once 'controllers/RechercheManager.php';
require_once 'beans/Compte.php';
require_once 'beans/Boisson.php';
require_once 'beans/Panier.php';


// Vérification de la méthode de la requête
$action = "";
if (isset($_POST["action"])) {
    $action = $_POST["action"];
}

if (isset($_GET["action"])) {
    $action = $_GET["action"];
}

// Vérification de l'action demandée
switch ($action) {

    //Cas de recherche de boissons
    case "recherche":
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_GET["query"]) && isset($_GET["vinsFilter"]) && isset($_GET["bieresFilter"]) && isset($_GET["spiritueuxFilter"]) && isset($_GET["noAlcoolFilter"]) && isset($_GET["order"]) && isset($_GET["onlyPromotions"])) {
                $query = $_GET["query"];
                $vinsFilter = $_GET["vinsFilter"];
                $bieresFilter = $_GET["bieresFilter"];
                $spiritueuxFilter = $_GET["spiritueuxFilter"];
                $noAlcoolFilter = $_GET["noAlcoolFilter"];
                $order = $_GET["order"];
                $onlyPromotions = $_GET["onlyPromotions"];
                $rechercheManager = new RechercheManager();
                $resultats = $rechercheManager->effectuerRecherche($query, $vinsFilter, $bieresFilter, $spiritueuxFilter, $noAlcoolFilter, $order, $onlyPromotions);
                if (!empty($resultats)) {
                    $boissonReturnTab = [];
                    foreach ($resultats as $boisson) {
                        $boissonReturnTab[] = [
                            "pk_boisson" => $boisson->getPkBoisson(),
                            "nom" => $boisson->getNom(),
                            "quantite" => $boisson->getQuantite(),
                            "prix" => $boisson->getPrix(),
                            //Blob encodé en base64
                            "image" => $boisson->getImage(),
                            "est_en_solde" => $boisson->getEstEnSolde(),
                        ];
                    }
                    http_response_code(200);
                    echo json_encode(array("empty" => false, "boissons" => $boissonReturnTab));
                } else {
                    http_response_code(200);
                    echo json_encode(array("empty" => true, "message" => "Aucun résultat..."));
                } 
            } else {
                http_response_code(400);
                echo json_encode(array("error" => "Paramètres de la requête invalides"));
            }
        }
        break;
    //Cas de tentative de connexion
    case "login":
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sessionManager = new SessionManager();

            if (!$sessionManager->isConnected()) {
                if (!isset($_POST['username']) || !isset($_POST['password']) || empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
                    http_response_code(400);
                    echo json_encode(array("error" => "Champ(s) vides"));
                    break;
                }

                $compteManager = new CompteManager();
                $compte = $compteManager->checkLogin(trim($_POST['username']), $_POST['password']);

                if ($compte != null) {
                    $sessionManager->openSession($compte->getNomUtilisateur(), $compte->getPkCompte(), $compte->getEstAdmin());
                    http_response_code(200);
                    echo json_encode(array("success" => true, "message" => "Connexion réussie"));

                } else {
                    http_response_code(400);
                    echo json_encode(array("success" => false, "error" => "Identifiants invalides"));
                }
            } else {
                http_response_code(409);
                echo json_encode(array("success" => false, "error" => "Vous êtes déjà connectés"));
            }
        }
        break;
    //Cas de vérification de l'utilisateur 
    case "checkUser":
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $sessionManager = new SessionManager();
            if ($sessionManager->isConnected()) {
                http_response_code(200);
                echo json_encode(array("estLogin" => true, "estAdmin" => $sessionManager->getEstAdmin()));
                break;
            } else {
                http_response_code(200);
                echo json_encode(array("estLogin" => false));
                break;
            }
        }
        break;
    //Cas de déconnexion
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
    //Cas de création de compte
    case "creationCompte":
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sessionManager = new SessionManager();
            if (!$sessionManager->isConnected()) {
                if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['passwordConfirm']) || empty(trim($_POST['username'])) || empty(trim($_POST['password'])) || empty(trim($_POST['passwordConfirm']))) {
                    http_response_code(400);
                    echo json_encode(array("resultat" => false, "error" => "Veuillez remplir tous les champs"));
                    break;
                }
                $compteManager = new CompteManager();
                $username = $_POST['username'];
                $password = $_POST['password'];
                $passwordConfirm = $_POST['passwordConfirm'];
                if ($password !== $passwordConfirm) {
                    http_response_code(400);
                    echo json_encode(array("error" => "Les mots de passes ne sont pas identiques"));
                } else {
                    if ($compteManager->ajouterCompte($username, $password)) {
                        http_response_code(200);
                        echo json_encode(array("message" => "Le compte a été créé"));
                    } else {
                        http_response_code(409);
                        echo json_encode(array("error" => "Le nom d'utilisateur entré existe déjà"));
                    }
                }
            } else {
                http_response_code(403);
                echo json_encode(array("error" => "Veuillez vous déconnecter avant de créer un compte."));
            }
        }
        break;
    //Cas d'ajout de boisson au panier
    case "ajouterAuPanier":
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['pk_boisson']) && isset($_POST['quantite'])) {
                $pk_boisson = $_POST['pk_boisson'];
                $quantite = $_POST['quantite'];
                $sessionManager = new SessionManager();
                if ($sessionManager->isConnected()) {
                    $boissonManager = new BoissonManager();
                    $boisson = $boissonManager->getBoisson($pk_boisson);
                    if ($boisson != null) {
                        if ($boisson->getQuantiteDisponible() >= $quantite) {
                            $panierManager = new PanierManager();
                            $panier = $panierManager->getPanierUnvalidated($sessionManager->getPk());
                            if ($panier === null) {
                                $panier = $panierManager->ajouterPanier($sessionManager->getPk());
                            }
                            $panierResult = $panierManager->ajouterBoissonAuPanier($pk_boisson, $quantite, $panier->getPkPanier());
                            if ($panierResult) {
                                $quantiteRestante = (int) $boisson->getQuantiteDisponible() - $quantite;
                                $boissonManager->setQuantite($pk_boisson, $quantiteRestante);
                                http_response_code(200);
                                echo json_encode(array("message" => "Boisson ajoutée au panier"));
                            }
                        } else {
                            http_response_code(400);
                            echo json_encode(array("error" => "Quantité choisie invalide"));
                        }
                    } else {
                        http_response_code(404);
                        echo json_encode(array("error" => "Boisson introuvable"));
                    }
                } else {
                    http_response_code(401);
                    echo json_encode(array("error" => "Vous devez vous connecter avant d'ajouter une boisson au panier."));
                }
            } else {
                http_response_code(400);
                echo json_encode(array("error" => "Paramètres de la requête invalides"));
            }
        }
        break;
    //Cas de récupération des détails d'une boisson
    case "getBoisson":
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_GET["pk_boisson"])) {
                $pk_boisson = $_GET["pk_boisson"];
                $boissonManager = new BoissonManager();
                $boisson = $boissonManager->getBoisson($pk_boisson);
                if ($boisson != null) {
                    $boissonReturnTab = [
                        "pk_boisson" => $boisson->getPkBoisson(),
                        "nom" => $boisson->getNom(),
                        "quantite" => $boisson->getQuantite(),
                        "prix" => $boisson->getPrix(),
                        //Blob encodé en base64
                        "image" => $boisson->getImage(),
                        "quantite_disponible" => $boisson->getQuantiteDisponible(),
                        "est_en_solde" => $boisson->getEstEnSolde(),
                        "informations" => $boisson->getInformations(),
                        "ingredients" => $boisson->getIngredients(),
                        "producteur" => $boisson->getProducteur(),
                        "region" => $boisson->getRegion()
                    ];
                    http_response_code(200);
                    echo json_encode(array("boisson" => $boissonReturnTab));
                } else {
                    http_response_code(404);
                    echo json_encode(array("error" => "Boisson introuvable"));
                }
            } else {
                http_response_code(400);
                echo json_encode(array("error" => "Paramètres de la requête invalides"));
            }
        }
        break;
    //Cas de récupération des boissons en promotion
    case "getSoldes":
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $boissonManager = new BoissonManager();
            $boissons = $boissonManager->getBoissonsEnSoldes();
            if (count($boissons) > 0) {
                $boissonReturnTab = [];
                foreach ($boissons as $boisson) {
                    $boissonReturnTab[] = [
                        "pk_boisson" => $boisson->getPkBoisson(),
                        "nom" => $boisson->getNom(),
                        "quantite" => $boisson->getQuantite(),
                        "prix" => $boisson->getPrix(),
                        //Blob encodé en base64
                        "image" => $boisson->getImage(),
                    ];
                }
                http_response_code(200);
                echo json_encode(array("empty" => false, "boissons" => $boissonReturnTab));
            } else {
                http_response_code(200);
                echo json_encode(array("empty" => true, "message" => "Aucune boisson n'est en promotion actuellement."));
            }
        }
        break;
    //Cas de récupération du panier
    case "getPanier":
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $sessionManager = new SessionManager();
            if ($sessionManager->isConnected()) {
                $panierManager = new PanierManager();
                $boissonManager = new BoissonManager();
                $panier = $panierManager->getPanierUnvalidated($sessionManager->getPk());
                if ($panier === null) {
                    $panier = $panierManager->ajouterPanier($sessionManager->getPk());
                    http_response_code(200);
                    echo json_encode(array("empty" => true, "error" => "Votre panier est vide"));
                    break;
                }
                $boissonsInfos = $panierManager->getPKBoissonsDuPanier($panier->getPkPanier());
                if (count($boissonsInfos) > 0) {
                    $prixTotalPanier = 0;
                    foreach ($boissonsInfos as $pk_boisson => $quantite_choisie) {
                        $boisson = $boissonManager->getBoisson($pk_boisson);
                        if ($boisson != null) {
                            $boissonReturnTab[] = [
                                "pk_boisson" => $boisson->getPkBoisson(),
                                "nom" => $boisson->getNom(),
                                "prix" => $boisson->getPrix(),
                                "prix_total" => $boisson->getPrix() * (int) $quantite_choisie,
                                //Blob encodé en base64
                                "image" => $boisson->getImage(),
                                "quantite_disponible" => $boisson->getQuantiteDisponible(),
                                "quantite_choisie" => (int) $quantite_choisie,
                            ];
                            $prixTotalPanier += $boisson->getPrix() * (int) $quantite_choisie;
                        }
                    }

                    http_response_code(200);
                    echo json_encode(array("empty" => false, "panier" => $panier->getPkPanier(), "boissons" => $boissonReturnTab, "prix_total_panier" => $prixTotalPanier));
                } else {
                    http_response_code(200);
                    echo json_encode(array("empty" => true, "error" => "Votre panier est vide"));
                }
            } else {
                http_response_code(401);
                echo json_encode(array("empty" => true, "error" => "Session invalide"));
            }
        }
        break;
    //Cas de suppression d'une boisson du panier
    case "deleteFromPanier":
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sessionManager = new SessionManager();
            if ($sessionManager->isConnected()) {
                if (isset($_POST['pk_boisson'])) {
                    $pk_boisson = $_POST['pk_boisson'];
                    $panierManager = new PanierManager();
                    $panier = $panierManager->getPanierUnvalidated($sessionManager->getPk());
                    if ($panier === null) {
                        http_response_code(404);
                        echo json_encode(array("error" => "Panier introuvable"));
                        break;
                    }

                    if ($panierManager->isBoissonInPanier($pk_boisson, $panier->getPkPanier())) {
                        $boissonManager = new BoissonManager();
                        $nouvelleQuantite = $boissonManager->getQuantite($pk_boisson) + $panierManager->getQuantite($pk_boisson, $panier->getPkPanier());
                        $boissonManager->setQuantite($pk_boisson, $nouvelleQuantite);
                        $panierManager->deleteBoissonFromPanier($pk_boisson, $panier->getPkPanier());
                        http_response_code(200);
                        echo json_encode(array("message" => "La boisson a été supprimée du panier"));
                    } else {
                        http_response_code(404);
                        echo json_encode(array("error" => "Boisson introuvable dans le panier"));
                        break;
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(array("error" => "Paramètres de la requête invalides"));
                }
            } else {
                http_response_code(401);
                echo json_encode(array("error" => "Session invalide"));
            }
        }
        break;
    //Cas de validation du panier
    case "effectuerCommande":
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sessionManager = new SessionManager();
            if ($sessionManager->isConnected()) {
                $panierManager = new PanierManager();
                $panier = $panierManager->getPanierUnvalidated($sessionManager->getPk());
                if ($panier === null) {
                    http_response_code(404);
                    echo json_encode(array("error" => "Panier introuvable"));
                    break;
                }
                if (isset($_POST['code_promo'])) {
                    $codePromo = $_POST['code_promo'];
                    if ($panierManager->checkCodePromo($codePromo)) {
                        $panierManager->setCodePromo($codePromo, $panier->getPkPanier());
                    } else {
                        http_response_code(400);
                        echo json_encode(array("error" => "Le code de réduction est invalide"));
                        break;
                    }
                }
                $panierManager->setPanierValidated($panier->getPkPanier());
                http_response_code(200);
                echo json_encode(array("message" => "La commande a été effectuée avec succès"));
            } else {
                http_response_code(401);
                echo json_encode(array("error" => "Session invalide"));
            }
        }
        break;
    //Cas de récupération des commandes
    case "getCommandes":
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $sessionManager = new SessionManager();
            if ($sessionManager->isConnected() && $sessionManager->getEstAdmin()) {
                $panierManager = new PanierManager();
                $boissonManager = new BoissonManager();
                $compteManager = new CompteManager();
                $commandes = $panierManager->getPaniersValidated();
                if (count($commandes) > 0) {

                    foreach ($commandes as $panier) {
                        $prixTotalPanier = 0;
                        $boissonsPK = $panierManager->getPKBoissonsDuPanier($panier->getPkPanier());
                        $boissonsInfos = [];
                        foreach ($boissonsPK as $pk_boisson => $quantite_choisie) {
                            $boisson = $boissonManager->getBoisson($pk_boisson);
                            if ($boisson != null) {
                                $boissonsInfos[] = [
                                    "nom" => $boisson->getNom(),
                                    "prix" => $boisson->getPrix(),
                                    "quantite" => $boisson->getQuantite(),
                                    "quantite_choisie" => (int) $quantite_choisie,
                                ];
                                $prixTotalPanier += $boisson->getPrix() * (int) $quantite_choisie;
                            }
                        }
                        $codePromo = $panierManager->getCodePromo($panier->getPkPanier());
                        if ($codePromo != null) {
                            $codePromo = $panierManager->getCodePromo($panier->getPkPanier())["valeur"];
                            $prixTotalPanier *= 1 - $panierManager->getCodePromo($panier->getPkPanier())["pourcentage"] / 100;
                        }
                        $auteur = $compteManager->getCompteByPk($panier->getFkCompte())->getNomUtilisateur();
                        $panierInfosTab[] = [
                            "pk_panier" => $panier->getPkPanier(),
                            "auteur" => $auteur,
                            "prix_total_panier" => $prixTotalPanier,
                            "code_promo" => $codePromo,
                            "boissons" => $boissonsInfos,
                        ];
                    }
                    http_response_code(200);
                    echo json_encode(array("empty" => false, "commandes" => $panierInfosTab));
                } else {
                    http_response_code(200);
                    echo json_encode(array("empty" => true, "error" => "Aucune commande n'est disponible"));
                }
            } else {
                http_response_code(401);
                echo json_encode(array("error" => "Session invalide"));
            }
        }
        break;
    //Cas de suppression d'une commande
    case "deleteCommande":
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sessionManager = new SessionManager();
            if ($sessionManager->isConnected() && $sessionManager->getEstAdmin()) {
                if (isset($_POST['pk_panier'])) {
                    $pk_panier = $_POST['pk_panier'];
                    $panierManager = new PanierManager();
                    $panier = $panierManager->getPanierByPk($pk_panier);
                    if ($panier === null) {
                        http_response_code(404);
                        echo json_encode(array("error" => "Commande introuvable"));
                        break;
                    }
                    $panierManager->deleteCommande($panier->getPkPanier());
                    http_response_code(200);
                    echo json_encode(array("message" => "La commande a été supprimée"));
                } else {
                    http_response_code(400);
                    echo json_encode(array("error" => "Paramètres de la requête invalides"));
                }
            } else {
                http_response_code(401);
                echo json_encode(array("error" => "Session invalide"));
            }
        }
        break;
}
?>
