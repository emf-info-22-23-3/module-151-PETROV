/*
 * @class
 * @classdesc Cette classe fait office de contrôleur pour la page du panier
 *
 * @author Tsvetoslav Petrov
 * @since 23.02.2025
*/
class PanierCtrl {
    //Constructeur de la classe PanierCtrl
    constructor() {
        indexCtrl.checkUser();
        this.initialiser();
    }

    //Méthode dédiée à l'initialisation du contrôleur
    initialiser() {
        httpService.getPanier(this.chargerPanierSuccess.bind(this), this.chargerPanierError.bind(this));
    }

    //Méthode exécutée en cas de succès du chargement du panier
    chargerPanierSuccess(response) {
        if (!response.empty) {
            this.afficherPanier(response.panier.pk_panier, response.boissons, response.prix_total_panier);
            const self = this; // Sauvegarde une référence à l'objet parent
            $(`.delete-item-panier-button`).on("click", function () {
                const pk_boisson = $(this).closest(".panier-container").attr("id");
                self.deleteBoissonDePanier(pk_boisson);
            });
            $("#finalisation-commande-button").on("click", function () {
                const code = $("#finalisation-commande-code").val();
                self.finaliserPanier(code);
            });
        } else {
            this.afficherPanierVide();
        }
    }

    //Méthode exécutée en cas d'échec du chargement du panier
    chargerPanierError(request, status, error) {
        //Gestion de l'erreur
        alert("Erreur lors du chargement du panier : " + JSON.parse(request.responseText).error);
        indexCtrl.loadAccueil();
    }

    //Méthode dédiée à la finalisation du panier
    finaliserPanier(codePromo) {
        httpService.effectuerCommande(codePromo, this.finaliserPanierSuccess.bind(this), this.finaliserPanierError.bind(this));
    }

    //Méthode exécutée en cas de succès de la finalisation du panier
    finaliserPanierSuccess(response) {
        alert(response.message);
        indexCtrl.loadAccueil();
    }

    //Méthode exécutée en cas d'échec de la finalisation du panier
    finaliserPanierError(request, status, error) {
        //Gestion de l'erreur
        alert("Erreur lors de la finalisation de la commande : " + JSON.parse(request.responseText).error);
    }

    //Méthode dédiée à la suppression d'une boisson du panier
    deleteBoissonDePanier(pk_Boisson) {
        httpService.deleteBoissonDePanier(pk_Boisson, this.deleteBoissonDePanierSuccess.bind(this), this.deleteBoissonDePanierError.bind(this));
    }

    //Méthode exécutée en cas de succès de la suppression d'une boisson du panier
    deleteBoissonDePanierSuccess(response) {
        alert(response.message);
        indexCtrl.loadPanier();
    }

    //Méthode exécutée en cas d'échec de la suppression d'une boisson du panier
    deleteBoissonDePanierError(request, status, error) {
        //Gestion de l'erreur
        alert("Erreur lors de la suppression de la boisson du panier : " + JSON.parse(request.responseText).error);
        indexCtrl.loadAccueil();
    }

    //Méthode dédiée à l'affichage du panier sur la page du panier
    afficherPanier(pkPanier, produits, prixTotalPanier) {
        produits.forEach(produit => {
            let nom = produit.nom;
            let quantite = produit.quantite_choisie;
            let prix = produit.prix;
            let pkProduit = produit.pk_boisson
            let prixTotal = produit.prix_total;

            let imageBase64;
            if (produit.image) {
                imageBase64 = "data:image/jpeg;base64," + produit.image;
            } else {
                imageBase64 = "/images/no-image.webp";
            }

            let prixTotalAffichage = "";
            if (quantite > 1) {
                prixTotalAffichage = `<p class="panier-produit-prix">Total : CHF ${formatPrix(prixTotal)}.-</p>`;
            }

            $("#liste-panier-container").append(`
            <div class="panier-container" id="${pkProduit}">
                <div class="panier-produit-container">
                    <img src="${imageBase64}" class="panier-produit-image" alt="boisson" onerror="javascript:this.src='/images/no-image.webp'">
                    <div class="panier-produit-informations-container">
                        <p class="panier-produit-nom">${nom}</p>
                        <p class="panier-produit-quantite">Quantité choisie : ${quantite}</p>
                        <div class="panier-produit-prix-container">
                            <p class="panier-produit-prix">À l'unité : CHF ${formatPrix(prix)}.-</p>
                            ${prixTotalAffichage}
                        </div>
                    </div>
                </div>
                <div class="delete-item-container">
                    
                        <button style="border:solid 2px black" class="delete-item-panier-button">
                            <img class="delete-item-panier" src="/images/poubelle.png" alt="panier">
                        </button>
                </div>
            </div>
            `);
        });
        $(".page-content-container").after(`
            <div id="finalisation-commande-container">
                <p id="finalisation-commande-prix">Prix total : CHF ${formatPrix(prixTotalPanier)}.-</p>
                <div id="finalisation-commande-form-container">
                    <input id="finalisation-commande-code" type="text" placeholder="Code de réduction">
                    <button id="finalisation-commande-button" onclick="indexCtrl.finaliserPanier(${pkPanier}, $('#finalisation-commande-code').val())">Commander</button>
                </div>
            </div> 
        `);
    }

    //Méthode dédiée à l'affichage d'un message spécifique en cas de panier vide
    afficherPanierVide() {
        $(".liste-vide-container").append(`
            <p class="liste-vide-text">Votre Panier est vide...</p>
        `);
    }
}

