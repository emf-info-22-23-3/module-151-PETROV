/*
 * @class
 * @classdesc Cette classe fait office de contrôleur pour la page de recherche
 *
 * @author Tsvetoslav Petrov
 * @since 23.02.2025
*/

class RechercheCtrl {
    constructor(query, vinsFilter, bieresFilter, spiritueuxFilter, noAlcoolFilter, order, onlyPromotions) {
        indexCtrl.checkUser();
        this.initialiser(query, vinsFilter, bieresFilter, spiritueuxFilter, noAlcoolFilter, order, onlyPromotions);
    }

    //Méthode dédiée à l'initialisation du contrôleur
    initialiser(query, vinsFilter, bieresFilter, spiritueuxFilter, noAlcoolFilter, order, onlyPromotions) {
        $(`.search-bar`).val(query);
        $('.filtre-checkbox[name="Vins"]').prop('checked', vinsFilter);
        $('.filtre-checkbox[name="Bieres"]').prop('checked', bieresFilter);
        $('.filtre-checkbox[name="Spiritueux"]').prop('checked', spiritueuxFilter);
        $('.filtre-checkbox[name="Sans alcool"]').prop('checked', noAlcoolFilter);
        $('#tri-combobox').val(order);  
        $('input[name="Promotions"]').prop('checked', onlyPromotions);
        httpService.effectuerRecherche(query, vinsFilter, bieresFilter, spiritueuxFilter, noAlcoolFilter, order, onlyPromotions,
            this.effectuerRechercheSuccess.bind(this), this.effectuerRechercheError.bind(this));
        $(`#recherche-application-button`).on("click", () => {
            indexCtrl.loadRecherche($(`.search-bar`).val(), $('input[name="Vins"]').is(':checked'), $('input[name="Bieres"]').is(':checked'), $('input[name="Spiritueux"]').is(':checked'), $('input[name="Sans alcool"]').is(':checked'), $('#tri-combobox').val(), $('input[name="Promotions"]').is(':checked'));
        });
        $(`.search-bar`).on("keypress", (event) => {
            if (event.key === "Enter") {
                indexCtrl.loadRecherche($(`.search-bar`).val(), $('input[name="Vins"]').is(':checked'), $('input[name="Bieres"]').is(':checked'), $('input[name="Spiritueux"]').is(':checked'), $('input[name="Sans alcool"]').is(':checked'), $('#tri-combobox').val(), $('input[name="Promotions"]').is(':checked'));
            }
        });
    }
    //Méthode dédiée à la mise à jour des filtres
    //updateFilters(selectedFilter) {
    //    if (selectedFilter === 'all') {
    //        $('#recherche-filtres-container .filtre-checkbox').each(function () {
    //            $(this).prop('checked', true);
    //        });
    //    } else {
    //        if (selectedFilter !== '') {
    //            $(`[name=${selectedFilter}]`).prop(`checked`, true);
    //        }
    //    }
    //}

    effectuerRechercheSuccess(data) {
        if (!data.empty) {
            this.afficherProduits(data.boissons);
        } else {
            this.afficherAucunProduit(data.message);
        }
    }

    effectuerRechercheError(request, status, error) {
        alert("Erreur lors de la recherche : " + JSON.parse(request.responseText).error);
        indexCtrl.loadAccueil();
    }


    //Méthode dédiée à l'affichage des produits
    afficherProduits(produits) {
        produits.forEach(produit => {
            let nom = produit.nom;
            let quantite = produit.quantite;
            let prix = produit.prix;
            let pk = produit.pk_boisson;
            let imageBase64;
            if (produit.image) {
                imageBase64 = "data:image/jpeg;base64," + produit.image;
            } else {
                // Si aucune image n'est disponible, utiliser une image par défaut
                imageBase64 = "/images/no-image.webp";
            }

            let textColor = "black";
            if (produit.est_en_solde) {
                textColor = "rgb(255, 0, 119)";
            }

            $(`#recherche-boissons-container`).append(`
                <a onclick="indexCtrl.loadProduit(${pk})" class="boisson-container">
                <img class="boisson-image" src="${imageBase64}" alt="Boisson">
                <div class="boisson-informations-container">
                    <p class="boisson-nom">${nom}</p>
                    <p class="boisson-quantite">${quantite}</p>
                    <p class="boisson-prix" style="color: ${textColor}">CHF ${formatPrix(prix)}.-</p>
                </div>
            </a>
                `);
        });
    }

    //Méthode dédiée à l'affichage d'un message spécifique en cas d'absence de produits
    afficherAucunProduit(message) {
        $(`#recherche-boissons-container`).append(`
            <div class="liste-vide-container">
                <p class="liste-vide-text">${message}</p>
            </div>`);
    }
}