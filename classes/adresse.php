<?php
include_once "bdd.php";
include_once "localite.php";






class adresse{

    public $Id;
    public $Numero;
    public $Rue;
    public $Ville;
    public $NomAdresse;
    public $latitude;
    public $longitude; 
    private $Bdd;
    private $NomTable = "adresse";
    
 

    public function __construct($db){  

        $db = new Bdd();
        $this->Bdd = $db->getBdd();
        
    }




    public function creation(){
        $query = "SELECT * FROM $this->NomTable WHERE latitude BETWEEN $this->latitude - 0.00000001 AND $this->latitude + 0.00000001 AND longitude BETWEEN $this->longitude - 0.00000001 AND $this->longitude + 0.00000001";
        $rq = $this->Bdd->prepare($query);
        $rq->execute(); 
        $rep=$rq->fetch(PDO::FETCH_ASSOC);
        print_r($rep);
        /**Le principe est de verifier que les latitudes et longitudes rentrés n'existe pas dans le bdd pour économiser des réquetes APIs */
    
        if($rep==null) {
            $query = "INSERT INTO $this->NomTable (
                Id,
                Numero,
                Rue,
                Ville,
                NomAdresse,
                latitude,
                longitude)
                VALUES
                (NULL,
                :Numero,
                :Rue,
                :Ville,
                :NomAdresse,
                :latitude,
                :longitude)";
                
            $rq = $this->Bdd->prepare($query);
            $rq->bindParam(':Numero',$this->Numero);
            $rq->bindParam(':Rue',$this->Rue);
            $rq->bindParam(':Ville',$this->Ville);
            $rq->bindParam(':NomAdresse',$this->NomAdresse);
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
    $query = "SELECT Id,Numero,Rue,Ville,NomAdresse,latitude,longitude FROM $this->NomTable WHERE Rue='$this->Rue'"; 
    $rq = $this->Bdd->prepare($query);
    if($rq->execute()){
      $rep=$rq->fetch(PDO::FETCH_ASSOC);
      echo "la";
      
      return $rep;
   
    }
    else
    {
        echo "pas marché";
    }
    
    }

   
}


?>