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

    //Méthode dédiée à l'initialisation du contrôleur
    initialiser() {}

    //Méthode chargée de récpérer les informations du formulaire de connexion et de les envoyer au serveur
    login() {
        let username = $("input[name='username']").val();
        let password = $("input[name='password']").val();
        httpService.login(username, password, loginSuccess, loginError); 
    }

    //Méthode chargée de déconnecter l'utilisateur
    deconnecter(){
        httpService.deconnecter(deconnecterSuccess, deconnecterError);
    }
}

//Fonction chargée d'informer l'utilisateur de la réussite de la connexion
function loginSuccess(response) {
    if (response.resultat) {    
        alert(response.success);
        //indexCtrl.loadAccueil();
    }
}

//Fonction chargée d'informer l'utilisateur de l'échec de la connexion
function loginError(request, status, error) {
    let response = JSON.parse(request.responseText);
    alert(response.error);
}

//Fonction chargée d'informer l'utilisateur de la réussite de la déconnexion
function deconnecterSuccess(response) {
    if (response.resultat) {
        alert(response.success);
        indexCtrl.loadAccueil();
    }
}

//Fonction chargée d'informer l'utilisateur de l'échec de la déconnexion
function deconnecterError(request, status, error) {
    let response = JSON.parse(request.responseText);
    alert(response.error);
}