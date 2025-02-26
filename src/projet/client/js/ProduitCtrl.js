/*
 * @class
 * @classdesc Cette classe fait office de contrôleur pour la page de produit
 *
 * @author Tsvetoslav Petrov
 * @since 23.02.2025
*/

class ProduitCtrl {
    constructor(pkBoisson) {
        let currQuanity = 1;
        this.initialiser(pkBoisson);
        checkUser();
    }

    //Méthode dédiée à l'initialisation du contrôleur
    initialiser(pkBoisson) {

    }

    //Méthode dédiée au chargement de la boisson
    chargerBoisson(pkBoisson){

    }

    //Méthode dédiée à l'affichage de la boisson sur la page du produit
    afficherBoisson(boisson){
        let nom  = boisson.nom;
        let image = "/images/boissons/" + nom;
        let prix = boisson.prix;
        let quantite = boisson.quantite;
        let quantiteDisponible = boisson.quantiteDisponible;
        let informations = boisson.informations;
        let ingredients = boisson.ingredients;
        let producteur = boisson.producteur;
        let region = boisson.region;


        if (nom === undefined){
            nom = "Produit non-trouvé";
        }

        if (image === undefined){
            image = "/images/no-image.webp";
        }

        if (prix === undefined){
            prix = "0";
        }

        if(quantiteDisponible === undefined){
            quantiteDisponible = "0";
        }

        if (informations === undefined){
            informations = "Aucune information n'est disponible pour ce produit.";
            $(`#achat-boisson-informations`).css("font-style", "italic");
        }

        if (ingredients === undefined){
            ingredients = "Aucune information concernant les ingrédients de ce produit n'est disponible.";
            $(`#achat-boisson-ingredients`).css("font-style", "italic");
        }

        if (producteur === undefined){
            producteur = "Aucune information concernant les producteurs de ce produit n'est disponible.";
            $(`#achat-boisson-producteur`).css("font-style", "italic");
        }

        if (region === undefined){
            region = "Aucune information concernant la provenance de ce produit n'est disponible.";
            $(`#achat-boisson-region`).css("font-style", "italic");
        }

        $(`#achat-boisson-image`).prop("src", image);
        $(`#achat-boisson-nom`).append(nom);
        $(`#achat-boisson-prix`).append("CHF " + prix +".-");
        $(`#achat-boisson-quantite`).append(quantite);
        $(`#achat-boisson-quantite-disponible`).append(quantiteDisponible);
        $(`#achat-boisson-informations`).append(informations);
        $(`#achat-boisson-ingredients`).append(ingredients);
        $(`#achat-boisson-producteur`).append(producteur);
        $(`#achat-boisson-region`).append(region);
    }

    
}

//Fonction chargée de diminuer la quantité sélectionnée d'un produit
function diminuerQuantite(elementCible, id){
    let val = 0;
    if (id !== undefined){
        val = parseInt($(`#${id}`).text());
    } else {
        val = parseInt($(elementCible).text());
    }
    if (val > 1){
        val -= 1;
    }
    $(elementCible).text(val)
}

//Fonction chargée d'augmenter la quantité sélectionnée d'un produit
function augmenterQuantite(elementCible, id){
    let val = 0;
    if (id !== undefined){
        val = parseInt($(`#${id}`).text());
    } else {
        val = parseInt($(elementCible).text());
    }
    if (val < parseInt($("#achat-boisson-quantite-disponible").text())){
        val += 1;
    }
    $(elementCible).text(val)
}