<?php
include_once "bdd.php";
include_once "localite.php";






class adresse{

    public $Id;
    public $Numero;
    public $Rue;
    public $Ville;
    public $CP;

    public $NomAdresse;
    public $latitude;
    public $longitude; 
    private $Bdd;
    private $NomTable = "adresse";
    
 

    public function __construct(){

        $db = new Bdd();
        $this->Bdd = $db->getBdd();
        
    }




    public function creation(){
        $query = "SELECT * FROM $this->NomTable WHERE Rue=:Rue AND Numero=:Numero AND Vile=:Ville";
        $rq = $this->Bdd->prepare($query);
        $rq->bindParam(':Rue', $this->Rue);
        $rq->bindParam(':Numero', $this->Numero);
        $rq->bindParam(':Ville', $this->Ville);
        $rq->execute(); 
        $rep=$rq->fetch(PDO::FETCH_ASSOC);

        if(!empty($rep)){
            return array("error"=>1);
        }
        /**Le principe est de verifier que les latitudes et longitudes rentrés n'existe pas dans le bdd pour économiser des réquetes APIs */

        $loc = new localite($this->Bdd);
        $loc->Ville = $this->Ville;
        if(empty($loc->selection())){
            $loc->CodePostal=$this->CP;
            $loc->creation();
        }


        if(empty($rep)) {
            $query = "INSERT INTO $this->NomTable (
                
                Numero,
                Rue,
                Vile,
                latitude,
                longitude)
                VALUES
                (
                :Numero,
                :Rue,
                :Ville,
                :latitude,
                :longitude)";
                
            $rq = $this->Bdd->prepare($query);
            $rq->bindParam(':Numero',$this->Numero);
            $rq->bindParam(':Rue',$this->Rue);
            $rq->bindParam(':Ville',$this->Ville);
            $rq->bindParam(':latitude',$this->latitude);
            $rq->bindParam(':longitude',$this->longitude);
            
        try{

            $rq->execute();
            $rep = $rq->fetch(PDO::FETCH_ASSOC);

        }
        catch(PDOException $e){
            $e = explode(" ",$e);
            if($e[1]== "SQLSTATE[23000]:"){
                $newLocalite = new localite($this->Bdd);
                $newLocalite->Ville = $this->Ville;
                $newLocalite->CodePostal = $this->CP;
                $newLocalite->creation();
                $rq->execute();
                $rep = $rq->fetch(PDO::FETCH_ASSOC);
                echo json_decode($rep);
            }
            else
            {
                echo "error";
            }
        }
    }
    else
    {
        $array_result = $this->selection();
        return $array_result;
    }


}
public function selection(){
    $query = "SELECT Id,Numero,Rue,Vile,NomAdresse,latitude,longitude FROM $this->NomTable WHERE Rue='$this->Rue' OR Id='$this->Id'";
    $rq = $this->Bdd->prepare($query);
    
    if($rq->execute()){
      $rep=$rq->fetch(PDO::FETCH_ASSOC);
     
      
      return $rep;
   
    }
    else
    {
        echo "pas marché";
    }
    
    }

    public function GetAdresse(){
        $req = $this->Bdd->prepare("SELECT Id FROM adresse WHERE Rue=:Rue AND Numero=:Numero AND Vile =:Vile");
        $req->bindParam(':Rue', $this->Rue);
        $req->bindParam(':Numero', $this->Numero);
        $req->bindParam(':Vile', $this->Ville);
        $req->execute();

        return $req->fetch();
    }

    public function GetInfo($Id){
        $req = $this->Bdd->prepare("SELECT adresse.*, localite.CodePostal FROM adresse INNER JOIN localite on adresse.Vile = localite.Ville WHERE adresse.Id = :Id");
        $req->bindParam(':Id', $Id);
        $req->execute();
        return $req->fetch();

    }
   
}


?>