<?php
include_once 'navbar.php';

include_once '../classes/majoration.php';

$majo = new Majoration();





if(!empty($_POST)){
    if(!empty($_POST['modif'])){
        echo 'modif';
        $majo->Nom = $_POST['Nom'];
        $majo->Coefficient = $_POST['Coef'];
        $majo->Update($_POST['Id']);
        header('location: majoration.php'); //efface les post
    }

    if(!empty($_POST['ajouter'])){
        $majo->Nom = $_POST['Nom'];
        $majo->Coefficient = $_POST['Coef'];
        $majo->Insert();
        header('location: majoration.php'); //efface les post
    }

}

$resultat = $majo->Get();

?>

<html>
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Liste des Majorations</p>
    </div>
    <div class="row align-items-center">
    </div>
    <table class="table table-sortable table-striped table-responsive-md">
        <thead class="table-light">
        <tr>
            <th scope="col h3">#</th>
            <th scope="col h3">Nom Majoration</th>
            <th scope="col h3">Coefficient</th>
            <th scope="col h3"></th>
            <th scope="col h3"></th>
        </tr>
        </thead>
        <tbody class="table-group-divider">
        <?php
        $compteur = 1;
        foreach($resultat as $elem){
            $ligne = ' <form method="POST" action=""> <input type="hidden" name="Id" value="'.$elem['Id'].'"> <tr><td>' . $compteur . '</td>
            <td> <input type="text" class="form-control" name="Nom" value="' . $elem["Nom"] . '" required/></td>
            <td><input type="number" step="any" class="form-control" name="Coef" value="' . $elem["Coefficient"] . '" required/></td>
            <td><input type="submit" value="modifier" class="form-control" name="modif"/></td>
            <td><button type="button" class="btn btn-outline-danger btn-danger" onclick="window.location.href=`suppressionmajoration.php?Id=' . $elem["Id"] . '`">Supprimer</button></td>
            </tr> </form>';

            echo $ligne;
            $compteur += 1;

        }
        $ligne = ' <form method="POST" action=""> <input type="hidden" name="Id" value="New"> <tr><th>' . $compteur . '</th>
            <td> <input type="text" class="form-control" name="Nom" placeholder="Nouveau ?" required/></td>
            <td><input type="number" class="form-control" step="any" name="Coef" placeholder="?x" required/></td>
            <td><input type="submit" value="Ajouter" class="form-control bg-dark text-light" name="ajouter"/></td>
            <td></td>
     </tr> </form>';
        echo $ligne;

        ?>

        </tbody>
    </table>
    <div class="text-center">
        <p class="pt-4 pb-4 bold h6 alert alert-danger">Attention, il est impossible de supprimer un type de majoration si des courses ont été réalisées avec.<br> Le bouton supprimer n'est que là pour les erreurs du gestionnaire</p>
    </div>
</div>
<script>
    //pour trier dynamiquement table
    function  sortTableByColum(table, colmumn, asc=true){

        const dirModifier  = asc ? 1 : -1; //ordre de sort
        const tBody = table.tBodies[0];
        const rows = Array.from(tBody.querySelectorAll('tr')); //prend chaque élément
        const ajouter = rows.pop(); //retire le dernier élement



        //trillage
        const sortedRows = rows.sort( (a, b) => {

            const aColText = a.querySelector(`td:nth-child(${colmumn + 1})`).textContent.trim(); //prend leur élément à l'intérieur
            const bColText = b.querySelector(`td:nth-child(${colmumn + 1})`).textContent.trim(); //pareil pour le second

            return aColText>bColText ? (1*dirModifier) : (-1*dirModifier); //pour renovyer taille
        }); //méthode lambda

        //supprime les actue
        while(tBody.firstChild){
            tBody.removeChild(tBody.firstChild);
        }

        //rajoute les trier
        tBody.append(...sortedRows); //rajoute tous les rows dans le bon sens
        tBody.append(ajouter); //rajoute la bare ajouter

        //rapeler comment actuellemnet c'est trier
        table.querySelectorAll("th").forEach(th => th.classList.remove("th-sort-asc", "th-sort-desc"));
        table.querySelector(`th:nth-child(${colmumn +1 })`).classList.toggle("th-sort-asc", asc); //rajouter si on a tirer par ça
        table.querySelector(`th:nth-child(${colmumn+1 })`).classList.toggle("th-sort-desc", !asc);

    }


    document.querySelectorAll(".table-sortable th").forEach(headerCell => {
        headerCell.addEventListener("click", () =>{
            const tableElement = headerCell.parentElement.parentElement.parentElement; //pour revnier à parent
            const headerIndex = Array.prototype.indexOf.call(headerCell.parentElement.children, headerCell); //pour avoir tous les index ou on peut cliquer
            const currentIsAcending = headerCell.classList.contains("th-sort-asc"); //pour dire que c'est asc si montant ou pas
            if(headerIndex <= 3) { //pour pas trier suivant avis et supprimer
                sortTableByColum(tableElement, headerIndex, !currentIsAcending); //doit inverser pour changer de sens automatiquement
            }
        });
    });

</script>

<style>
    .table-sortable th{
        cursor: pointer;
    }

    .table-sortable .th-sort-asc::after{
        content: "\25b4";
    }

    .table-sortable .th-sort-desc::after{
        content: "\25be";
    }

    .table-sortable .th-sort-asc:after,.table-sortable .th-sort-desc:after{
        margin-left: 5px;
    }

    .table-sortable .th-sort-asc, .table-sortable .th-sort-desc{
        background: rgba(0,0,0,0.1);
    }
</style>
</html>
