/*
 * @class
 * @classdesc Cette classe fait office de contrôleur pour la page de connexion
 *
 * @author Tsvetoslav Petrov
 * @since 23.02.2025
*/
class LoginCtrl {
    //Constructeur de la classe LoginCtrl
    constructor() {
        this.initialiser();
    }

    //Méthode dédiée à l'initialisation du contrôleur
    initialiser() { }

    //Méthode chargée de récpérer les informations du formulaire de connexion et de les envoyer au serveur
    login() {
        let username = $("input[name='username']").val();
        let password = $("input[name='password']").val();
        httpService.login(username, password, this.loginSuccess.bind(this), this.loginError.bind(this));
    }

    //Méthode exécutée en cas de succès de la connexion
    loginSuccess(response) {
        if (response.success) {
            alert(response.message);
            indexCtrl.loadAccueil();
        }
    }
    
    //Méthode exécutée en cas d'échec de la connexion
    loginError(request, status, error) {
        alert("Erreur lors de la tentative de login : " + JSON.parse(request.responseText).error);
    }  

    //Méthode chargée de déconnecter l'utilisateur
    deconnecter() {
        httpService.deconnecter(deconnecterSuccess, deconnecterError);
    }

    //Méthode exécutée en cas de succès de la déconnexion
    deconnecterSuccess(response) {
        if (response.resultat) {
            alert(response.success);
            indexCtrl.loadAccueil();
        }
    }
    
    //Méthode exécutée en cas d'échec de la déconnexion
    deconnecterError(request, status, error) {
        let response = JSON.parse(request.responseText);
        alert(response.error);
    }
}

