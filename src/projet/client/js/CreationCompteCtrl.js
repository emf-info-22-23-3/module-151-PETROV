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
    initialiser() { }

    //Méthode chargée de récpérer les informations du formulaire de création de compte et de les envoyer au serveur
    pressCreerCompte() {
        let username = $("input[name='username']").val();
        let password = $("input[name='password']").val();
        let passwordConfirm = $("input[name='passwordConfirm']").val();
        httpService.creerCompte(username, password, passwordConfirm, this.creerCompteSuccess.bind(this), this.creerCompteeError.bind(this));
    }

    //Fonction chargée d'informer l'utilisateur de la réussite de la création de compte
    creerCompteSuccess(response) {
        alert(response.message);
        indexCtrl.loadLogin();
    }

    //Fonction chargée d'informer l'utilisateur de la réussite de la création de compte
    creerCompteeError(request, status, error) {
        alert("Erreur lors de la création du compte : " + JSON.parse(request.responseText).error);
    }

}

