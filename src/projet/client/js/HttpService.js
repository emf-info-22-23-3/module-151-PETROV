/*
 * @class
 * @classdesc Cette classe est responsable des service HTTP
 *
 * @author Tsvetoslav Petrov
 * @since 23.02.2025
 */

let url = "http://localhost:8080/projet/server/server.php";
class HttpService {
    constructor() { }

    //Méthode dédiée à la requête de login
    login(username, password, successCallback, errorCallback) {
      $.ajax({
        url: url,
        type: "POST",
        dataType: 'json',
        xhrFields: {
          withCredentials: true
        },
        data: "action=login&username=" + username + "&password=" + password,
        success: successCallback,
        error: errorCallback,

      });
    }

    //Méthode dédiée à la requête de vérification du type d'utilisateur
    checkUser(successCallback, errorCallback){
        $.ajax({
            url: url + "?action=checkUser",
            type: "GET",
            dataType: 'json',
            data: "",
            success: successCallback,
            error: errorCallback
          });
    }

    //Méthode dédiée à la requête de création de compte
    creerCompte(username, password, passwordConfirm, successCallback, errorCallback) {  
        $.ajax({
          url: url,
          type: "POST",
          dataType: 'json',
          data: "action=creationCompte&username=" + username + "&password=" + password + "&passwordConfirm=" + passwordConfirm,
          success: successCallback,
          error: errorCallback
        });
      }

      //Méthode dédiée à la requête de déconnexion
      deconnecter(successCallback, errorCallback) {  
        $.ajax({
          url: url,
          type: "POST",
          dataType: 'json',
          data: "action=deconnecter",
          success: successCallback,
          error: errorCallback
        });
      }
}

