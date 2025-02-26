/*
 * @class
 * @classdesc Cette classe fait office de contrôleur pour la page de recherche
 *
 * @author Tsvetoslav Petrov
 * @since 23.02.2025
*/

class RechercheCtrl {
    constructor(query, selectedFilter) {
        this.initialiser(query, selectedFilter);
        checkUser();
    }

    //Méthode dédiée à l'initialisation du contrôleur
    initialiser(query, selectedFilter) {

    }
    //Méthode dédiée à la mise à jour des filtres
    updateFilters(selectedFilter) {
        if (selectedFilter === 'all') {
            $('#recherche-filtres-container .filtre-checkbox').each(function () {
                $(this).prop('checked', true);
            });
        } else {
            if (selectedFilter !== '') {
                $(`[name=${selectedFilter}]`).prop(`checked`, true);
            }
        }
    }

    //Méthode dédiée à la récupération des produits
    chargerProduits(query, unSelectedFilter) {
        
    }

    //Méthode dédiée à l'affichage des produits
    afficherProduits(produits) {
        produits.forEach(produit => {
            let nom = produit.nom;
            let quantite = produit.quantite;
            let prix = produit.prix;
            let pk = produit.pk
            let image = "/images/boissons/" + nom;

            let textColor = "black";
            if (produit.estEnSolde) {
                textColor = "rgb(255, 0, 119)";
            }

            $(`#recherche-boissons-container`).append(`
                <a onclick="indexCtrl.loadProduit(${pk})" class="boisson-container">
                <img class="boisson-image" src="${image}" alt="Boisson">
                <div class="boisson-informations-container">
                    <p class="boisson-nom">${nom}</p>
                    <p class="boisson-quantite">${quantite}</p>
                    <p class="boisson-prix" style="color: ${textColor}">CHF ${prix}.-</p>
                </div>
            </a>
                `);
        });
    }

    //Méthode dédiée à l'affichage d'un message spécifique en cas d'absence de produits
    afficherAucunProduit() {
        $(`#recherche-boissons-container`).append(`
            <div class="liste-vide-container">
                <p class="liste-vide-text">Aucun résultat...</p>
            </div>`);
    }
}