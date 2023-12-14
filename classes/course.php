<?php 


/**
 * GetLatitude,GetLongitude,itineraire:
 * L'ensemble de ces fonctions compose les outils pour pouvoir interpreter les adresses entrées par les user.
 * En effet, ces méthodes sont en interaction avec une api "gratuit" de géocoding 
 */

include_once 'bdd.php';
include_once 'adresse.php';



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
  private $NomTableLien = "liencourseetat";

  
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


  

  public function __construct(){
      $db = new Bdd();
    $this->Bdd = $db->getBdd();
  }

  public function creationlien(){
    $query = "INSERT INTO $this->NomTableLien (
      Id,
      Date,
      IdCourse,
      IdEtat)
      VALUES 
      (NULL,
      :Date,
      :IdCourse,
      :IdEtat
      )";
     $rq = $this->Bdd->prepare($query);

     $rq->bindParam(':Date', $this->Date);
     $rq->bindParam(':IdCourse', $this->IdCourse);
     $rq->bindParam(':IdEtat', $this->IdEtat);

     if ($rq->execute()) {
       $rep=$rq->fetch(PDO::FETCH_ASSOC);
       echo "Marché";
       echo json_decode($rep);
    }
    else {
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

public function AbandonChauffeur($Id){
  if (!empty($this->IdChauffeur)) {
      $req = $this->Bdd->prepare("SELECT Id FROM course WHERE Id = :Idcourse");
      $req->bindParam(':Idcourse', $Id);
      $req->execute();

      if ($req->fetch()) {
          $req = $this->Bdd->prepare("
              UPDATE course SET 
              IdChauffeur = 13
              WHERE Id = :Idcourse
              
              
          ");

          // Assurez-vous d'inclure également :Idcourse dans le bindParam
         
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
                                             IF(paye.IdEtat = (SELECT Id FROM etat WHERE Nom='Paye') AND lien.IdEtat != (SELECT Id FROM etat WHERE Nom='Annule par chauffeur'), 1, 0) as 'Inpaye'
                                    FROM course
                                    INNER JOIN personne chuffeur on course.IdChauffeur = chuffeur.Id
                                    INNER JOIN personne client on course.IdClient = client.Id
                                    LEFT JOIN (SELECT * FROM liencourseetat WHERE IdEtat < (SELECT Id FROM etat WHERE Nom='Paye') ORDER BY IdEtat DESC) lien on course.Id = lien.IdCourse
                                    LEFT JOIN (SELECT * FROM liencourseetat WHERE IdEtat = (SELECT Id FROM etat WHERE Nom='Paye')) paye on course.Id = paye.IdCourse
                                    INNER JOIN etat on lien.IdEtat = etat.Id
                                    WHERE lien.IdEtat > (SELECT Id FROM etat WHERE Nom='En cours')
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
                                             
                                             IF(paye.IdEtat = (SELECT Id FROM etat WHERE Nom='Paye') AND lien.IdEtat != (SELECT Id FROM etat WHERE Nom='Annule par chauffeur'), 1, 0) as 'Inpaye',
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
                                             tarification.PrixAuKilometre as 'Tarif',
                                             course.DistanceParcourue
            
                                             
                                             
                                    FROM course
                                    INNER JOIN personne chuffeur on course.IdChauffeur = chuffeur.Id
                                    INNER JOIN personne client on course.IdClient = client.Id
                                    LEFT JOIN (SELECT * FROM liencourseetat WHERE IdEtat < (SELECT Id FROM etat WHERE Nom='Paye') ORDER BY IdEtat DESC) lien on course.Id = lien.IdCourse
                                    LEFT JOIN (SELECT * FROM liencourseetat WHERE IdEtat = (SELECT Id FROM etat WHERE Nom='Paye')) paye on course.Id = paye.IdCourse
                                    INNER JOIN etat on lien.IdEtat = etat.Id
                                        
                                    INNER JOIN adresse depart on depart.Id = course.IdAdresseDepart
                                    INNER JOIN localite localiteDepart on localiteDepart.Ville = depart.Vile
                                        
                                    INNER JOIN adresse fin on fin.Id = course.IdAdresseDepart
                                    INNER JOIN localite localiteFin on localiteFin.Ville = fin.Vile
                                    
                                    INNER JOIN tarification on course.IdTarification = tarification.Id
                                    
                                    WHERE course.Id = :Id
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

    public function GetEncoure(){ //sélectionne toutes les courses en cours
      $req=$this->Bdd->query('SELECT course.Id, 
                                        chauffeur.Nom as "NomChauffeur", 
                                        client.Nom as "NomClient", 
                                        etat.Nom as "NomEtat",
                                        course.DateReservation
                                FROM course
                                
                                INNER JOIN (SELECT * FROM liencourseetat WHERE Id IN (SELECT MAX(Id) as "Id" FROM liencourseetat GROUP BY IdCourse)) lienmax on course.Id = lienmax.IdCourse
                                INNER JOIN personne chauffeur on course.IdChauffeur = chauffeur.Id
                                INNER JOIN personne client on course.IdChauffeur = client.Id
                                INNER JOIN tarification on course.IdTarification = tarification.Id
                                INNER JOIN etat on lienmax.IdEtat = etat.Id
                                WHERE lienmax.IdEtat BETWEEN (SELECT Id FROM etat WHERE Nom ="Chauffeur en route") AND (SELECT Id FROM etat WHERE Nom ="En cours")
                                GROUP BY tarification.PlaqueVehicule');
      $retour = array();
      while($rep = $req->fetch()){
          array_push($retour, $rep);
      }
      return $retour;
    }

    public function GetSuivante(){ //sélectionne toutes les courses en cours
        $req=$this->Bdd->query('SELECT course.Id, 
                                        chauffeur.Nom as "NomChauffeur", 
                                        client.Nom as "NomClient", 
                                        
                                        course.DateReservation
                                FROM course
                                
                                
                                INNER JOIN personne chauffeur on course.IdChauffeur = chauffeur.Id
                                INNER JOIN personne client on course.IdChauffeur = client.Id
                                INNER JOIN tarification on course.IdTarification = tarification.Id
                                
                                WHERE DateReservation > CURRENT_TIMESTAMP
                                GROUP BY tarification.PlaqueVehicule');
        $retour = array();
        while($rep = $req->fetch()){
            array_push($retour, $rep);
        }
        return $retour;
    }
    public function Verification_disponibilite($Current_Course)
    {
    
   //Requete pour afficher toutes les courses non prises par un chauffeur où on considère que idChauffeur = 0  est une course non-prise
   $Current_Course_DateTime = $Current_Course->DateReservation;// $Current_Course["DateReservation"];
   $Current_Course_IdAdresseDepart = $Current_Course->IdAdresseDepart;//$Current_Course["IdAdresseDepart"] ;
   $Current_Course_IdAdresseFin = $Current_Course->IdAdresseFin;//$Current_Course["IdAdresseFin"];
 
   $Current_Course_TimeParcoure =  $Current_Course->duree;
   $Current_Course_DateTime  = new DateTime($Current_Course_DateTime);
   $Current_Course_DateTime_Without_ExtraTime = $Current_Course_DateTime->getTimestamp(); //On garde l'horaire sans le temps de parcour pour verifier avec course previous
   $Current_extraTime_heure = $Current_Course_TimeParcoure/3600;
   $Current_extraTime_heure_int = intval($Current_extraTime_heure);
   $Current_extraTime_minutes = floor(($Current_extraTime_heure - $Current_extraTime_heure_int)*60);
   
   $Current_Course_DateTime->add(new DateInterval('PT'.$Current_extraTime_minutes.'M'));
   $Current_Course_DateTime->add(new DateInterval('PT'.$Current_extraTime_heure_int.'H'));
   $Current_time_date_second  = $Current_Course_DateTime->getTimestamp();
  
   
   /**
    * 
    * 
    * if(pas de course le jour)
    * else ( 
    * 2er condition :  temps parcour entre la fin de la précédent course et le début de la prochaine ne permet d'arriver à temps :7
    *   (TimeEndPreviousCourse - TimeStartNextCours) < TimeTravel entre les deux 
    * 3er condition (lié à la 2eme) : la fin de la NextCourse ne soit pas équivalent au début d'une autre et que  (TimeEndPreviousCourse - TimeStartNextCours) < TimeTravel entre les deux 
    *   )
    * 
    * à faire condition 3
    */
   $query = "SELECT DISTINCT duree,DateReservation,idAdresseFin,idAdresseDepart FROM $this->NomTable WHERE idChauffeur = '$this->IdChauffeur' AND duree !=0"; #IdChaufeur
   $rq = $this->Bdd->prepare($query);
  
   $rq->execute();
   $array_duration_course =  $rq->fetchAll(PDO::FETCH_ASSOC);
   print_r($array_duration_course);
  
   $Diff_Time_array_Previous = array();
   $Diff_Time_array_Next = array();
   for($i=0; $i < count($array_duration_course);$i++)
   {
    // Course précédent 
     $extraTime = $array_duration_course[$i]["duree"];
     $date = $array_duration_course[$i]["DateReservation"];
     $IdAdresseDepart = $array_duration_course[$i]["idAdresseDepart"];
     $IdAdresseFin = $array_duration_course[$i]["idAdresseFin"];
     $date = new DateTime($date); 
 
   
     $extraTime_heure = $extraTime/3600;
     $extraTime_heure_int = intval($extraTime_heure);
     $extraTime_minutes = floor(($extraTime_heure - $extraTime_heure_int)*60);
     
     $time_date_Without_ExtraTime = $date->getTimestamp();
     $date->add(new DateInterval('PT'.$extraTime_minutes.'M'));
     $date->add(new DateInterval('PT'.$extraTime_heure_int.'H'));
     $time_date_second  = $date->getTimestamp();
     $Diff_Time_Previous =$Current_Course_DateTime_Without_ExtraTime -  $time_date_second ; //$Current_..._ExtraTime en seconde
   
  
     if($Diff_Time_Previous > 0 )
     {
      array_push($Diff_Time_array_Previous,$Diff_Time_Previous);
     }
    
     //Cou$rse Suivante
     $Diff_Time_Next = $Current_time_date_second - $time_date_Without_ExtraTime;
    
     if($Diff_Time_Next < 0 )
     {
      array_push($Diff_Time_array_Next,$Diff_Time_Next);
     }
   }   
  
 
   echo "<br>";
 
 print_r($Diff_Time_array_Previous);
 echo "<br>";
 print_r($Diff_Time_array_Next);
 echo "<br>";
 

 
 if(!empty($Diff_Time_array_Previous))  
 {
   $min_Diff_Time_Previous = min($Diff_Time_array_Previous);
  echo("Bjrprevious");
 }
 
 if(!empty($Diff_Time_array_Next))
 {
    
   $min_Diff_Time_Next =  max($Diff_Time_array_Next);
   echo("Bjrnext");
      
 }
 
 
 $min_Diff_Time_Next = NULL;
 $min_Diff_Time_Previous = NULL;
 
 
 
 
   // print_r($Diff_Time_array_Previous);
   // echo "<br>";  
   // print_r($Diff_Time_array_Next);
   if($min_Diff_Time_Previous > 0 OR !isset($min_Diff_Time_Previous))
   {
     /*** ID_Current_Adresse_Fin -> id_AdresseDebut */
     // echo $extraTime;
     // echo "<br>";
     // echo 'minutes :' . $extraTime_minutes;
     // echo " " ;
     // echo 'heure:'. $extraTime_heure_int;
     // echo "<br>"; 
     
     $previous_course_adresse = new adresse($this->Bdd);
     $next_course_adresse = new adresse($this->Bdd);
 
     $previous_course_adresse->Id = $Current_Course_IdAdresseFin;
     $next_course_adresse->Id = $IdAdresseDepart;
     $previous_course_adresse_array = $previous_course_adresse->selection();
     $next_course_adresse_array = $next_course_adresse->selection();
    var_dump($previous_course_adresse_array);
    var_dump($min_Diff_Time_Previous);
     $previous_course_adresse_string = $previous_course_adresse_array["Numero"] . " " . $previous_course_adresse_array["Rue"] . " " . $previous_course_adresse_array["Vile"];
     $next_course_adresse_string = $next_course_adresse_array["Numero"] . " " . $next_course_adresse_array["Rue"] . " " . $next_course_adresse_array["Vile"];
         
     // $Next_Course_Array = $this->itineraire($previous_course_adresse_string,$next_course_adresse_string);
     $Next_Course_Array = [
       "time"=> 1735.1,
     ];     
    
     $time_btw_course_previous = $Next_Course_Array["time"];
    
     if($min_Diff_Time_Previous  < $time_btw_course_previous OR !isset($min_Diff_Time_Previous)){
      $reponse_boolean_Previous = TRUE;
      echo "<br>";
      echo "Possible par rapport à la course precedent";
       
     }
     else
     {
      

       echo "Pas possible par rapport à la course precedent";
       echo "<br>";
       $reponse_boolean_Previous = FALSE; 
     }
 
   }
   if($min_Diff_Time_Next < 0 OR !isset($min_Diff_Time_Next))
   {
     /** Dans c'est le contraire de la condition du dessus , je regarde si le temps de parcourue 
      * entre la fin de ma prochaine course et de la course d'après correspond 
      * idAdresseFin -> id_Current_CourseDebut
      * 
      * */
     $previous_course_adresse = new adresse($this->Bdd);
     $next_course_adresse = new adresse($this->Bdd);
 
 
 
     $previous_course_adresse->Id = $IdAdresseFin;
     $next_course_adresse->Id = $Current_Course_IdAdresseDepart;
     $previous_course_adresse_array = $previous_course_adresse->selection();
     $next_course_adresse_array = $next_course_adresse->selection();
  
   
     $previous_course_adresse_string = $previous_course_adresse_array["Numero"] . " " . $previous_course_adresse_array["Rue"] . " " . $previous_course_adresse_array["Vile"];
     $next_course_adresse_string = $next_course_adresse_array["Numero"] . " " . $next_course_adresse_array["Rue"] . " " . $next_course_adresse_array["Vile"];
      
     
     // $Next_Course_Array = $this->itineraire($previous_course_adresse_string,$next_course_adresse_string);
     $Next_Course_Array = [
       "time"=>2922.8,
     ];
     // print_r($Next_Course_Array);
     
     $time_btw_course_next = $Next_Course_Array["time"];
     var_dump($min_Diff_Time_Next);

     if(abs($min_Diff_Time_Next) > $time_btw_course_next OR !isset($min_Diff_Time_Next)){
        echo "COurse suivant possible";
        echo "<br>";
       $reponse_boolean_Next = TRUE; 
 
     }
     else
     {
       $reponse_boolean_Next = FALSE;  
       echo "<br>";
       echo "Course suivant impossible";
     }
 
 
   }
   if($reponse_boolean_Previous == TRUE && $reponse_boolean_Next == TRUE)
   {
     return TRUE;
   }
   else
   {
     return FALSE;
   }
 

}

public function loadcourse($Idcourse){
    $req = $this->Bdd->prepare("SELECT * FROM course WHERE Id = :Id");
    $req->bindParam(':Id', $Idcourse);
    $req ->execute();
    $rep = $req->fetch();
    if(!empty($req)){
      
      $this->DateReservation = $rep['DateReservation'];
      $this -> Id = $rep['Id'];
      $this -> DistanceParcourue = $rep['DistanceParcourue'];
      $this -> IdClient = $rep['IdClient'];
      $this -> IdChauffeur = $rep['IdChauffeur'];
      $this -> IdAdresseDepart = $rep['IdAdresseDepart'];
      $this -> IdAdresseFin = $rep['IdAdresseFin'];
      $this -> IdTarification = $rep['IdTarification'];
      $this -> IdMajoration = $rep['IdMajoration'];
      $this -> Date = $rep['DateReservation'];
      $this -> duree = $rep['duree'];
    

    
    }
    

  
}
}
?>