
<?php 

require_once "bdd.php";
include_once "classes/course.php";
include_once "classes/personne.php";


    /**
     * Documentation :  
    * commanderCourse($Client,$db):
    * Dans cette fonction , nous allons permettre à un user de commander une course.
    * Le fonctionnement est de créer une course ($CourseToReturn) en lui associant l'Id du Client ($Client) qui commande la course
    * 
   */


function commanderCourse($Client,$db){        

   $CourseToReturn = new Course($db); //Creation de ma course
   //Initialisation de toutes ces caractéristiques
   $CourseToReturn->DateReservation = "2002-12-15 12:54:02";
   $CourseToReturn->Payee = 0;
   $CourseToReturn->DistanceParcourue = 50.05;
   $CourseToReturn->IdClient = $Client->Id; //L'information provient de l'objet client se trouvant en parametre qui est le user qui commande la course;
   $CourseToReturn->IdChauffeur =2;
   $CourseToReturn->IdAdresseDepart = 3;
   $CourseToReturn->IdAdresseFin = 4;
   $CourseToReturn->IdTarification =5;
   $CourseToReturn->IdMajoration = 9;
   $CourseToReturn->creation();//Fonction qui fait la requete SQL (INSERT INTO ...) permettant de créer l'objet $CourseToReturn 
   
}


?>