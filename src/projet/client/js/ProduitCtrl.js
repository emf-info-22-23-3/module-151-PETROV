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


    initialiser(pkBoisson) {
        this.chargerBoisson(pkBoisson)
            .then(boisson => {
                this.afficherBoisson(boisson);
            })
            .catch((erreur) => {
                alert("Un problème est survenu lors du chargement du produit : \n" + erreur);
            });
    }

    chargerBoisson(pkBoisson){
        let url = "https://api.themoviedb.org/3/trending/movie/day?api_key=526e37e9209768bacef81555818cbea5&language=fr-FR";
        return httpService.fetchGet(url)
            .then(data => {
                return {
                    nom : data.nom,
                    quantite : data.quantite,
                    quantiteDisponible : data.quantiteDisponible,
                    prix : data.prix,
                    informations : data.informations,
                    ingredients : data.ingredients,
                    producteur : data.producteur,
                    region : data.region,
                }
            })
            .catch(erreur => {
                throw erreur;
            });
    }

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