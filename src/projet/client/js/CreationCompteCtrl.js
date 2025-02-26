/*
 * @class
 * @classdesc Cette classe fait office de contrôleur pour la page de création de compte
 *
 * @author Tsvetoslav Petrov
 * @since 23.02.2025
*/

class CreationCompteCtrl {
    constructor() {
        this.initialiser();
    }

    //Méthode dédiée à l'initialisation du contrôleur
    initialiser() {}

    //Méthode chargée de récpérer les informations du formulaire de création de compte et de les envoyer au serveur
    pressCreerCompte() {
        let username = $("input[name='username']").val();
        let password = $("#input[name='password']").val();
        let passwordConfirm = $("#input[name='passwordConfirm']").val();
        httpService.creerCompte(username, password, passwordConfirm, loginSuccess, loginError); 
    }
}

//Fonction chargée d'informer l'utilisateur de la réussite de la création de compte
function creationCompteSuccess(message) {
    alert(message);
    indexCtrl.loadLogin();
}

//Fonction chargée d'informer l'utilisateur de la réussite de la création de compte
function creationCompteError(request, status, error) {
    alert.log("Création de compte échoué");
    console.log(request, status, error);
}