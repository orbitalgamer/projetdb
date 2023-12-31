


<?php

require_once 'bdd.php';
require_once 'mail.php';



class Personne  {
    public $Id;
    public $Nom;
    public $Prenom;
    public $Email;
    public $Mdp;
    public $NumTel;
    public $IdStatus;

   private $Bdd;
   private $NomTable = "personne";
   private $NomTableType = "typepersonne";

   



   public function suppression(){
       $query = "DELETE FROM $this->NomTable WHERE Nom='$this->Nom'";
       $rq = $this->Bdd->prepare($query);

       if($rq->execute()){
        echo"Suppr Marché";
       }
       else{
        echo "SUppr pas marché";
       }
   }


   public function __construct()
    {
        $db = new Bdd();
        $this->Bdd = $db->getBdd();
    }


   public function creation($MdpConf){
       //mets les entrée en minuscule pour éviter problème par après que trouve pas à cause majuscule
       $this->Nom = strtolower($this->Nom);
       $this->Prenom = strtolower($this->Prenom);
       $this->Email = strtolower($this->Email);

       //va transformer tel car stock que sous forme 000 00 00 00
       $this->NumTel = str_replace('-', '', $this->NumTel);
       $this->NumTel = str_replace(' ', '', $this->NumTel);
       $this->NumTel = str_replace('04', '4', $this->NumTel);

       if($this->Mdp === $MdpConf){ //vérifie que mot de passe sont identique
           //va verifier que email unique car crée id pour simplicité dans code après
           $req=$this->Bdd->prepare('SELECT `Email` FROM `personne` WHERE `personne`.`Email`=:email'); //demande que mail car pas besoin du reste
           $req->bindParam(':email', $this->Email); //mets en param
           $req->execute(); //execute
           $rep=$req->fetch();
           if($rep == null){ //si pas de réponse c'est que pas trouvé dans recherche => peut insert
               $req=$this->Bdd->prepare('INSERT INTO `personne` (`Nom`, `Prenom`, `Email`, `Mdp`, `NumeroDeTelephone`) 
                                                  VALUES(:nom, :prenom, :email, :mdp, :tel)');
               //mets param
               $req->bindParam(':nom', $this->Nom);
               $req->bindParam(':prenom', $this->Prenom);
               $req->bindParam(':email', $this->Email);
               $req->bindParam(':tel', $this->NumTel);
               $mdp=password_hash($this->Mdp, PASSWORD_DEFAULT);
               $req->bindParam(':mdp', $mdp);
               $req->execute();

               //refait requète pour récuperer Id
               $req=$this->Bdd->prepare('SELECT `Id` FROM `Personne` WHERE `Personne`.`Email`=?');
               $req->bindParam(':email', $this->Email);
               $rep=$req->fetch();
               $_SESSION['Id']=$rep['Id'];
               $_SESSION['Role']='Client'; //c'est le rôle par défaut utilisation juste pour affichage et rédigier vers bonne page verifeir lors de chaque requète malgré tout

               return array('succes'=>'1');
           }
           else{
               return array('error'=>'existe deja');
           }
       }
       else{
           return array('error'=>'mdp different');
       }
   }


    /**
     * fonction verficiation de connection
     * @param $email
     * @param $mdp
     * @return void
     */
   public function connection($email, $mdp){
       $req=$this->Bdd->prepare("SELECT personne.Id, personne.Mdp, personne.Nom, personne.Prenom, typepersonne.NomTitre as 'titre' FROM personne 
                                JOIN typepersonne on typepersonne.Id = personne.IdStatus 
                                WHERE personne.Email = :email"); // va cherche status et mdp hashé par rapport à son email
        $req->bindParam(':email', $email);
        $req->execute();
        if($rep=$req->fetch()){ //prend résultat s'il y a
            if($rep['titre'] != 'Banni') {
                if (password_verify($mdp, $rep['Mdp'])) { //vérifie mots de passe
                    $_SESSION['Id'] = $rep['Id']; //si bon mets en sessions pour plus tard
                    $_SESSION['Role'] = $rep['titre']; //stock titre
                    $_SESSION['Nom']=$rep['Nom'];
                    $_SESSION['Prenom']=$rep['Prenom'];

                    return array('succes' => '1'); //renvoie que tout a été
                } else {
                    return array('error' => 'erreur'); //renvoie erreur
                }
            }
            else{
                return array('error'=>'Banni');
            }
        }
        else{
            return array('error'=>'erreur'); //renvoie erreur
        }
}


   public function modification(){
    $query = "SELECT Nom,Prenom,Email,Mdp,NumeroDeTelephone FROM $this->NomTable WHERE Id='$this->Id'"; 
    $rq = $this->Bdd->prepare($query);

    $rq->execute();
    $rep=$rq->fetch(PDO::FETCH_ASSOC);
    
    $query =  "UPDATE $this->NomTable SET Nom='$this->Nom',Prenom='$this->Prenom',Email='$this->Email',Mdp='$this->Mdp',NumeroDeTelephone='$this->NumTel' WHERE Id='$this->Id'";
    $rq =$this->Bdd->prepare($query);
    if(!isset($this->Nom)){
        $this->Nom=$rep['Nom'];
    };
    if(!isset($this->Prenom)){
        $this->Prenom=$rep['Prenom'];
    };
    if(!isset($this->Email)){
        $this->Email=$rep['Email'];
    };
    if(!isset($this->Mdp)){
        $this->Mdp=$rep['Mdp'];
    };
    if(!isset($this->NumTel)){
        $this->NumTel=$rep['NumeroDeTelephone'];
    };
    $rq->execute();
    echo json_encode($rep);
   }
   public function selection(){
    $query = "SELECT Nom,Prenom,Email,Mdp,NumeroDeTelephone,IdStatus FROM $this->NomTable WHERE Id='$this->Id'"; 
    $rq = $this->Bdd->prepare($query);
    $rq->execute();
    $rep=$rq->fetch(PDO::FETCH_ASSOC);
    echo json_encode($rep);


   }

   public function Recherche($requete){
       $req=$this->Bdd->prepare("SELECT * FROM personne
                            INNER JOIN typepersonne on personne.IdStatus = typepersonne.Id
                            WHERE typepersonne.NomTitre = 'Client' AND(Nom LIKE :rq OR 
                           Prenom LIKE :rq OR 
                           Email LIKE :rq OR
                           NumeroDeTelephone LIKE :rq)");
       $requete = '%'.$requete.'%';
       $req->bindParam(':rq', $requete);
       $req->execute();

       $retour = array();
       while($rep = $req->fetch()){
           array_push($retour, $rep);
       }
       return $retour;
   }

   public function GetAll(){
       $req = $this->Bdd->query("SELECT personne.*, prix.Inpaye FROM personne 
                                    INNER JOIN typepersonne ON personne.IdStatus = typepersonne.Id
                                    LEFT JOIN course ON personne.Id = course.IdClient
                                    LEFT JOIN (SELECT course.Id, 
                                                      course.IdClient, 
                                                      SUM(tarification.PrixAuKilometre * course.DistanceParcourue) as 'Inpaye' 
                                                FROM course
                                                LEFT JOIN  liencourseetat on course.Id = liencourseetat.IdCourse
                                                LEFT JOIN tarification on course.IdTarification = tarification.Id
                                                INNER JOIN etat on liencourseetat.IdEtat = etat.Id
                                                WHERE etat.Nom = 'Termine'
                                                GROUP BY course.IdClient) prix ON personne.Id = course.IdClient
                                    LEFT JOIN liencourseetat ON course.Id = liencourseetat.IdCourse
                                    WHERE typepersonne.NomTitre = 'Client'
                                    GROUP BY personne.Id");
       $retour = array();
       while($rep = $req->fetch()){
           array_push($retour, $rep);
       }
       return $retour;
   }

   public function RequetteAffichage($requete){
       $req = $this->Bdd->prepare("SELECT personne.*, prix.Inpaye as 'Inpaye' FROM personne 
                                    INNER JOIN typepersonne ON personne.IdStatus = typepersonne.Id
                                    LEFT JOIN course ON personne.Id = course.IdClient
                                    LEFT JOIN (SELECT course.Id, 
                                                      course.IdClient, 
                                                      count(tarification.PrixAuKilometre * course.DistanceParcourue) as 'Inpaye' 
                                                FROM course
                                                LEFT JOIN  liencourseetat on course.Id = liencourseetat.IdCourse
                                                LEFT JOIN tarification on course.IdTarification = tarification.Id
                                                INNER JOIN etat on liencourseetat.IdEtat = etat.Id
                                                WHERE etat.Nom = 'Termine'
                                                GROUP BY course.IdClient) prix ON personne.Id = course.IdClient
                                    LEFT JOIN liencourseetat ON course.Id = liencourseetat.IdCourse
                                    WHERE typepersonne.NomTitre = 'Client'
                                    AND(personne.Nom LIKE :rq 
                                            OR personne.Prenom LIKE :rq 
                                            OR personne.NumeroDeTelephone LIKE :rq 
                                            OR personne.Email LIKE :rq)
                                    GROUP BY personne.Id");
       $requete = '%'.$requete.'%';
       $req->bindParam(':rq', $requete);
       $req->execute();

       $retour = array();
       while($rep = $req->fetch()){
           array_push($retour, $rep);
       }
       return $retour;
   }

    public function Get($Id){
        $req = $this->Bdd->prepare("SELECT personne.*, prix.Inpaye as 'Inpaye' FROM personne 
                                    INNER JOIN typepersonne ON personne.IdStatus = typepersonne.Id
                                    LEFT JOIN course ON personne.Id = course.IdClient
                                    LEFT JOIN (SELECT course.Id, 
                                                      course.IdClient, 
                                                      count(tarification.PrixAuKilometre * course.DistanceParcourue) as 'Inpaye' 
                                                FROM course
                                                LEFT JOIN  liencourseetat on course.Id = liencourseetat.IdCourse
                                                LEFT JOIN tarification on course.IdTarification = tarification.Id
                                                INNER JOIN etat on liencourseetat.IdEtat = etat.Id
                                                WHERE etat.Nom = 'Termine'
                                                GROUP BY course.IdClient) prix ON personne.Id = course.IdClient
                                    LEFT JOIN liencourseetat ON course.Id = liencourseetat.IdCourse
                                    WHERE typepersonne.NomTitre = 'Client' AND personne.Id = :Id");

        $req->bindParam(':Id', $Id);
        $req->execute();
        return $req->fetch();
    }

   public function Bannir($Id){
       $req = $this->Bdd->prepare("UPDATE personne SET IdStatus = 4 WHERE Id =:Id AND IdStatus = 1");
       $persone = $this->Get($Id);
       $req->bindParam(':Id', $Id);
       if($req->execute()){
           $mail = new mail();
           $Dest = $persone['Email'];
           $Sujet = "[taxeasy] bannissement";
           $Message = "Suite à des plus grande vérificaiton, nous avons décider de suspendre indifiniment. Une raison principal est votre solde impayé s'élevant à".$persone['Inpaye'].utf8_decode('euros. ');
           $mail->SendMail($Dest, $Sujet, $Message);
           return array("succes"=>1);
       }
       else{
           return array("error"=>1);
       }
   }
    public function DeBannir($Id){
        $req = $this->Bdd->prepare("UPDATE personne SET IdStatus = 1 WHERE Id =:Id AND IdStatus = 4");
        $persone = $this->Get($Id);
        $req->bindParam(':Id', $Id);
        if($req->execute()){
            $mail = new mail();
            $Dest = $persone['Email'];
            $Sujet = "[taxeasy] debannissement";
            $Message = "Suite a une rélfexion, nous avons décidé de lever votre interdiction d'utiliser notre services.";
            $mail->SendMail($Dest, $Sujet, $Message);
            return array("succes"=>1);
        }
        else{
            return array("error"=>1);
        }
    }

    public function GetAllBanni(){
        $req = $this->Bdd->query("SELECT personne.*, prix.Inpaye FROM personne 
                                    INNER JOIN typepersonne ON personne.IdStatus = typepersonne.Id
                                    LEFT JOIN course ON personne.Id = course.IdClient
                                    LEFT JOIN (SELECT course.Id, 
                                                      course.IdClient, 
                                                      count(tarification.PrixAuKilometre * course.DistanceParcourue) as 'Inpaye' 
                                                FROM course
                                                LEFT JOIN  liencourseetat on course.Id = liencourseetat.IdCourse
                                                LEFT JOIN tarification on course.IdTarification = tarification.Id
                                                WHERE liencourseetat.IdEtat = 6
                                                GROUP BY course.IdClient) prix ON personne.Id = course.IdClient
                                    LEFT JOIN liencourseetat ON course.Id = liencourseetat.IdCourse
                                    WHERE typepersonne.NomTitre = 'Banni'
                                    GROUP BY personne.Id");
        $retour = array();
        while($rep = $req->fetch()){
            array_push($retour, $rep);
        }
        return $retour;
    }

    public function RequetteAffichageBanni($requete){
        $req = $this->Bdd->prepare("SELECT personne.*, prix.Inpaye as 'Inpaye' FROM personne 
                                    INNER JOIN typepersonne ON personne.IdStatus = typepersonne.Id
                                    LEFT JOIN course ON personne.Id = course.IdClient
                                    LEFT JOIN (SELECT course.Id, 
                                                      course.IdClient, 
                                                      count(tarification.PrixAuKilometre * course.DistanceParcourue) as 'Inpaye' 
                                                FROM course
                                                LEFT JOIN  liencourseetat on course.Id = liencourseetat.IdCourse
                                                LEFT JOIN tarification on course.IdTarification = tarification.Id
                                                INNER JOIN etat on liencourseetat.IdEtat = etat.Id
                                                WHERE etat.Nom = 'Termine'
                                                GROUP BY course.IdClient) prix ON personne.Id = course.IdClient
                                    LEFT JOIN liencourseetat ON course.Id = liencourseetat.IdCourse
                                    WHERE typepersonne.NomTitre = 'Banni'
                                    AND(personne.Nom LIKE :rq 
                                            OR personne.Prenom LIKE :rq 
                                            OR personne.NumeroDeTelephone LIKE :rq 
                                            OR personne.Email LIKE :rq)
                                    GROUP BY personne.Id");
        $requete = '%'.$requete.'%';
        $req->bindParam(':rq', $requete);
        $req->execute();

        $retour = array();
        while($rep = $req->fetch()){
            array_push($retour, $rep);
        }
        return $retour;
    }

    public function GetAdmin(){
       $req = $this->Bdd->query("SELECT * FROM personne INNER JOIN typepersonne on personne.IdStatus = typepersonne.Id WHERE typepersonne.NomTitre='Admin'");
       $retour = array();
       while($rep = $req->fetch()){
           array_push($retour, $rep);
       }
       return $retour;
    }

}




?>