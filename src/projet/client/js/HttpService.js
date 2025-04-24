let url = "http://127.0.0.1:8080/projet/server/server.php";

class HttpService {
    constructor() { }

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
