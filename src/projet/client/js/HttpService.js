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

    /*
    **  $.ajaxSetup permet de définir une fois un élément sans le refaire par la suite.
    
    fetchGet(url) {
        return fetch(url)
            .then(resultat => { console.log(resultat);
                if (resultat !== null) { 
                    throw new Error(`Error ${resultat.status}: ${resultat.statusText}`);
                }
                return resultat.json();
            })
            .catch(error => {
                this.centraliserErreurHttp(error);
            });
    }*/


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

