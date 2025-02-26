/*
 * @class
 * @classdesc Cette classe fait office de contrôleur pour la page des commandes
 *
 * @author Tsvetoslav Petrov
 * @since 23.02.2025
*/

class CommandesCtrl {
    constructor() {
        this.initialiser();
        checkUser();
    }

    //Méthode dédiée à l'initialisation du contrôleur
    initialiser() {
        
    }

    //Méthode dédiée au chargement des commandes
    chargerCommandes() {
        
    }

    //Méthode dédiée à l'affichage des commandes sur la page des commandes
    afficherCommandes(commandes) {
        commandes.forEach(commande => {
            let pk = commande.nom;
            let utilisateur = commande.utilisateur;
            //A completer
            let prix = 0;

            $("#liste-panier-container").append(`
                <div class="commande-container">
                    <p class="commande-id">ID : 59</p>
                    <p class="commande-auteur">Par : PetrovT</p>
                    <p class="commande-prix">CHF 50.40.-</p>
                    <form action="" method="" class="commande-form-container">
                        <button class="commande-delete-button">
                            <img class="commande-delete-button-img" src="/images/poubelle.png" alt="delete">
                        </button>
                    </form>
                </div>
            `);
        });

        if (isNaN(prixTotal)) {
            prixTotal = "0.00";
        }
    }

    //Méthode dédiée à l'affichage d'un message spécifique en cas d'absence de commandes
    afficherAucuneCommande() {
        $(".liste-vide-container").append(`
       <p class="liste-vide-text">La liste de commandes est vide...</p>
    `);
    }
}