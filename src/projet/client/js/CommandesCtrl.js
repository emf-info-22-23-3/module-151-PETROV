/*
 * @class
 * @classdesc Cette classe fait office de contrôleur pour la page des commandes
 *
 * @author Tsvetoslav Petrov
 * @since 23.02.2025
*/

class CommandesCtrl {
    //Constructeur de la classe CommandesCtrl
    constructor() {
        indexCtrl.checkUser();
        this.initialiser();

    }

    //Méthode dédiée à l'initialisation du contrôleur
    initialiser() {
        httpService.getCommandes(this.getCommandesSuccess.bind(this), this.getCommandesError.bind(this));
    }

    //Méthode dédiée à la suppression d'une commande
    deleteCommande(pk_panier) {
        httpService.deleteCommande(pk_panier, this.deleteCommandeSuccess.bind(this), this.deleteCommandeError.bind(this));
    }

    //Méthode exécutée en cas de succès de la suppression d'une commande
    deleteCommandeSuccess(response) {
        alert(response.message);
        indexCtrl.loadCommandes();
    }

    //Méthode exécutée en cas d'échec de la suppression d'une commande
    deleteCommandeError(request, status, error) {
        alert("Erreur lors de la suppression de la commande : " + JSON.parse(request.responseText).error);
        indexCtrl.loadCommandes();
    }

    //Méthode exécutée en cas de succès de la récupération des commandes
    getCommandesSuccess(data) {
        if (!data.empty) {
            this.afficherCommandes(data.commandes);
            const self = this; // Sauvegarde une référence à l'objet parent
            $(`.commande-delete-button`).on("click", function () {
                const pk_panier = $(this).closest(".commande-container").attr("id");
                self.deleteCommande(pk_panier);
            });
        } else {
            this.afficherAucuneCommande();
        }
    }

    //Méthode exécutée en cas d'erreur de la récupération des commandes
    getCommandesError(request, status, error) {
        alert("Erreur lors du chargement des commandes : " + JSON.parse(request.responseText).error);
        indexCtrl.loadAccueil();
    }


    //Méthode dédiée à l'affichage des commandes sur la page des commandes
    afficherCommandes(commandes) {
        commandes.forEach(commande => {
            let pk_commande = commande.pk_panier;
            let auteur = commande.auteur;
            let prix_total = commande.prix_total_panier;
            let code_promo = commande.code_promo;
            if (code_promo == false) {
                code_promo = "Aucun";
            }
            let boissonsHtml = '';
            commande.boissons.forEach(boisson => {
                let quantite_choisie_boisson = boisson.quantite_choisie;
                let nom_boisson = boisson.nom;
                let quantite_boisson = boisson.quantite;
                let prix_boisson = boisson.prix;

                boissonsHtml += `
                    <div class="commande-boisson">
                        <p class="commande-boisson-quantite-choisie">${quantite_choisie_boisson}x</p>
                        <p class="commande-boisson-nom">${nom_boisson}</p>
                        <p class="commande-boisson-quantite">${quantite_boisson}</p>
                        <p class="commande-boisson-prix">CHF ${formatPrix(prix_boisson)}.-</p>
                    </div>`;
            });

            $("#liste-commandes-container").append(`
                <div class="commande-container" id="${pk_commande}">
                    <div class="commande-infos-container">
                        <p class="commande-id">ID : ${pk_commande}</p>
                        <p class="commande-auteur">Par : ${auteur}</p>
                        <p class="commande-prix">CHF ${formatPrix(prix_total)}.-</p>
                        <p class="commande-code">Code utilisé : ${code_promo}</p>
                        <button class="commande-delete-button">
                            <img class="commande-delete-button-img" src="/images/poubelle.png" alt="delete">
                        </button>
                    </div>
                    <div class="commande-boissons-container">
                    ${boissonsHtml}
                    </div>
                </div>
            `);
        });
    }

    //Méthode dédiée à l'affichage d'un message spécifique en cas d'absence de commandes
    afficherAucuneCommande() {
        $(".liste-vide-container").append(`
       <p class="liste-vide-text">La liste de commandes est vide...</p>
    `);
    }
}