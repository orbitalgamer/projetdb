<?php 

/**
 * GetLatitude,GetLongitude,itineraire:
 * L'ensemble de ces fonctions compose les outils pour pouvoir interpreter les adresses entrées par les user.
 * En effet, ces méthodes sont en interaction avec une api "gratuit" de géocoding 
 */

class Course {
  public $Id;
  public $DateReservation;
  // public $Payee;
  public $DistanceParcourue;
  public $IdClient;
  public $IdChauffeur;
  public $IdAdresseDepart;
  public $IdAdresseFin;
  public $IdTarification;
  public $IdMajoration;


  private $Bdd;
  private $NomTable = "course";
  private  $API_KEY = "7b4c8d7743b6c61264f7955d3305fe99"; 
  public function __construct($db){
    $this->Bdd = $db; 
  }
   
      public function getLatitude($adresse){

        $adresse_array = explode(" ",$adresse);
        $adresse_return = implode("+",$adresse_array);
        $json_url = 'https://maps.open-street.com/api/geocoding/?address=';
        $json_url = $json_url . "" . implode("+",$adresse_array) . "+Belgique&sensor=false&key=". $this->API_KEY;
        $json = file_get_contents($json_url);
        $data = json_decode($json, TRUE);
        
        $latitude = $data["results"][0]["geometry"]["location"]["lat"];
        return $latitude;
    }
    public function getLongitude($adresse){

        $adresse_array = explode(" ",$adresse);
        $adresse_return = implode("+",$adresse_array);
        $json_url = 'https://maps.open-street.com/api/geocoding/?address=';
        $json_url = $json_url . "" . implode("+",$adresse_array) . "+Belgique&sensor=false&key=".  $this->API_KEY;
        $json = file_get_contents($json_url);
        $data = json_decode($json, TRUE);
       
        $longitude = $data["results"][0]["geometry"]["location"]["lng"];
        return $longitude;

        
    }
    public function itineraire($adresseIntial,$adresseFinal){
      $latitudeInitial = $this->getLatitude($adresseIntial);
      $latitudeFinal = $this->getLatitude($adresseFinal);
      $longitudeInitial = $this->getLongitude($adresseIntial);
      $longitudeFinal = $this->getLongitude($adresseFinal);
  
        $json_url="https://maps.open-street.com/api/route/?origin={$latitudeInitial},{$longitudeInitial}&destination={$latitudeFinal},{$longitudeFinal}&mode=driving&key=".$this->API_KEY;
        
        $json = file_get_contents($json_url);
        $data = json_decode($json, TRUE);
       
        $distance = $data["total_distance"];
        $time = $data["total_time"];
        $array_result = array(
          "total_distance" => $distance,
          "total_time" => $time,
          "Latitude_Adresse_Initial" => $latitudeInitial,
          "Latitude_Adresse_Final"=> $latitudeFinal,
          "Longitude_Adresse_Initial" => $longitudeInitial,
          "Longitude_Adresse_Final" => $longitudeFinal
        ); //comprend la distance,le temps de parcoure ,et les latitudes/longitudes des deux adresses 
       
        return $array_result;
    }


  public function creation(){

     $query = "INSERT INTO $this->NomTable (
       Id,
       DateReservation,
      
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
  
  public function selection(){
    $query = "SELECT DateReservation,DistanceParcourue,IdClient,IdChauffeur,IdAdresseDepart,IdAdresseFin,IdTarification,IdMajoration FROM $this->NomTable WHERE Id='$this->Id'"; 
    $rq = $this->Bdd->prepare($query);
    $rq->execute();
    $rep=$rq->fetch(PDO::FETCH_ASSOC);
    echo json_decode($rep);


   } 
}



?>