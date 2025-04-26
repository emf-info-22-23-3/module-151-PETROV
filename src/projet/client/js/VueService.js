/*
 * @class
 * @classdesc Cette classe est responsable de la vue de l'application
 *
 * @author Tsvetoslav Petrov
 * @since 23.02.2025
 */
class VueService {
    constructor() { }
    
    chargerVue(vue, callback) {
        //charger la vue demandee
        $("#view").load("views/" + vue + ".html", function () {
            //si une fonction de callback est spécifiée, on l'appelle ici
            if (typeof callback !== "undefined") {
                callback();
            }
        });
    }
}
