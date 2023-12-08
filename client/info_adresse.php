<?php 
require_once 'bdd.php';
/**
 * InfosAdresse: cette fonction a pour but d'extraire et de trier les différentes informations présentes dans les adresses rentrèes par les users.
 * A l'aide de Regex (RegularExpression) et des fonctions PHP permettant de traiter des strings, j'ai pu le faire. Peu importe la manière dont est formulée l'adresse
 * , la fonction pourra prendre détecter les adresses belges, et même si la formulation est incorrecte ou faussée , la fonction renvoie l'information à ce propos.
 * Les différentes fonctions seront explicitées dans le code.
 *
 */




function InfosAdresse($adresse,$base) {
   

    $adresse = strtolower($adresse);
    
    $adresse = preg_replace('/[^0-9A-Za-z\s\-\',.]+/', '', $adresse); //Remplacement des tirets,virgules, points etc
    
    preg_match_all('/\b\d{1,3}+\b/', $adresse, $numero); //Recherche du numéro de maison en disant que je choisi des nombres entre 1 et 3 chiffres
    
    
    $numero = implode("",$numero[0]);//transforme un array en string 
    preg_match_all('/\b\d{4}+\b/',$adresse, $codePostal); // Recherche du code Postal en disant que je choisi un nombre avec au moins 4 chiffres
    
    $codePostal = implode("",$codePostal[0]); //transforme un array en string 
    // Suppression du code Postal et du numéro de l'adresse
    $adresseSansNumero = str_replace($numero, '', $adresse); 
    
    $adresse_SansNumero_SansCodePostal = str_replace($codePostal,'',$adresseSansNumero);
    
    preg_match_all('/\brue\b(.+)/i',$adresse_SansNumero_SansCodePostal,$Rue); // Recherche la rue en supposant que le nom de la rue commence par "rue"
 
    $Rue = implode("",$Rue[0]);//transforme un array en string 
    
    $Ville = str_replace($Rue,'',$adresse_SansNumero_SansCodePostal); //je supprimer la rue du string 
    /** La suite du code prend en compte deux cas : soit la nom de la ville se trouve avant le nom de la rue et par conséquent la Ville n'apparait plus dans le string
     * $Rue; soit le nom de la ville est après la rue , ainsi je peux retrouver le nom de la Ville dans le string $Rue
     */

    if(empty($Ville) == FALSE) // cas où le nom de la ville est devant la rue 
    { 
        // requete qui permet d'identifier si le nom de la localité existe dans la bdd
        $query = "SELECT * FROM localite WHERE Ville='$Ville'";
        $rq = $base->prepare($query);
        $rq->execute();
        $rep = $rq->fetch(PDO::FETCH_ASSOC);
  
        if($rep != NULL ){
            $Ville = $rep["Ville"];
        }
        else
        {   // renvoyer une info au html comme quoi info pas bonne
            
        };
    }
    else // cas où le nom de la ville est derrière la nom de la rue
    {
     //extraite la ville de rue de $Rue[0]
     
     $Position_Ville_string = strrpos($Rue,' ');
     $Ville = substr($Rue,$Position_Ville_string+1);
     $Rue = str_replace($Ville,'',$Rue);
     $Rue =str_replace(",",'',$Rue);
       // idem
       $query = "SELECT * FROM localite WHERE Ville='$Ville'";
       $rq = $base->prepare($query);
       $rq->execute();
       $rep = $rq->fetch(PDO::FETCH_ASSOC);
    
       if($rep != NULL ){
           $Ville = $rep["Ville"];
           
       }
       else
       {   // renvoyer une info au html comme quoi info pas bonne
           
       };

    };
    return [
        'Numero' => $numero,    
        'Rue' => $Rue,
        'codePostal'=>$codePostal,
        'Ville'=>$Ville
    ];
}

// Exemple d'utilisation
$adresseEntree = "Rue du Docq 10 5140 Sombreffe";
$infosAdresse = InfosAdresse($adresseEntree,$base);
echo "<br>";
    print_r( $infosAdresse['Numero']);
    echo "<br>";
    print_r($infosAdresse['Rue']);
    echo "<br>";

    print_r($infosAdresse['codePostal']);
    echo "<br>";

    print_r($infosAdresse['Ville']);
?>