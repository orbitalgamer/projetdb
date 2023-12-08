<?php 


/**
 * GetLatitude,GetLongitude,itineraire:
 * L'ensemble de ces fonctions compose les outils pour pouvoir interpreter les adresses entrées par les user.
 * En effet, ces méthodes sont en interaction avec une api "gratuit" de géocoding 
 */

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


  
  private  $API_KEY = "7b4c8d7743b6c61264f7955d3305fe99"; 
 
   
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
  
  public function selection(){
    $query = "SELECT DateReservation,DistanceParcourue,IdClient,IdChauffeur,IdAdresseDepart,IdAdresseFin,IdTarification,IdMajoration FROM $this->NomTable WHERE Id='$this->Id'"; 
    $rq = $this->Bdd->prepare($query);
    $rq->execute();
    $rep=$rq->fetch(PDO::FETCH_ASSOC);
    echo json_decode($rep);


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
                                             IF(paye.IdEtat = (SELECT Id FROM etat WHERE Nom='Termine') AND lien.IdEtat != (SELECT Id FROM etat WHERE Nom='Annule par chauffeur'), 1, 0) as 'Inpaye'
                                    FROM course
                                    INNER JOIN personne chuffeur on course.IdChauffeur = chuffeur.Id
                                    INNER JOIN personne client on course.IdClient = client.Id
                                    LEFT JOIN (SELECT * FROM liencourseetat WHERE IdEtat < (SELECT Id FROM etat WHERE Nom='Termine') ORDER BY IdEtat DESC) lien on course.Id = lien.IdCourse
                                    LEFT JOIN (SELECT * FROM liencourseetat WHERE IdEtat = (SELECT Id FROM etat WHERE Nom='Termine')) paye on course.Id = paye.IdCourse
                                    INNER JOIN etat on lien.IdEtat = etat.Id
                                    WHERE lien.IdEtat > (SELECT Id FROM etat WHERE Nom='En cours')
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
                                             
                                             IF(paye.IdEtat = (SELECT Id FROM etat WHERE Nom='Termine') AND lien.IdEtat != (SELECT Id FROM etat WHERE Nom='Annule par chauffeur'), 1, 0) as 'Inpaye',
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
                                    LEFT JOIN (SELECT * FROM liencourseetat WHERE IdEtat < (SELECT Id FROM etat WHERE Nom='Termine') ORDER BY IdEtat DESC) lien on course.Id = lien.IdCourse
                                    LEFT JOIN (SELECT * FROM liencourseetat WHERE IdEtat = (SELECT Id FROM etat WHERE Nom='Termine')) paye on course.Id = paye.IdCourse
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
                        //recherche en dynamique l'id terminé qui est dernier
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