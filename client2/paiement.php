<?php


include_once '../classes/course.php';

$course = new course();

if(empty($_GET['search'])) {
    $resultats = $course->GetAll();
}
else{
    $resultats = $course->Requete($_GET['search']);
}

function Afficher($liste){
    $compteur = 1;
    foreach ($liste as $elem) {
        if($elem['Inpaye'] == 0) {
            $ligne = '<tr class="table-danger">'; //pour mettre en évidence ceux qui ont problème
        }
        else{
            $ligne = '<tr>';
        }
        $ligne .= ' <td>' . $compteur . '</td>
            <td>' . $elem['NomChauffeur'] . '</td>
            <td>' . $elem["NomClient"] . '</td>
            <td>' . $elem["DistanceParcourue"] . '</td>
            <td>' . $elem["NomEtat"] . '</td>
            <td>' . $elem["Inpaye"] . '</td>
            <td><button type="button" class="btn btn-outline-secondary" onclick="window.location.href=`facture.php?Id=' . $elem["Id"] . '`">voir facture</button></td>
            <td><button type="button" class="btn btn-outline-secondary" onclick="../PageAcceuil.php">Payer</button></td>
     </tr>';
        echo $ligne;
        $compteur += 1;
    }
}
?>
    <?php 
  
    ?>
  
    
  <html>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Liste des Courses</p>
    </div>

    <table class="table table-sortable table-striped table-responsive-md">
        <thead class="table-light">
        <tr>
            <th scope="col h3">#</th>
            <th scope="col h3">Nom Chauffeur</th>
            <th scope="col h3">Nom Client</th>
            <th scope="col h3">Distance parcourue</th>
            <th scope="col h3">Status</th>
            <th scope="col h3">Payé</th>
            <th scope="col h3">Facture</th>
            <th scope="col h3"></th>

        </tr>
        </thead>
        <tbody class="table-group-divider">

        <?php
             session_start();
             require_once "../classes/bdd.php";
             include_once "../classes/course.php";
             include_once "../classes/personne.php";
             require_once "../classes/adresse.php";
             include_once "info_adresse.php";
             $base = new Bdd();
             $base = $base->getBdd();
          $query = "SELECT course.Id,
          course.DistanceParcourue, 
          chuffeur.Nom as 'NomChauffeur', 
          client.Nom as 'NomClient', 
          etat.Nom as 'NomEtat',
          IF(paye.IdEtat = (SELECT Id FROM etat WHERE Nom='Paye') AND lien.IdEtat != (SELECT Id FROM etat WHERE Nom='Annule par chauffeur'), 1, 0) as 'Inpaye'
      FROM course
      INNER JOIN personne chuffeur on course.IdChauffeur = chuffeur.Id
      INNER JOIN personne client on course.IdClient = client.Id
      LEFT JOIN (SELECT * FROM liencourseetat WHERE IdEtat < (SELECT Id FROM etat WHERE Nom='Paye') ORDER BY IdEtat DESC) lien on course.Id = lien.IdCourse
      LEFT JOIN (SELECT * FROM liencourseetat WHERE IdEtat = (SELECT Id FROM etat WHERE Nom='Paye')) paye on course.Id = paye.IdCourse
      INNER JOIN etat on lien.IdEtat = etat.Id
      WHERE (lien.IdEtat > (SELECT Id FROM etat WHERE Nom='En cours')) AND course.IdClient= :IdClient
      GROUP BY course.Id
      ORDER BY Inpaye ASC";
          $rq = $base->prepare($query);
          $rq->bindParam(":IdClient",$_SESSION["Id"]);
          $rq->execute();
          $rep = $rq->fetchAll();
      
     

        Afficher($rep);
        ?>
        </tbody>
    </table>
</div>
</html>
