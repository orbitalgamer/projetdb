<?php 
include_once 'bdd.php';
class localite {
    public $Ville;
    public $CodePostal;
    private $Bdd;
    private $NomTable = "localite";

    public function __construct($db){ 

        $this->Bdd = $db; 
        
    }

    public function creation(){
        $query = "INSERT INTO $this->NomTable (
          Ville,
          CodePostal
          )
          VALUES
          (
          '$this->Ville',
          '$this->CodePostal'
          )";
       $rq = $this->Bdd->prepare($query);
       $rq->execute();
       $rep = $rq->fetch();
       echo json_encode($rep);
    }



    public function selection(){
        $query = "SELECT Ville,CodePostal FROM $this->NomTable WHERE Ville='$this->Ville'"; 
        $rq = $this->Bdd->prepare($query);
        $rq->execute();
        $rep=$rq->fetch(PDO::FETCH_ASSOC);
        echo json_encode($rep);
        return $rep;
    }
}


// $localite1 = new localite($base);
// $localite1->Ville = "Bruxelles"; 
// $localite1->CodePostal = 1000;
// $localite1->creation();
?>