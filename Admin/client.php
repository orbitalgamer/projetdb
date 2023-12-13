<?php
include_once 'navbar.php';

include_once '../classes/personne.php';

$chauf = new Personne();

if(!empty($_GET['Id'])){ //si IdDéfini pour bannirx
    $chauf->Bannir($_GET['Id']);
    header('location: client.php');
}

if(!empty($_GET['IdBanni'])){ //si IdDéfini pour bannirx
    $chauf->DeBannir($_GET['IdBanni']);
    header('location: client.php');
}


if(empty($_GET['search'])) {
    $resultats = $chauf->GetAll();
}
else{
    $resultats = $chauf->RequetteAffichage($_GET['search']);
}

?>

<html>
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Liste des Clients</p>
    </div>
    <div class="row align-items-center">

        <form class="col-md-4 form-group" action="" method="">
            <input type="search" class="form-control rounded" name="search" placeholder="rechercher nom, prenom, N° tel..." aria-label="Rechercher" aria-describedby="inputGroup-sizing-sm"/>
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
            <th scope="col h3">Impayé</th>
            <th scope="col h3">Avis</th>
            <th scope="col h3">Bannir</th>

        </tr>
        </thead>
        <tbody class="table-group-divider">

        <?php

        $compteur = 1;
        foreach ($resultats as $elem) {
            if($elem['Inpaye'] != 0) {
                $ligne = '<tr class="table-danger">'; //pour mettre en évidence ceux qui ont problème
            }
            else{
                $ligne = '<tr>';
            }
            $ligne .= ' <th>' . $compteur . '</th>
            <td>' . $elem['Nom'] . '</td>
            <td>' . $elem["Prenom"] . '</td>
            <td>' . $elem["Email"] . '</td>
            <td>' . $elem["NumeroDeTelephone"] . '</td>
            <td>' . $elem["Inpaye"] . '</td>
            <td><button type="button" class="btn btn-outline-secondary" onclick="window.location.href=`voiravis.php?IdPersonne=' . $elem["Id"] . '`">voir avis</button></td>
            <td><button type="button" class="btn btn-outline-secondary" onclick="window.location.href=`client.php?Id=' . $elem["Id"] . '`">Bannir</button></td>
     </tr>';
            echo $ligne;
            $compteur += 1;
        }
        ?>
        </tbody>
    </table>
</div>
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Liste des Bannis</p>
    </div>
    <div class="row align-items-center">


    </div>
    <table class="table table-striped table-responsive-md">
        <thead class="table-light">
        <tr>
            <th scope="col h3">#</th>
            <th scope="col h3">Nom</th>
            <th scope="col h3">Prenom</th>
            <th scope="col h3">Email</th>
            <th scope="col h3">NumeroDeTelephone</th>
            <th scope="col h3">Impayé</th>
            <th scope="col h3">Avis</th>
            <th scope="col h3">Débannir</th>

        </tr>
        </thead>
        <tbody class="table-group-divider">

        <?php
        $resultats = $chauf->GetAllBanni();
        if(!empty($_GET['search'])){
            $resultats = $chauf->RequetteAffichageBanni($_GET['search']);
        }
        $compteur = 1;
        foreach ($resultats as $elem) {
            if($elem['Inpaye'] != 0) {
                $ligne = '<tr class="table-danger">'; //pour mettre en évidence ceux qui ont problème
            }
            else{
                $ligne = '<tr>';
            }
            $ligne .= ' <th>' . $compteur . '</th>
            <td>' . $elem['Nom'] . '</td>
            <td>' . $elem["Prenom"] . '</td>
            <td>' . $elem["Email"] . '</td>
            <td>' . $elem["NumeroDeTelephone"] . '</td>
            <td>' . $elem["Inpaye"] . '</td>
            <td><button type="button" class="btn btn-outline-secondary" onclick="window.location.href=`voiravis.php?IdPersonne=' . $elem["Id"] . '`">voir avis</button></td>
            <td><button type="button" class="btn btn-outline-secondary" onclick="window.location.href=`client.php?IdBanni=' . $elem["Id"] . '`">Débannir</button></td>
     </tr>';
            echo $ligne;
            $compteur += 1;
        }
        ?>
        </tbody>
    </table>
</div>
</html>
