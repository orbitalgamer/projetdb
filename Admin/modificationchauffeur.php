
<?php
include_once 'navbar.php';

include_once '../classes/personne.php';
include_once '../classes/chauffeur.php';

if(!empty($_GET['Id']) && empty($_POST)){ //vérifie pour suppression
    $chauf = new chauffeur();
    $chauf->RetirerChauffeur($_GET['Id']);
    header('location: chauffeurs.php');
}

if(!empty($_GET['IdAjout']) && empty($_POST)){ //vérifie pour suppression
    $chauf = new chauffeur();
    $chauf->Ajout($_GET['IdAjout']);
    header('location: chauffeurs.php');
}


$persone = new Personne();
if(!empty($_POST['Nom'])){
    $retour = $persone->Recherche($_POST['Nom']);
}
else{ //si pas de requète
    header('location: chauffeurs.php');
}

function Afficher($liste){
    $compteur = 1;
    foreach ($liste as $elem) {
        $ligne = ' <tr><th>' . $compteur . '</th>
            <td>' . $elem['Nom'] . '</td>
            <td>' . $elem["Prenom"] . '</td>
            <td>' . $elem["Email"] . '</td>
            <td>' . $elem["NumeroDeTelephone"] . '</td>
            <td><button type="button" class="btn btn-outline-secondary" onclick="window.location.href=`modificationchauffeur.php?IdAjout=' . $elem[0] . '`">Ajouter</button></td>
     </tr>';
        echo $ligne;
        $compteur += 1;
    }
    $ligne = '<tr>
                <th></th>
                </tr>';
}
?>

<html>
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Ajouter des Chauffeurs</p>
    </div>
    <div class="row align-items-center">

        <form class="col-md-4 form-group" action="" method="POST">
            <input type="search" class="form-control rounded" name="Nom" placeholder="rechercher" aria-label="Rechercher" aria-describedby="inputGroup-sizing-sm"/>
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
            <th scope="col h3">Supprimer</th>

        </tr>
        </thead>
        <tbody class="table-group-divider">

        <?php
        Afficher($retour);
        ?>
        </tbody>
    </table>
</div>
</html>
