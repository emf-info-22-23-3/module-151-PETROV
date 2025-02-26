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
    initialiser() {}

    pressCreerCompte() {
        let username = $("input[name='username']").val();
        let password = $("#input[name='password']").val();
        let passwordConfirm = $("#input[name='passwordConfirm']").val();
        httpService.creerCompte(username, password, passwordConfirm, loginSuccess, loginError); 
    }
}

function creationCompteSuccess(message) {
    alert(message);
    indexCtrl.loadLogin();
}

function creationCompteError(request, status, error) {
    alert.log("Création de compte échoué");
    console.log(request, status, error);
}