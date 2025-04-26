

//Création des variables globales
$().ready(function () {
    httpService = new HttpService();
    indexCtrl = new IndexCtrl();
    //Crée ici car sa méthode de déconnexion peut être appelée depuis presque n'importe où
    loginCtrl = new LoginCtrl();
}); 
/*
 * @class
 * @classdesc Cette classe fait office de contrôleur pour l'index de l'application
 *
 * @author Tsvetoslav Petrov
 * @since 23.02.2025
*/
class IndexCtrl {
    //Constructeur de la classe IndexCtrl
    constructor() {
        this.vue = new VueService();
        this.loadAccueil();
    }

    //charge la page d'accueil
    loadAccueil() {
        this.vue.chargerVue("accueil", () => new AccueilCtrl());
        this.checkUser();
        window.scrollTo(0, 0);
    }

    //charge la page des commandes
    loadCommandes() {
        this.vue.chargerVue("commandes", () => new CommandesCtrl());
        window.scrollTo(0, 0);
    }

    //charge la page de création de compte
    loadCreationCompte() {
        this.vue.chargerVue("creation-compte", () => new CreationCompteCtrl());
        window.scrollTo(0, 0);
    }

    //charge la page de connexion
    loadLogin() {
        this.vue.chargerVue("login", () => new LoginCtrl());
        window.scrollTo(0, 0);
    }

    //charge la page de panier
    loadPanier() {
        this.vue.chargerVue("panier", () => new PanierCtrl());
        window.scrollTo(0, 0);
    }
    
    //charge la page de produit
    loadProduit(pkBoisson) {
        this.vue.chargerVue("produit", () => new ProduitCtrl(pkBoisson));
        window.scrollTo(0, 0);
    }

    //charge la page de recherche
    loadRecherche(query, vinsFilter, bieresFilter, spiritueuxFilter, noAlcoolFilter, order, onlyPromotions) {
        this.vue.chargerVue("recherche", () => new RechercheCtrl(query, vinsFilter, bieresFilter, spiritueuxFilter, noAlcoolFilter, order, onlyPromotions));
        window.scrollTo(0, 0);
    }

    //vérifie le type d'utilisateur
    checkUser() {
        httpService.checkUser(checkUserSuccess, checkUserError);
    }
}

//Fonction chargée de vérifier si la touche pressée est "Enter" et si la barre de recherche n'est pas vide
function checkPress(event) {
    if (event.key == "Enter" && $('.search-bar').val() !== "") {
        indexCtrl.loadRecherche($('.search-bar').val(), true, true, true, true, "alpha_asc", false);
    }
}

//Fonction exécutée en cas de succès de la vérification du type d'utilisateur
function checkUserSuccess(response) {

    let currUser = "";
    if (!response.estLogin) {
        currUser = "visiteur";
    } else {
        if (response.estAdmin){
            currUser = "administrateur";
        } else {
            currUser = "utilisateur";
        }
    }
    
    //Gestion de l'affichage du menu de navigation en fonction du type d'utilisateur
    if (currUser == "visiteur") {
        console.log("visiteur");
        $('.profile-all-buttons-container').append(`
            <div class="profile-button-container">
                <a onclick="indexCtrl.loadLogin()" class="profile-button">CONNEXION</a>
            </div>    
        `);
    } else if (currUser == "utilisateur"){
        $('.profile-all-buttons-container').append(`
            <div class="profile-button-container">
                <a onclick="indexCtrl.loadPanier()" class="profile-button">PANIER</a>
            </div>
            <div class="profile-button-container">
                <a class="profile-icon-button">
                    <a onclick="loginCtrl.deconnecter()" class="profile-button">DECONNEXION</a>
                </a>
            </div> 
        `);
        console.log("utilisateur");
    } else if (currUser == "administrateur") {
        $('.profile-all-buttons-container').append(`
            <div class="profile-button-container">
                <a onclick="indexCtrl.loadCommandes()" class="profile-button">COMMANDES</a>
            </div>
            <div class="profile-button-container">
                <a onclick="indexCtrl.loadPanier()" class="profile-button">PANIER</a>
            </div>
            <div class="profile-button-container">
                <a class="profile-icon-button">
                    <a onclick="loginCtrl.deconnecter()" class="profile-button">DECONNEXION</a>
                </a>
            </div>  
        `);
    }
}

//Fonction exécutée en cas d'échec de la vérification du type d'utilisateur
function checkUserError(request, status, error) {
    alert(error.message);
}

//Fonction dédiée à la mise en forme du prix avec séparateur de milliers et deux décimales
function formatPrix(prix) {
    let prixNombre = parseFloat(prix);
    if (isNaN(prixNombre)) return "0.00";
    return prixNombre.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g,"'");
}