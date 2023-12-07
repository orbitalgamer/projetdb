
<?php 

require_once "bdd.php";
include_once "course.php";
include_once "personne.php";
require_once "adresse.php";
include_once "info_adresse.php";
    /**
     * Documentation :  
    * - commanderCourse($Client,$db):
    * Dans cette fonction , nous allons permettre à un user de commander une course.
    * Le fonctionnement est de créer une course ($CourseToReturn) en lui associant l'Id du Client ($Client) qui commande la course
    * -...Init = adresse de depart de la course;
    * -...Final = adresse d'arrivé de la course; 
    * 
   */
   
   //condition qui permet de renvoyer vers la page html correspondant à la commande d'un taxi
   if ($_SERVER["REQUEST_METHOD"] == "POST") { 
      header("Location: selectionCourse.html");
   }
   // calcul des informations des adresses introduites par l'utilisateur;
   function formaterAdresse($adresse) {
      // Supprimer les caractères non autorisés
      $adresse = preg_replace('/[^0-9A-Za-z\s\-\',.]+/', '', $adresse);
      // Remplacer les espaces par des "+"
      $adresse = str_replace(' ', '+', $adresse);
      return $adresse;
  }

  $adresseInitial_Input = $_POST["AdresseInitial"];
  $adresseFinal_Input = $_POST["AdresseFinal"];
  
   
   //Creation de ma course
   $CourseToReturn = new Course($base); 
   $array_distance_time_latitude_longitude = array() ;
   $array_distance_time_latitude_longitude = $CourseToReturn->itineraire($adresseInitial_Input,$adresseFinal_Input); 
   
//   $array_distance_time_latitude_longitude = array(
//   "total_distance" => 47154.8,
//   "total_time" => 2359.8,
//   "Latitude_Adresse_Initial" => 50.4024632,
//   "Latitude_Adresse_Final"=>50.6107232,
//   "Longitude_Adresse_Initial" =>3.890471,
//   "Longitude_Adresse_Final" => 3.662738,
//   );

   // $AdresseInitialString = explode(" ","Rue Croisette 85 Mons");
   // $AdresseFinalString = explode(" ","Rue Albert 3 Momignies");
  
   
   $infosAdresse_array_initial = InfosAdresse($adresseInitial_Input,$base);
   $infosAdresse_array_final = InfosAdresse($adresseFinal_Input,$base);
    

   $AdresseInitial = new adresse($base);
   $AdresseFinal = new adresse($base);
   
   
   $AdresseInitial->Rue =  $infosAdresse_array_initial['Rue'];
   $AdresseFinal->Rue =  $infosAdresse_array_final['Rue'];
   
   $AdresseInitial->Numero =   $infosAdresse_array_initial['Numero'];
   $AdresseFinal->Numero =  $infosAdresse_array_final['Numero'];

   $AdresseInitial->Ville =   $infosAdresse_array_initial['Ville'];
   $AdresseFinal->Ville =  $infosAdresse_array_final['Ville'];
  

   $AdresseInitial->latitude = $array_distance_time_latitude_longitude["Latitude_Adresse_Initial"];
   $AdresseFinal->latitude = $array_distance_time_latitude_longitude["Latitude_Adresse_Final"];
   $AdresseInitial->longitude = $array_distance_time_latitude_longitude["Longitude_Adresse_Initial"];
   $AdresseFinal->longitude = $array_distance_time_latitude_longitude["Longitude_Adresse_Final"] ;
   
   $AdresseInitial->creation();
   $AdresseFinal->creation();
  
   $array_data_initial = array();
   $array_data_initial = $AdresseInitial->selection();
   $array_data_final = array();
   $array_data_final = $AdresseFinal->selection();
   print_r($array_data_initial);
 
   // Initialisation de toutes ces caractéristiques
   $Date_Heure_actuelle = new DateTime();
   $CourseToReturn->DateReservation = $Date_Heure_actuelle->format("Y-m-d H:i:s");
   // $CourseToReturn->Payee = 0;
   $CourseToReturn->IdAdresseDepart = $array_data_initial["Id"];
   $CourseToReturn->IdAdresseFin= $array_data_final["Id"];
   $CourseToReturn->DistanceParcourue = $array_distance_time_latitude_longitude["total_distance"];
   $CourseToReturn->IdClient = 5; //L'information provient de l'objet client se trouvant en parametre qui est le user qui commande la course;
   $CourseToReturn->IdChauffeur =0;
   $CourseToReturn->IdTarification =7;
   $CourseToReturn->IdMajoration = 2;
   $CourseToReturn->creation();//Fonction qui fait la requete SQL (INSERT INTO ...) permettant de créer l'objet $CourseToReturn;
   
?>