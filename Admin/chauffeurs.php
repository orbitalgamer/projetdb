<?php
include_once 'navbar.php';

include_once '../classes/chauffeur.php';

$chauf = new chauffeur();
$resultats = $chauf->GetAll();

function Afficher($liste){
    $compteur = 1;
    foreach ($liste as $elem) {
        $ligne = ' <tr><th>' . $compteur . '</th>
            <td>' . $elem['Nom'] . '</td>
            <td>' . $elem["Prenom"] . '</td>
            <td>' . $elem["Email"] . '</td>
            <td>' . $elem["NumeroDeTelephone"] . '</td>
            <td><button type="button" class="btn btn-outline-secondary" onclick="window.location.href=`voiravis.php?IdChauffeur=' . $elem["Id"] . '`">voir avis</button></td>
            <td><button type="button" class="btn btn-outline-secondary" onclick="window.location.href=`modificationchauffeur.php?Id=' . $elem["Id"] . '`">Supprimers</button></td>
     </tr>';
        echo $ligne;
        $compteur += 1;
    }
    $ligne = '<tr>
                <form method="POST" action="modificationchauffeur.php">
                <th>' .$compteur.'</th>
                <td colspan="4"> <input type="text" class="form-control" name="Nom" placeholder="recherche nom, prenom, email, ..." required></td>
               
                </form>
                <th><input type="submit" class="form-control text-light bg-dark" name="Rechercher" value="Rechercher"></th>
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
            <input type="search" class="form-control rounded" name="search" placeholder="rechercher" aria-label="Rechercher" aria-describedby="inputGroup-sizing-sm"/>
        </form>
    </div>
    <table class="table table-striped table-responsive-md">
        <thead class="table-light">
        <tr>
            <th scope="col h3">#</th>
            <th scope="col h3">Nom</th>
            <th scope="col h3">Prenom</th>
            <th scope="col h3">Email</th>
            <th scope="col h3">NumeroDeTelephone</th>
            <th scope="col h3">avis</th>
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
</html>
