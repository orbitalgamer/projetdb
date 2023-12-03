<?php 

include_once 'Bdd.php';

class Course {
  public $Id;
  public $DateReservation;
  public $Payee;
  public $DistanceParcourue;
  public $IdClient;
  public $IdChauffeur;
  public $IdAdresseDepart;
  public $IdAdresseFin;
  public $IdTarification;
  public $IdMajoration;


  private $Bdd;
  private $NomTable = "course";

  public function __construct(){
      $db = new Bdd();
    $this->Bdd = $db->getBdd();
  }
  public function creation(){

     $query = "INSERT INTO $this->NomTable (
       Id,
       DateReservation,
       Paye,
       DistanceParcourue,
       IdClient,
       IdChauffeur,
       IdAdresseDepart,
       IdAdresseFin,
       IdTarification,
       IdMajoration)
       VALUES 
       (NULL,
       :DateReservation,
       :Payee,
       :DistanceParcourue,
       :IdClient,
       :IdChauffeur,
       :IdAdresseDepart,
       :IdAdresseFin,
       :IdTarification,
       :IdMajoration
       )";
      $rq = $this->Bdd->prepare($query);

      $rq->bindParam(':DateReservation',$this->DateReservation);
      $rq->bindParam(':Payee',$this->Payee);
      $rq->bindParam(':DistanceParcourue',$this->DistanceParcourue);
      $rq->bindParam(':IdClient',$this->IdClient);
      $rq->bindParam(':IdChauffeur',$this->IdChauffeur);
      $rq->bindParam(':IdAdresseDepart',$this->IdAdresseDepart);
      $rq->bindParam(':IdAdresseFin',$this->IdAdresseFin);
      $rq->bindParam(':IdTarification',$this->IdTarification);
      $rq->bindParam(':IdMajoration',$this->IdMajoration);
      if($rq->execute()){
        $rep=$rq->fetch(PDO::FETCH_ASSOC);
        echo "Marché";
        echo json_decode($rep);
      }
      else 
      {
        echo "pas marché";
    };





  }
      public function suppression()
      {
        $query = "DELETE FROM $this->NomTable WHERE Nom='$this->Id'";
        $rq = $this->Bdd->prepare($query);

        if($rq->execute()){
         echo"Suppr Marché";
        }
        else{
         echo "SUppr pas marché";
        }

      }

  public function GetAll(){ //pour avoir tous qui sont temriner correctement ou non
      $req = $this->Bdd->query("SELECT course.Id,
                                             course.DistanceParcourue, 
                                             chuffeur.Nom as 'NomChauffeur', 
                                             client.Nom as 'NomClient', 
                                             etat.Nom as 'NomEtat',
                                             IF(paye.IdEtat = 8 AND lien.IdEtat != 6, 1, 0) as 'Inpaye'
                                    FROM course
                                    INNER JOIN personne chuffeur on course.IdChauffeur = chuffeur.Id
                                    INNER JOIN personne client on course.IdClient = client.Id
                                    LEFT JOIN (SELECT * FROM liencourseetat WHERE IdEtat < 8 ORDER BY IdEtat DESC) lien on course.Id = lien.IdCourse
                                    LEFT JOIN (SELECT * FROM liencourseetat WHERE IdEtat = 8) paye on course.Id = paye.IdCourse
                                    INNER JOIN etat on lien.IdEtat = etat.Id
                                    WHERE lien.IdEtat >4
                                    GROUP BY course.Id
                                    ORDER BY Inpaye ASC
                                    ");
      //lien pour avoir les état
      //payé pour savoir si payé ou pas
      //affiche que ce qui sont terminé ceux en cours c'est dans dash board

      $retour = array();
      while($rep = $req->fetch()){
          array_push($retour, $rep);
      }
      return $retour;
  }
    public function Requete($requete){ //pour avoir tous
        $req = $this->Bdd->prepare("SELECT course.Id,
                                             course.DistanceParcourue, 
                                             chuffeur.Nom as 'NomChauffeur', 
                                             client.Nom as 'NomClient', 
                                             etat.Nom as 'NomEtat',
                                             IF(paye.IdEtat = 8 AND lien.IdEtat != 6, 1, 0) as 'Inpaye'
                                    FROM course
                                    INNER JOIN personne chuffeur on course.IdChauffeur = chuffeur.Id
                                    INNER JOIN personne client on course.IdClient = client.Id
                                    LEFT JOIN (SELECT * FROM liencourseetat WHERE IdEtat < 8 ORDER BY IdEtat DESC) lien on course.Id = lien.IdCourse
                                    LEFT JOIN (SELECT * FROM liencourseetat WHERE IdEtat = 8) paye on course.Id = paye.IdCourse
                                    INNER JOIN etat on lien.IdEtat = etat.Id
                                    WHERE lien.IdEtat >4
                                    AND(
                                        chuffeur.Nom LIKE :rq OR
                                        client.Nom LIKE :rq OR
                                        etat.Nom LIKE :rq
                                    )
                                    
                                    GROUP BY course.Id
                                    ORDER BY Inpaye ASC
                                    ");
        $requete = '%'.$requete.'%';
        $req->bindParam(':rq', $requete);
        $req->execute();
        $retour = array();
        while($rep = $req->fetch()){
            array_push($retour, $rep);
        }
        return $retour;
    }

    public function Get($Id){ //pour avoir tous
        $req = $this->Bdd->prepare("SELECT course.Id,
                                             course.DistanceParcourue,
                                             course.DateReservation as 'DateDebut', 
                                             chuffeur.Nom as 'NomChauffeur',
                                             chuffeur.Prenom as 'PrenomChauffeur',
                                             chuffeur.NumeroDeTelephone as 'TelChauffeur',
                                             chuffeur.Email as 'EmailChauffeur',
                                             client.Nom as 'NomClient',
                                             client.Prenom as 'PrenomClient',
                                             client.NumeroDeTelephone as 'TelClient',
                                             client.Email as 'EmailClient',
                                             etat.Nom as 'NomEtat',
                                             
                                             IF(paye.IdEtat = 8 AND lien.IdEtat != 6, 1, 0) as 'Inpaye',
                                             depart.Numero as 'NumeroDepart',
                                             depart.Rue as 'RueDepart',
                                             depart.Vile as 'VileDepart',
                                             localiteDepart.CodePostal as 'CPDepart',
                                             fin.Numero as 'NumeroFin',
                                             fin.Rue as 'RueFin',
                                             fin.Vile as 'VileFin',
                                             localiteFin.CodePostal as 'CPFin',
                                             tarification.PlaqueVehicule as 'Plaque' ,
                                             (tarification.PrixAuKilometre * course.DistanceParcourue) as 'Prix',
                                             tarification.PrixAuKilometre as 'Tarif'
                                             
                                             
                                    FROM course
                                    INNER JOIN personne chuffeur on course.IdChauffeur = chuffeur.Id
                                    INNER JOIN personne client on course.IdClient = client.Id
                                    LEFT JOIN (SELECT * FROM liencourseetat WHERE IdEtat < 8 ORDER BY IdEtat DESC) lien on course.Id = lien.IdCourse
                                    LEFT JOIN (SELECT * FROM liencourseetat WHERE IdEtat = 8) paye on course.Id = paye.IdCourse
                                    INNER JOIN etat on lien.IdEtat = etat.Id
                                        
                                    INNER JOIN adresse depart on depart.Id = course.IdAdresseDepart
                                    INNER JOIN localite localiteDepart on localiteDepart.Ville = depart.Vile
                                        
                                    INNER JOIN adresse fin on fin.Id = course.IdAdresseDepart
                                    INNER JOIN localite localiteFin on localiteFin.Ville = fin.Vile
                                    
                                    INNER JOIN tarification on course.IdTarification = tarification.Id
                                    
                                    WHERE course.Id = :Id
                                    
                                    GROUP BY course.Id
                                    ORDER BY Inpaye ASC
                                    ");
        $req->bindParam(':Id', $Id);
        $req->execute();
        return $req->fetch();
    }
    public function GetEtat($Id){
      $req = $this->Bdd->prepare("SELECT liencourseetat.*, etat.Nom FROM liencourseetat
         INNER JOIN etat on liencourseetat.IdEtat = etat.Id
         WHERE IdCourse = :Id
         ORDER BY IdEtat ASC");
      $req->bindParam(':Id', $Id);
      $req->execute();
      $retour = array();
      while($rep = $req->fetch()){
          array_push($retour, $rep);
      }
      return $retour;

    }
    public function GetPhoto($Id){
        $req = $this->Bdd->prepare("SELECT * FROM photocourse WHERE IdCourse = :Id");
        $req->bindParam(':Id', $Id);
        $req->execute();
        $retour = array();
        while($rep = $req->fetch()){
            array_push($retour, $rep);
        }
        return $retour;
    }

}

?>