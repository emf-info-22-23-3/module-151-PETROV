const url = "https://petrovt.emf-informatique.ch/151/projet/server/server.php";
/*
 * @class
 * @classdesc Cette classe fait office de service HTTP pour l'application
 *
 * @author Tsvetoslav Petrov
 * @since 23.02.2025
*/
class HttpService {
    //Constructeur de la classe HttpService
    constructor() { }

    //Méthode dédiée à la connexion de l'utilisateur
    login(username, password, successCallback, errorCallback) {
        $.ajax({
            url: url,
            type: "POST",
            dataType: 'json',
            xhrFields: { withCredentials: true },
            data: "action=login&username=" + username + "&password=" + password,
            success: successCallback,
            error: errorCallback
        });
    }

    //Méthode dédiée à la recherche de boissons
    effectuerRecherche(query, vinsFilter, bieresFilter, spiritueuxFilter, noAlcoolFilter, order, onlyPromotions, successCallback, errorCallback) {
        $.ajax({
            url: url +"?action=recherche&query=" + query + "&vinsFilter=" + vinsFilter + "&bieresFilter=" + bieresFilter +
                "&spiritueuxFilter=" + spiritueuxFilter + "&noAlcoolFilter=" + noAlcoolFilter +
                "&order=" + order + "&onlyPromotions=" + onlyPromotions,
            type: "GET",
            dataType: 'json',
            xhrFields: { withCredentials: true },
            success: successCallback,
            error: errorCallback
        });
    }

    //Méthode dédiée à la vérification de l'utilisateur
    checkUser(successCallback, errorCallback) {
        $.ajax({
            url: url + "?action=checkUser",
            type: "GET",
            dataType: 'json',
            xhrFields: { withCredentials: true },
            success: successCallback,
            error: errorCallback
        });
    }

    //Méthode dédiée à la création d'un compte utilisateur
    creerCompte(username, password, passwordConfirm, successCallback, errorCallback) {
        $.ajax({
            url: url,
            type: "POST",
            dataType: 'json',
            xhrFields: { withCredentials: true },
            data: "action=creationCompte&username=" + username + "&password=" + password + "&passwordConfirm=" + passwordConfirm,
            success: successCallback,
            error: errorCallback
        });
    }

    //Méthode dédiée à la déconnexion de l'utilisateur
    deconnecter(successCallback, errorCallback) {
        $.ajax({
            url: url,
            type: "POST",
            dataType: 'json',
            xhrFields: { withCredentials: true },
            data: "action=deconnecter",
            success: successCallback,
            error: errorCallback
        });
    }

    //Méthode dédiée à la récupération des informations de la boisson
    getBoisson(pkBoisson, successCallback, errorCallback) {
        $.ajax({
            url: url + "?action=getBoisson&pk_boisson=" + pkBoisson,
            type: "GET",
            dataType: 'json',
            xhrFields: { withCredentials: true },
            success: successCallback,
            error: errorCallback
        });
    }

    //Méthode dédiée à la récupération des soldes
    getSoldes(successCallback, errorCallback) {
        $.ajax({
            url: url + "?action=getSoldes",
            type: "GET",
            dataType: 'json',
            xhrFields: { withCredentials: true },
            success: successCallback,
            error: errorCallback
        });
    }

    //Méthode dédiée à l'ajout d'une boisson au panier
    ajouteAuPanier(pkBoisson, quantite, successCallback, errorCallback) {
        $.ajax({
            url: url,
            type: "POST",
            dataType: 'json',
            xhrFields: { withCredentials: true },
            data: "action=ajouterAuPanier&pk_boisson=" + pkBoisson + "&quantite=" + quantite,
            success: successCallback,
            error: errorCallback
        });
    }

    //Méthode dédiée à la récupération du panier de l'utilisateur
    getPanier(successCallback, errorCallback) {
        $.ajax({
            url: url + "?action=getPanier",
            type: "GET",
            dataType: 'json',
            xhrFields: { withCredentials: true },
            success: successCallback,
            error: errorCallback
        });
    }

    //Méthode dédiée à la suppression d'une boisson du panier de l'utilisateur
    deleteBoissonDePanier(pkBoisson, successCallback, errorCallback) {
        $.ajax({
            url: url,
            type: "POST",
            dataType: 'json',
            xhrFields: { withCredentials: true },
            data: "action=deleteFromPanier&pk_boisson=" + pkBoisson,
            success: successCallback,
            error: errorCallback
        });
    }

    //Méthode dédiée é l'envoi de la commande
    effectuerCommande(codePromo, successCallback, errorCallback) {
        if (codePromo === "") {
            $.ajax({
                url: url,
                type: "POST",
                dataType: 'json',
                xhrFields: { withCredentials: true },
                data: "action=effectuerCommande",
                success: successCallback,
                error: errorCallback
            });
        } else {
            $.ajax({
                url: url,
                type: "POST",
                dataType: 'json',
                xhrFields: { withCredentials: true },
                data: "action=effectuerCommande&code_promo=" + codePromo,
                success: successCallback,
                error: errorCallback
            });
        }
    }

    //Méthode dédiée à la récupération des commandes des utilisateurs
    getCommandes(successCallback, errorCallback) {
        $.ajax({
            url: url + "?action=getCommandes",
            type: "GET",
            dataType: 'json',
            xhrFields: { withCredentials: true },
            success: successCallback,
            error: errorCallback
        });
    }

    //Méthode dédiée à la suppression d'une commande
    deleteCommande(pkPanier, successCallback, errorCallback) {
        $.ajax({
            url: url,
            type: "POST",
            dataType: 'json',
            xhrFields: { withCredentials: true },
            data: "action=deleteCommande&pk_panier=" + pkPanier,
            success: successCallback,
            error: errorCallback
        });
    }
}
