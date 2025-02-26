/*
 * @class
 * @classdesc Cette classe fait office de contrôleur pour l'accueil de l'application
 *
 * @author Tsvetoslav Petrov
 * @since 23.02.2025
*/

class AccueilCtrl {
    constructor() {
        this.initialiser();
    }

    //Méthode dédiée à l'initialisation du contrôleur
    initialiser() { }

    //Méthode dédiée au chargement des soldes
    chargerSoldes() {

    }

    //Méthode dédiée à l'affichage des soldes dur la page d'accueil
    afficherSoldes(soldes) {
        soldes.forEach(produit => {
            let nom = produit.nom;
            let quantite = produit.quantite;
            let prix = produit.prix;
            let pk = produit.pk
            let image = "/images/boissons/" + nom;

            let textColor = "black";
            if (produit.estEnSolde) {
                textColor = "rgb(255, 0, 119)";
            }

            $(`#liste-promotions-container`).append(`
                <a  onclick="indexCtrl.loadProduit(${pk})" class="boisson-container">
                        <img class="boisson-image" src="${image}" alt="${nom}">
                        <div class="boisson-informations-container">
                            <p class="boisson-nom">${nom}</p>
                            <p class="boisson-quantite">${quantite}</p>
                            <p class="boisson-prix" style="color : ${textColor}">CHF ${prix}.-</p>
                        </div>
                    </a>
                `);
        });
    }

    //Méthode dédiée à l'affichage d'un message spécifique en cas d'absence de soldes
    afficherAucunSoldes() {
        $(`#liste-promotions-container`).append(`
            <p class="liste-vide-text" style="padding-left: 30px;">Aucune promotion n'est disponible actuellement...</p>
        `);
    }

}