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
  public $Date;
  public $IdEtat;


  private $Bdd;
  private $NomTable = "course";

  public function __construct(){
      $db = new Bdd();
    $this->Bdd = $db->getBdd();
  }
  public function creationlien(){
    $query = "INSERT INTO $this->NomTable (
      Id,
      Date,
      IdCourse,
      IdEtat)
      VALUES 
      (NULL,
      :Date,
      :IdCourse,
      :IdEtat,
      :IdClient,
      :IdChauffeur,
      )";
     $rq = $this->Bdd->prepare($query);

     $rq->bindParam(':Date',$this->Date);
     $rq->bindParam(':IdCourse',$this->IdCourse);
     $rq->bindParam(':IdEtat',$this->IdEtat);
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

    public function Update(){
      if(!empty($this->Id) && !empty($this->DateReservation) && !empty($this->Payee) && !empty($this->DistanceParcourue) && !empty($this->IdClient) && !empty($this->IdChauffeur) && !empty($this->IdAdresseDepart) && !empty($this->IdAdresseFin) && !empty($this->IdTarification) && isset($this->IdMajoration)) {
          $req = $this->Bdd->prepare("SELECT Id FROM course WHERE Id = :Idcourse");
          $req->bindParam(':Idcourse', $this->Id);
          $req->execute();

          if ($req->fetch()) {
              $req = $this->Bdd->prepare("
                                  UPDATE course SET 
                                                      Id =:Idcourse,
                                                      DateReservation =:DateReservation, 
                                                      Payee = :Payee,
                    DistanceParcourue = :DistanceParcourue,
                    IdClient = :IdClient,
                    IdChauffeur = :IdChauffeur,
                    IdAdresseDepart = :IdAdresseDepart,
                    IdAdresseFin = :IdAdresseFin,
                    IdTarification = :IdTarification,
                    IdMajoration = :IdMajoration
                WHERE Id = :Idcourse
            ");
            $req->bindParam(':Idcourse', $this->Id);
            $req->bindParam(':DateReservation', $this->DateReservation);
            $req->bindParam(':Payee', $this->Payee);
            $req->bindParam(':DistanceParcourue', $this->DistanceParcourue);
            $req->bindParam(':IdClient', $this->IdClient);
            $req->bindParam(':IdChauffeur', $this->IdChauffeur);
            $req->bindParam(':IdAdresseDepart', $this->IdAdresseDepart);
            $req->bindParam(':IdAdresseFin', $this->IdAdresseFin);
            $req->bindParam(':IdTarification', $this->IdTarification);
            $req->bindParam(':IdMajoration', $this->IdMajoration);

            if ($req->execute()) {
              return array('succes' => '1');
            } else {
              //var_dump($req->errorInfo());
              return array('error' => 'erreur requete');
            }
        } else {
            return array('error' => 'course n\'existe pas');
        }
    } else {
        return array('error' => 'manque param');
    }
  }

  public function UpdateChauffeur($Id){
    if (!empty($this->IdChauffeur)) {
        $req = $this->Bdd->prepare("SELECT Id FROM course WHERE Id = :Idcourse");
        $req->bindParam(':Idcourse', $Id);
        $req->execute();

        if ($req->fetch()) {
            $req = $this->Bdd->prepare("
                UPDATE course SET 
                IdChauffeur = :IdChauffeur
                WHERE Id = :Idcourse
            ");

            // Assurez-vous d'inclure également :Idcourse dans le bindParam
            $req->bindParam(':IdChauffeur', $this->IdChauffeur);
            $req->bindParam(':Idcourse', $Id);

            if ($req->execute()) {
                return array('succes' => '1');
            } else {
                //var_dump($req->errorInfo());
                return array('error' => 'erreur requete');
            }
        } else {
            return array('error' => 'course n\'existe pas');
        }
    } else {
        return array('error' => 'manque param');
    }
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
  

}

?>