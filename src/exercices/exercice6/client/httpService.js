/*
 * Couche de services HTTP (worker).
 *
 * @author Tsvetoslav Petrov
 * @version 1.0 / 27.01.2025
 */

var BASE_URL = "http://localhost:8080/exercices/exercice6/serveur/server.php";

function chargerEquipes(successCallback, errorCallback) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: BASE_URL,
        data: 'action=equipe',
        success: successCallback,
        error: errorCallback
    });
}