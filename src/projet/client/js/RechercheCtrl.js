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


    initialiser(query, selectedFilter) {
        this.updateSearchBar(query);
        this.updateFilters(selectedFilter);
        this.chargerProduits(query, [])
            .then((produits) => {
                if (produits.length !== 0) {
                    this.afficherProduits(produits)
                } else {
                    this.afficherAucunProduit();
                }
            })
            .catch((erreur) => {
                alert("Un problème est survenu lors du chargement des produits : \n" + erreur);
            });
    }

    updateSearchBar(query) {
        $('.search-bar').val(query)
    }

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

    chargerProduits(query, unSelectedFilter) {
        let unSelectedFilterQuery = ``;
        if (unSelectedFilter.length > 0){
            unSelectedFilterQuery = `&disabledFilters=`;
            unSelectedFilter.forEach(filter => {
                unSelectedFilterQuery += filter + ",";
            });
        }
        
        
        let url = `../serveur/serveur.php?query=${query}${unSelectedFilterQuery}`;
        return httpService.fetchGet(url)
            .then(data =>{
                let listeProduits = [];
                data.results.forEach(produit => {
                    if (produit.nom != ''){
                        listeProduits.push(produit);
                    }
                });
                return listeProduits;
            })
            .catch(erreur =>{
                throw erreur
            });
    }

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

    afficherAucunProduit() {
        $(`#recherche-boissons-container`).append(`
            <div class="liste-vide-container">
                <p class="liste-vide-text">Aucun résultat...</p>
            </div>`);
    }
}