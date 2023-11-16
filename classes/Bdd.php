<?php

class Bdd{

public function getBdd(){
    try
    { //se connecte en root pour récuper mdo
    $Bdd = new PDO('mysql:host=localhost;dbname=taxeasy', 'root', '');
    return $Bdd;
    }
    catch
    (exception $e){
        die ('erreur : ' . $e->getMessage());
    }
}
/**
 * création de l'objet permetant de se connecter à la DB
 */

}
?>
