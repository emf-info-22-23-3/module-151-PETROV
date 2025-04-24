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
    initialiser() {
        httpService.getSoldes(this.soldesSuccess.bind(this), this.soldesError.bind(this));
    }

    soldesSuccess(response) {
        if (response.boissons) {
            this.afficherSoldes(response.boissons);
        } else {
            this.afficherAucunSoldes(response.message);
        }
    }

    soldesError(request, status, error) {
        //Gestion de l'erreur
        alert("Erreur lors de la récupération des soldes : " + error);
        this.afficherAucunSoldes("Erreur lors de la récupération des soldes");
    }
    //Méthode dédiée à l'affichage des soldes dur la page d'accueil
    afficherSoldes(soldes) {
        soldes.forEach(produit => {
            let pk = produit.pk_boisson;
            let nom = produit.nom;
            let quantite = produit.quantite;
            let prix = produit.prix;
            
            // Vérification si une image existe dans le produit
            let imageBase64;
            if (produit.image) {
                imageBase64 = "data:image/jpeg;base64," + produit.image;
            } else {
                // Si aucune image n'est disponible, utiliser une image par défaut
                imageBase64 = "/images/no-image.webp";
            }
            
            let textColor = "rgb(255, 0, 119)";
    
            $(`#liste-promotions-container`).append(`
                <a onclick="indexCtrl.loadProduit(${pk})" class="boisson-container">
                    <img class="boisson-image" src="${imageBase64}" alt="${nom}">
                    <div class="boisson-informations-container">
                        <p class="boisson-nom">${nom}</p>
                        <p class="boisson-quantite">${quantite}</p>
                        <p class="boisson-prix" style="color : ${textColor}">CHF ${formatPrix(prix)}.-</p>
                    </div>
                </a>
            `);
        });
    }
    
    //Méthode dédiée à l'affichage d'un message spécifique en cas d'absence de soldes
    afficherAucunSoldes(message) {
        $(`#liste-promotions-container`).append(`
            <p class="liste-vide-text" style="padding-left: 30px;">${message}</p>
        `);
    }

}