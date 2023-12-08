<?php

class Bdd{

public function getBdd(){
    try
    { //se connecte en root pour récuper mdo
    $Bdd = new PDO('mysql:host=localhost;dbname=taxeasy', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
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
