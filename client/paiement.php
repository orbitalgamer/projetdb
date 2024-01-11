<?php


include_once '../classes/course.php';
require_once "../classes/bdd.php";
$course = new course();
$base = new Bdd();
$bdd = $base->getBdd();
if(empty($_GET['search'])) {
    $resultats = $course->GetAll();
}
else{
    $resultats = $course->Requete($_GET['search']);
}

function Afficher($liste,$base){





    $compteur = 1;
    foreach ($liste as $elem) {

        //Recherche du nom de l'adresse 
        $query = 'SELECT Rue,Numero,Vile FROM adresse WHERE Id='.$elem['IdAdresseDepart'];
        $rq = $base->prepare($query);
        $rq->execute();
        $rep_adresseDepart=$rq->fetch(PDO::FETCH_ASSOC);
        
        $adresseDepartString = $rep_adresseDepart["Numero"] . " , "  . $rep_adresseDepart["Rue"] . " " . $rep_adresseDepart["Vile"];

        $query = 'SELECT Rue,Numero,Vile FROM adresse WHERE Id='.$elem['IdAdresseFin'];
        $rq = $base->prepare($query);
        $rq->execute();
        $rep_adresseFin=$rq->fetch(PDO::FETCH_ASSOC);
        
        $adresseFinString = $rep_adresseFin["Numero"] . " , "  . $rep_adresseFin["Rue"] . " " . $rep_adresseFin["Vile"] ;
    
        if($elem['Inpaye'] == 0) {
            $ligne = '<tr class="table-danger ligne">'; //pour mettre en évidence ceux qui ont problème
        }
        else{
            $ligne = '<tr class="ligne">';
        }
        $ligne .= ' <td>' . $compteur . '</td>
            <td id="date">' . $elem['DateReservation'] . '</td>
            <td>' . $adresseDepartString. '</td>
            <td>' . $adresseFinString . '</td>
            <td>' . $elem["NomEtat"] . '</td>
            <td>' . $elem["Paye"] . '</td>
            <td><button type="button" class="btn btn-outline-secondary" onclick="window.location.href=`facture.php?Id=' . $elem["Id"] . '`">voir facture</button></td>
            <td><button type="button" class="btn btn-outline-secondary" onclick="window.location.href=`avis.php?Id=' . $elem["Id"] . '`">Mettre un avis</button></td>
            <td><button type="button" class="btn btn-outline-secondary" onclick="window.location.href=`payer.php?Id=' . $elem["Id"] . '`">Payer</button></td>
     </tr>';
        echo $ligne;
        $compteur += 1;
    }
}
?>
    <?php 
  
    ?>
  
    
  <html>

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'blue': '#1e3a8a',
                        'black': '#030712',
                        'green': '#84cc16',
                        'white': '#FAF9F6'
                    },
                    height: {
                        '96': '64rem'
                    },
                    boxShadow: {
                        'base': "rgba(50, 50, 93, 0.25) 0px 30px 60px -12px inset, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px inset"
                    }
                }
            }
        }
    </script>

