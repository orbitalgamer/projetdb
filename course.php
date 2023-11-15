<?php 

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

  public function __construct($db){
    $this->Bdd = $db; 
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

}

?>