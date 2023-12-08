<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'blue': '#1e3a8a',
                        'black': '#030712',
                        'green': '#84cc16',
                        'white': '#FAF9F6'
                    },
                    height: {
                        '96': '64rem'
                    },
                    boxShadow: {
                        '3xl': "0px 2px 4px rgba(0, 0, 0, 0.18) "
                    }
                }
            }
        }
    </script>
    <script type="module" src="index.js"></script>
   
</head>

<body>

    <nav class="bg-black">
        <div class="mx-auto max-w-7xl max-h-7xl px-2 sm:px-6 lg:px-8">
            <div class="flex space-x-4">

                <span class="text-gray-300 text-2xl font-weight">TAXEASY</span>
            </div>

        </div>
    </nav>
    <div id="mainContainer" class="flex w-screen h-screen justify-center  bg-white gap-4">
     
       
    
   
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
   


  
  $adresseInitial_Input = $_POST["AdresseInitial"];
  $adresseFinal_Input = $_POST["AdresseFinal"];



  
   
//    // Creation de ma course
//    $CourseToReturn = new Course($base); 
//    $array_distance_time_latitude_longitude = array() ;
//    $array_distance_time_latitude_longitude = $CourseToReturn->itineraire($adresseInitial_Input,$adresseFinal_Input); 
   
// //   $array_distance_time_latitude_longitude = array(
// //   "total_distance" => 47154.8,
// //   "total_time" => 2359.8,
// //   "Latitude_Adresse_Initial" => 50.4024632,
// //   "Latitude_Adresse_Final"=>50.6107232,
// //   "Longitude_Adresse_Initial" =>3.890471,
// //   "Longitude_Adresse_Final" => 3.662738,
// //   );

//    // $AdresseInitialString = explode(" ","Rue Croisette 85 Mons");
//    // $AdresseFinalString = explode(" ","Rue Albert 3 Momignies");
  
   
//    $infosAdresse_array_initial = InfosAdresse($adresseInitial_Input,$base);
//    $infosAdresse_array_final = InfosAdresse($adresseFinal_Input,$base);
    

//    $AdresseInitial = new adresse($base);
//    $AdresseFinal = new adresse($base);
   
   
//    $AdresseInitial->Rue =  $infosAdresse_array_initial['Rue'];
//    $AdresseFinal->Rue =  $infosAdresse_array_final['Rue'];
   
//    $AdresseInitial->Numero =   $infosAdresse_array_initial['Numero'];
//    $AdresseFinal->Numero =  $infosAdresse_array_final['Numero'];

//    $AdresseInitial->Ville =   $infosAdresse_array_initial['Ville'];
//    $AdresseFinal->Ville =  $infosAdresse_array_final['Ville'];
  

//    $AdresseInitial->latitude = $array_distance_time_latitude_longitude["Latitude_Adresse_Initial"];
//    $AdresseFinal->latitude = $array_distance_time_latitude_longitude["Latitude_Adresse_Final"];
//    $AdresseInitial->longitude = $array_distance_time_latitude_longitude["Longitude_Adresse_Initial"];
//    $AdresseFinal->longitude = $array_distance_time_latitude_longitude["Longitude_Adresse_Final"] ;
   
//    $AdresseInitial->creation();
//    $AdresseFinal->creation();
  
//    $array_data_initial = array();
//    $array_data_initial = $AdresseInitial->selection();
//    $array_data_final = array();
//    $array_data_final = $AdresseFinal->selection();
//    print_r($array_data_initial);
 
//    // Initialisation de toutes ces caractéristiques
//    $Date_Heure_actuelle = new DateTime();
//    $CourseToReturn->DateReservation = $Date_Heure_actuelle->format("Y-m-d H:i:s");
//    // $CourseToReturn->Payee = 0;
//    $CourseToReturn->IdAdresseDepart = $array_data_initial["Id"];
//    $CourseToReturn->IdAdresseFin= $array_data_final["Id"];
//    $CourseToReturn->DistanceParcourue = $array_distance_time_latitude_longitude["total_distance"];
//    $CourseToReturn->IdClient = 5; //L'information provient de l'objet client se trouvant en parametre qui est le user qui commande la course;
//    $CourseToReturn->IdChauffeur =0;
//    $CourseToReturn->IdTarification =7;
//    $CourseToReturn->IdMajoration = 2;
//    $CourseToReturn->creation();//Fonction qui fait la requete SQL (INSERT INTO ...) permettant de créer l'objet $CourseToReturn;
   
?>
    <?php
     $Date_Heure_actuelle = new DateTime(); 
     $Date_Heure_actuelle = $Date_Heure_actuelle->format("Y-m-d H:i:s");
    echo 
    "<div class='flex flex-col gap-16   w-1/2 h-3/4 border border-5 self-center indent'>
    <h1 class='text-5xl text-center'> Confirmation de votre course </h1>
    <form class=' w-3/4 h-96  flex flex-col' action='selectionCourse.php'
    method='POST'>
    <label  for='AdresseInitial' class='text-lg underline underline-offset-1'>Lieu du rendez-vous :</label>
    <input type='text' class='border border-2 h-24 shadow-inner rounded-lg bg-white duration-1000'
        value='$adresseInitial_Input'   name='AdresseInitial'>  
        <label  for='AdresseInitial' class='text-lg underline underline-offset-1'>Destination :</label>
    <input type='text' class='border border-2 h-24 shadow-inner rounded-lg bg-white'
        value='$adresseFinal_Input' >
    <label for='dateReservation' class='text-lg underline underline-offset-1'>Date/Heure de réservation</label>
    <input type='datetime' class='border border-2 h-24 shadow-inner rounded-lg bg-white'
        value='$Date_Heure_actuelle' name='dateReservation'>
    <input type='submit'
        class='border border-2 w-36  bg-black text-white rounded-full hover:drop-shadow-xl duration-100'
        value='Confirmer'>
</form>
    
    
    
    
    </div>"
    ?>
   
</div>

</body>

</html>