</head>
<nav class="bg-black h-12">
        <div class="mx-auto max-w-7xl max-h-7xl px-2 sm:px-6 lg:px-8">
            <div class="flex flex-row space-x-24 items-center">

                <a href="../index.php" class="text-gray-300 text-2xl font-weight">TAXEASY</a>


                <a href="../index.php" class="text-white font-medium shadow-2xl hover:text-slate-300">à propos</a>
                <a href="paiement.php" class="text-white font-medium shadow-2xl  hover:text-slate-300">Vos historiques de courses</a>
                <!-- <a href="../index.php" class="text-white font-medium shadow-2xl">à propos</a> -->

                <a href="../deconnection.php" class="text-white font-medium shadow-2xl  hover:text-slate-300">Deconnexion</a>

            </div>

        </div>
    </nav>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="container">
    <div class="text-center">
        <p class="display-4 pt-4 pb-2 bold">Historiques de vos courses</p>
    </div>
    


    <table class="table table-sortable table-striped table-responsive-md">
        <thead class="table-light">
        <tr>
            <th scope="col h3">#</th>
            <th scope="col h3">Date de Reservation</th>
            <th scope="col h3">Adresse de départ </th>
            <th scope="col h3">Adresse d'arrivé</th>
            <th scope="col h3">Etat</th>
            <th scope="col h3">Payé</th>
            <th scope="col h3">Facture</th>
            <th scope="col h3">Avis</th>
            <th scope="col h3"></th>
      

        </tr>
        </thead>
        <tbody class="table-group-divider">

        <?php
             session_start();
     
             include_once "../classes/course.php";
             include_once "../classes/personne.php";
             require_once "../classes/adresse.php";
             include_once "info_adresse.php";
             
          $query = "SELECT course.Id,
          course.DistanceParcourue,
          course.IdAdresseDepart,
          course.IdAdresseFin, 
          course.DateReservation,
          chuffeur.Nom as 'NomChauffeur', 
          client.Nom as 'NomClient', 
          etat.Nom as 'NomEtat',
          IF(paye.IdEtat = (SELECT Id FROM etat WHERE Nom='Paye') AND lien.IdEtat != (SELECT Id FROM etat WHERE Nom='Annule par chauffeur'), 1, 0) as 'Inpaye',
          count(paye.Id) as 'Paye'
      FROM course
      INNER JOIN personne chuffeur on course.IdChauffeur = chuffeur.Id
      INNER JOIN personne client on course.IdClient = client.Id
      LEFT JOIN (SELECT Id, Date, IdCourse, Max(IdEtat) as 'IdEtat' FROM liencourseetat WHERE IdEtat < (SELECT Id FROM etat WHERE Nom='Paye') GROUP BY IdCourse DESC) lien on course.Id = lien.IdCourse
      LEFT JOIN (SELECT * FROM liencourseetat WHERE IdEtat = (SELECT Id FROM etat WHERE Nom='Paye')) paye on course.Id = paye.IdCourse
      INNER JOIN etat on lien.IdEtat = etat.Id
      WHERE  course.IdClient = :IdClient
      GROUP BY course.Id
      ORDER BY Inpaye ASC";
          $rq = $bdd->prepare($query);
          $Id = (int) $_SESSION['Id'];
          $rq->bindParam(":IdClient",$Id);
          $rq->execute();

          $retour = array();
          while($rep = $rq->fetch()){
              
              array_push($retour, $rep);
          }



        Afficher($retour,$base);
        ?>
        </tbody>
    </table>
</div>

<script>
let lignes =  document.querySelectorAll("tr");
console.log(lignes);
let dateReservationStringArray = document.querySelectorAll("#date");
let dateReservationDateTimeArray = [];

dateReservationStringArray.forEach((date)=>{
    var dateString = date.innerText;
    var parts = dateString.split(' '); // Séparer la date et l'heure

    var datePart = parts[0];
    var timePart = parts[1];

   var dateParts = datePart.split('-');
   var timeParts = timePart.split(':');

   // Créer l'objet Date
   var dateToReturn = new Date(
  parseInt(dateParts[0], 10),   // Année
  parseInt(dateParts[1], 10) - 1, // Mois (soustraire 1 car les mois sont indexés de 0 à 11)
  parseInt(dateParts[2], 10),      // Jour
  parseInt(timeParts[0], 10),      // Heures
  parseInt(timeParts[1], 10),      // Minutes
  parseInt(timeParts[2], 10)       // Secondes
);




    console.log(date.innerText);
    
    dateReservationDateTimeArray.push(dateToReturn);

})

dateReservationDateTimeArray.sort(function(a,b){
    return b-a;
});

dateReservationStringArray.forEach((date)=>{
    lignes.forEach((ligne)=>{
        if(ligne.innerText.includes(date.innerText))
        {
           
        }
        else{
            console.log("false");
        }
    })

})

console.log(dateReservationDateTimeArray);

</script>


</html> 
