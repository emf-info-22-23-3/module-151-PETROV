$(document).ready(function () {
    $.getScript('httpService.js', function(){
        console.log("servicesHttp.js chargé !");
        chargerEquipes(afficherEquipesSucces, afficherEquipesErreur);
    });
    
});

/*
function afficherEquipes(equipes) {
    let position = 1;
    equipes.forEach(equipe => {
        $('#equipesTable').append(`
        <tr>
            <td>${position}}</td>
            <td>${equipe}}</td>
        </tr>`);
        position++;
    });
}*/

function afficherEquipesErreur(request, status, error) {
    console.log("Erreur")
    alert("erreur : " + error + ", request: " + request + ", status: " + status);
}

function afficherEquipesSucces(data, status, error) {
    console.log("Succès")
    $.each(data, function(index, equipe) {
        var row = '<tr><td>' + equipe.id + '</td><td>' + equipe.nom + '</td></tr>';
        $('#equipesTable tbody').append(row);
    });
}
