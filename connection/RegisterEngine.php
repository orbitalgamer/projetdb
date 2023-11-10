<?php
session_start(); //démarer session car va stocker en sessions informations
include '../Bdd.php'; //récupère la connection db pour effectuer requètes


if(!empty($_POST['Nom']) && !empty($_POST['Prenom']) && !empty($_POST['Email']) && !empty($_POST['Mdp']) && !empty($_POST['MdpConfirm']) && !empty($_POST['Telephone'])){ //vérifier que on a bien mis toutes les infos

  //mets les entrée en minuscule pour éviter problème par après que trouve pas à cause majuscule
  $_POST['Nom'] = strtolower($_POST['Nom']);
  $_POST['Prenom'] = strtolower($_POST['Prenom']);
  $_POST['Email'] = strtolower($_POST['Email']);

  //va transformer tel car stock que sous forme 000 00 00 00
  $_POST['Telephone'] = str_replace('-', '', $_POST['Telephone']);
  $_POST['Telephone'] = str_replace(' ', '', $_POST['Telephone']);
  $_POST['Telephone'] = str_replace('04', '4', $_POST['Telephone']);
  var_dump($_POST);

  if($_POST['Mdp'] === $_POST['MdpConfirm']){ //vérifie que mot de passe sont identique
    //va verifier que email unique car crée id pour simplicité dans code après
        $req=$Bdd->prepare('SELECT `Email` FROM `personne` WHERE `personne`.`Email`=:email'); //demande que mail car pas besoin du reste
        $req->bindParam(':email', $_POST['email']); //mets en param
        $req->execute(); //execute
        $rep=$req->fetch(); 
        if($rep == null){ //si pas de réponse c'est que pas trouvé dans recherche => peut insert
            $req=$Bdd->prepare('INSERT INTO `personne` (`Nom`, `Prenom`, `Email`, `Mdp`, `NumeroDeTelephone`) 
                                                  VALUES(:nom, :prenom, :email, :mdp, :tel)');
            //mets param
            $req->bindParam(':nom', $_POST['Nom']);
            $req->bindParam(':prenom', $_POST['Prenom']);
            $req->bindParam(':email', $_POST['Email']);
            $req->bindParam(':tel', $_POST['Telephone']);
            $mdp=password_hash($_POST['Mdp'], PASSWORD_DEFAULT);
            $req->bindParam(':mdp', $mdp);
            $req->execute();
                
            //refait requète pour récuperer Id
            $req=$bdd->prepare('SELECT `Id` FROM `Personne` WHERE `Personne`.`Email`=?');
            $req->bindParam(':email', $_POST['email']);
            $rep=$req->fetch();
            $_SESSION['Id']=$rep['Id'];
            $_SESSION['Role']='Client'; //c'est le rôle par défaut utilisation juste pour affichage et rédigier vers bonne page verifeir lors de chaque requète malgré tout
              
            header("location: ../index.php");
        }
        else{
          header("location: ../index.php?erreur=3");
          echo "erreur=3";
        }
    }
    else{
      header("location: ../index.php?erreur=2");
      echo "erreur=2";
    }
}
else{
  header("location: ../index.php?erreur=1");
  echo "erreur=1";
}

/*
TABLEAU ERREUR
erreur 1 : Manque une information
erreur 2 : les mots de passe sont différent
erreue 3 :  email déjà utilisé-*

à faire system envoie mail
pour faire activation compte
*/

?>