/*
 * @class
 * @classdesc Cette classe fait office de contrôleur pour la page de produit
 *
 * @author Tsvetoslav Petrov
 * @since 23.02.2025
*/
class ProduitCtrl {
    //Constructeur de la classe ProduitCtrl
    constructor(pkBoisson) {
        indexCtrl.checkUser();
        this.initialiser(pkBoisson);
    }

    //Méthode dédiée à l'initialisation du contrôleur
    initialiser(pkBoisson) {
        httpService.getBoisson(pkBoisson, this.getBoissonSuccess.bind(this), this.getBoissonError.bind(this));
    }

    //Méthode exécutée en cas de succès de la récupération de la boisson
    getBoissonSuccess(response) {
        this.afficherBoisson(response.boisson);
        $(`.select-quantite-panier-button`).on("click", () => {
            const quantite = parseInt($('.select-quantite-text').text());
            this.ajouteAuPanier(response.boisson.pk_boisson, quantite);
        });
    }

    //Méthode exécutée en cas d'échec de la récupération de la boisson
    getBoissonError(request, status, error) {
        alert("Erreur lors du chargement de la boisson : " +  JSON.parse(request.responseText).error);
        indexCtrl.loadAccueil();
    }

    //Méthode dédiée à l'affichage de la boisson sur la page du produit
    afficherBoisson(boisson) {
        let pk = boisson.pk_boisson;
        let nom = boisson.nom;
        let image = boisson.image;
        let prix = boisson.prix;
        let quantite = boisson.quantite;
        let quantiteDisponible = boisson.quantite_disponible;
        let informations = boisson.informations;
        let ingredients = boisson.ingredients;
        let producteur = boisson.producteur;
        let region = boisson.region;
        let imageBase64;
        if (boisson.image) {
            imageBase64 = "data:image/jpeg;base64," + boisson.image;
        } else {
            imageBase64 = "images/no-image.webp";
        }

        if (nom === null) {
            nom = "Nom de la boisson non disponible";
        }

        if (prix === null) {
            prix = "0.00";
        }

        if (quantiteDisponible === null) {
            quantiteDisponible = "0";
        }

        if (quantiteDisponible == "0") {
            $(`.select-quantite-panier-button`).prop("disabled", true);
            $(`.select-quantite-panier-button`).css("background-color", "grey");
            $(`.select-quantite-panier-button`).css("cursor", "not-allowed");
            $(`#quantite-disponible-text`).css("color", "red");
            $(`#quantite-disponible-text`).text("Produit non disponible");
            $(`.select-quantite-button`).prop("disabled", true);
            $(`.select-quantite-text`).text("-");
        }

        if (informations === null || informations === "") {
            informations = "Aucune information n'est disponible pour ce produit.";
            $(`#achat-boisson-informations`).css("font-style", "italic");
        }

        if (ingredients === null) {
            ingredients = "Aucune information concernant les ingrédients de ce produit n'est disponible.";
            $(`#achat-boisson-ingredients`).css("font-style", "italic");
        }

        if (producteur === null) {
            producteur = "Aucune information concernant les producteurs de ce produit n'est disponible.";
            $(`#achat-boisson-producteur`).css("font-style", "italic");
        }

        if (region === null) {
            region = "Aucune information concernant la provenance de ce produit n'est disponible.";
            $(`#achat-boisson-region`).css("font-style", "italic");
        }

        $(`#achat-boisson-image`).prop("src", imageBase64);
        $(`#achat-boisson-image`).prop("alt", nom);
        $(`#achat-boisson-nom`).append(nom);
        $(`#achat-boisson-prix`).append("CHF " + formatPrix(prix) + "");
        $(`#achat-boisson-quantite`).append(quantite);
        $(`#achat-boisson-quantite-disponible`).append(quantiteDisponible);
        $(`#achat-boisson-informations`).append(informations);
        $(`#achat-boisson-ingredients`).append(ingredients);
        $(`#achat-boisson-producteur`).append(producteur);
        $(`#achat-boisson-region`).append(region);
    }

    //Méthode chargée d'ajouter la boisson au panier
    ajouteAuPanier(pkBoisson, quantite) {
        httpService.ajouteAuPanier(
            pkBoisson,
            quantite,
            (response) => this.ajouterAuPanierSuccess(response, pkBoisson),
            this.ajouterAuPanierError.bind(this)
        );
    }

    //Méthode exécutée en cas de succès de l'ajout au panier
    ajouterAuPanierSuccess(response, pkBoisson) {
        alert(response.message);
        indexCtrl.loadProduit(pkBoisson);
    }

    //Méthode exécutée en cas d'échec de l'ajout au panier
    ajouterAuPanierError(request, status, error) {
        alert("Erreur lors de l'ajout au panier : " + JSON.parse(request.responseText).error);
    }
}

//Fonction chargée de diminuer la quantité sélectionnée d'un produit
function diminuerQuantite(elementCible, id) {
    let val = 0;
    if (id !== undefined) {
        val = parseInt($(`#${id}`).text());
    } else {
        val = parseInt($(elementCible).text());
    }
    if (val > 1) {
        val -= 1;
    }
    $(elementCible).text(val)
}

//Fonction chargée d'augmenter la quantité sélectionnée d'un produit
function augmenterQuantite(elementCible, id) {
    let val = 0;
    if (id !== undefined) {
        val = parseInt($(`#${id}`).text());
    } else {
        val = parseInt($(elementCible).text());
    }
    if (val < parseInt($("#achat-boisson-quantite-disponible").text())) {
        val += 1;
    }
    $(elementCible).text(val)
}