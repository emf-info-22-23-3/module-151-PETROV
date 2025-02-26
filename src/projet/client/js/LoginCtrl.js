/*
 * @class
 * @classdesc Cette classe fait office de contrôleur pour la page de connexion
 *
 * @author Tsvetoslav Petrov
 * @since 23.02.2025
*/

class LoginCtrl {
    constructor() {
        this.initialiser();
    }

    initialiser() {}

    login() {
        let username = $("input[name='username']").val();
        let password = $("input[name='password']").val();
        httpService.login(username, password, loginSuccess, loginError); 
    }

    deconnecter(){
        httpService.deconnecter(deconnecterSuccess, deconnecterError);
    }
}

function loginSuccess(response) {
    if (response.resultat) {    
        alert(response.success);
        //indexCtrl.loadAccueil();
    }
}

function loginError(request, status, error) {
    let response = JSON.parse(request.responseText);
    alert(response.error);
}

function deconnecterSuccess(response) {
    if (response.resultat) {
        alert(response.success);
        indexCtrl.loadAccueil();
    }
}

function deconnecterError(request, status, error) {
    let response = JSON.parse(request.responseText);
    alert(response.error);
}