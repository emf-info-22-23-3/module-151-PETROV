/*
 * @class
 * @classdesc Cette classe fait office de contrôleur pour la page du panier
 *
 * @author Tsvetoslav Petrov
 * @since 23.02.2025
*/

class PanierCtrl {
    constructor(pkPanier) {
        this.initialiser(pkPanier);
        checkUser();
    }


    initialiser(pkPanier) {
        this.chargerPanier(pkPanier)
            .then(produits => {
                
                if (produits.length !== 0) {
                    this.afficherPanier(pkPanier, produits)
                } else {
                    this.afficherPanierVide();
                }
            })
            .catch((erreur) => {
                alert("Un problème est survenu lors du chargement des articles : \n" + erreur);
            });
    }

    chargerPanier(pkPanier, pkUtilisateur) {
        let url = "https://api.themoviedb.org/3/trending/movie/day?api_key=526e37e9209768bacef81555818cbea5&language=fr-FR";
        return httpService.fetchGet(url)
            .then(data => {
                let listeProduits = [];
                
                if (data.results != undefined) {
                    data.results.forEach(produit => {
                        if (produit.nom != '') {
                            listeProduits.push(produit);
                        }
                    });
                }
                
                return listeProduits;
            })
            .catch(erreur => {
                throw erreur
            });
    }

    afficherPanier(pkPanier, produits) {
        let prixTotal = 0;
        produits.forEach(produit => {
            let nom = produit.nom;
            let quantite = produit.quantite;
            let prix = produit.prix;
            let pkProduit = produit.pk
            let image = "/images/boissons/" + nom;

            let textColor = "black";
            if (produit.estEnSolde) {
                textColor = "rgb(255, 0, 119)";
            }


            $("#liste-panier-container").append(`
            <div class="panier-container" id="${pkProduit}">
                <div class="panier-produit-container">
                    <img src="${image}" class="panier-produit-image" alt="boisson" onerror="javascript:this.src='/images/no-image.webp'">
                    <div class="panier-produit-informations-container">
                        <p class="panier-produit-nom">${nom}</p>
                        <p class="panier-produit-quantite">${quantite}</p>
                        <p class="panier-produit-prix">${prix}</p>
                    </div>
                </div>
                <div class="select-quantite-container">
                    <button class="select-quantite-button" onclick='diminuerQuantite(".select-quantite-text", ${pkProduit});'>-</button>
                    <p class="select-quantite-text">1</p>
                    <button class="select-quantite-button" onclick='augmenterQuantite(".select-quantite-text", ${pkProduit});'>+</button>
                    <form action="" method="" class="select-quantite-panier-button-container">
                        <button class="delete-item-panier-button" onclick="indexCtrl.deleteBoissonDePanier(${pkProduit})">
                            <img class="delete-item-panier" src="/images/poubelle.png" alt="panier">
                        </button>
                    </form>
                </div>
            </div>
            `);
            prixTotal += prix;
        });

        if(isNaN(prixTotal)){
            prixTotal = "0.00";
        }

        $(".page-content-container").after(`
            <div id="finalisation-commande-container">
                <p id="finalisation-commande-prix">Prix total : CHF ${prixTotal}.-</p>
                <div id="finalisation-commande-form-container">
                    <input id="finalisation-commande-code" type="text" placeholder="Code de réduction">
                    <button id="finalisation-commande-button" onclick="indexCtrl.finaliserPanier(${pkPanier}, $('#finalisation-commande-code').val())">Commander</button>
                </div>
            </div> 
        `);   
    }

    afficherPanierVide(){
        $(".liste-vide-container").append(`
            <p class="liste-vide-text">Votre Panier est vide...</p>
        `);
    }
}

