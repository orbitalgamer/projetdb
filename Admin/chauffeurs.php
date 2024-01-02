<?php
include_once 'navbar.php';

include_once '../classes/chauffeur.php';

$chauf = new chauffeur();
$resultats = $chauf->GetAll();

function Afficher($liste){
    $compteur = 1;
    foreach ($liste as $elem) {
        $ligne = ' <tr><td>' . $compteur . '</td>
            <td>' . $elem['Nom'] . '</td>
            <td>' . $elem["Prenom"] . '</td>
            <td>' . $elem["Email"] . '</td>
            <td>' . $elem["NumeroDeTelephone"] . '</td>
            <td>' . $elem["CourseFaite"] . '</td>
            <td><button type="button" class="btn btn-outline-secondary" onclick="window.location.href=`avis.php?IdPersonne=' . $elem["Id"] . '`">voir avis</button></td>
            <td><button type="button" class="btn btn-outline-danger" onclick="window.location.href=`modificationchauffeur.php?Id=' . $elem["Id"] . '`">Supprimer</button></td>
     </tr>';
        echo $ligne;
        $compteur += 1;
    }
    $ligne = '<tr>
                <form method="POST" action="modificationchauffeur.php">
                <th>' .$compteur.'</th>
                <td colspan="4"> <input type="text" class="form-control" name="Nom" placeholder="recherche nom, prenom, email, ..." required></td>
               
                </form>
                <th><input type="submit" class="form-control text-light bg-dark" name="Rechercher" value="Ajouter"></th>
                </tr>';
    echo $ligne;
}
?>

<html>
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Liste des Chauffeurs</p>
    </div>
    <div class="row align-items-center">
    
        <form class="col-md-4 form-group" action="" method="">
            <input type="search" class="form-control rounded" name="search" placeholder="rechercher : Nom, Prenom, N° tel..." aria-label="Rechercher" aria-describedby="inputGroup-sizing-sm"/>
        </form>
    </div>
    <table id="dtBasicExample"  class="table table-sortable table-striped table-responsive-md">
        <thead class="table-light">
        <tr>
            <th scope="col h3">#</th>
            <th scope="col h3">Nom</th>
            <th scope="col h3">Prénom</th>
            <th scope="col h3">Email</th>
            <th scope="col h3">Numéro Téléphone</th>
            <th scope="col h3">Courses Réalisées</th>
            <th scope="col h3">Avis</th>
            <th scope="col h3">Supprimer</th>

        </tr>
        </thead>
        <tbody class="table-group-divider">

            <?php
            
            if(empty($_GET['search']) && empty($_GET['maitenance'])) {
                $all = $chauf->GetAll();
                Afficher($all);
            }
            else{
                if(!empty($_GET['search'])){
                    $resultat = $chauf->Recherche($_GET['search']);
                    Afficher($resultat);
                }

            }
            ?>
        </tbody>
    </table>
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
            if(headerIndex <= 5) { //pour pas trier suivant avis et supprimer
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
