/*
 * @class
 * @classdesc Cette classe fait office de contrôleur pour la page de création de compte
 *
 * @author Tsvetoslav Petrov
 * @since 23.02.2025
*/
class CreationCompteCtrl {
    //Constructeur de la classe CreationCompteCtrl
    constructor() {
        this.initialiser();
    }

    //Méthode dédiée à l'initialisation du contrôleur
    initialiser() { 
        const self = this;
        $(`.login-form-button`).on("click", () => {
            self.pressCreerCompte();
        });
    }

    //Méthode chargée de récupérer les informations du formulaire de création de compte et de les envoyer au serveur
    pressCreerCompte() {
        let username = $("input[name='username']").val();
        let password = $("input[name='password']").val();
        let passwordConfirm = $("input[name='passwordConfirm']").val();
        httpService.creerCompte(username, password, passwordConfirm, this.creerCompteSuccess.bind(this), this.creerCompteeError.bind(this));
    }

    //Méthode exécutée en cas de succès de la création de compte
    creerCompteSuccess(response) {
        alert(response.message);
        indexCtrl.loadLogin();
    }

    //Méthode exécutée en cas d'échec de la création de compte
    creerCompteeError(request, status, error) {
        alert("Erreur lors de la création du compte : " + JSON.parse(request.responseText).error);
    }

}

