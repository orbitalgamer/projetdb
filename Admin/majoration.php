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
    <table class="table table-striped table-responsive-md">
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
            $ligne = ' <form method="POST" action=""> <input type="hidden" name="Id" value="'.$elem['Id'].'"> <tr><th>' . $compteur . '</th>
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
            <td><input type="submit" value="ajouter" class="form-control bg-dark text-light" name="ajouter"/></td>
     </tr> </form>';
        echo $ligne;

        ?>

        </tbody>
    </table>
    <div class="text-center">
        <p class="pt-4 pb-2 bold h6">Attention il est impossible de supprimer un type de majoration si des courses ont été réalisées avec. Le bouton supprimer n'est que là pour les erreurs du gestionnaire</p>
    </div>
</div>
</html>
