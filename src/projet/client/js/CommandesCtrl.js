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


    initialiser() {
        this.chargerCommandes()
            .then(commandes => {
                if (commandes.length !== 0) {
                    this.afficherCommandes(commandes)
                } else {
                    this.afficherAucuneCommande();
                }
            })
            .catch((erreur) => {
                alert("Un problème est survenu lors du chargement des commandes : \n" + erreur);
            });
    }

    chargerCommandes() {
        let url = "https://api.themoviedb.org/3/trending/movie/day?api_key=526e37e9209768bacef81555818cbea5&language=fr-FR";
        return httpService.fetchGet(url)
            .then(data => {
                let listeCommandes = [];
                if (data.results != undefined) {
                    data.results.forEach(commande => {
                        if (commande.pk != undefined) {
                            listeCommandes.push(commande);
                        }
                    });
                }
                return listeCommandes;
            })
            .catch(erreur => {
                throw erreur
            });
    }

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

    afficherAucuneCommande() {
        $(".liste-vide-container").append(`
       <p class="liste-vide-text">La liste de commandes est vide...</p>
    `);
    }
}