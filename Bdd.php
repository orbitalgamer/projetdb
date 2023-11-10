<?php

try{ //se connecte en root pour récuper mdo
    $Bdd = new PDO('mysql:host=localhost;dbname=taxeasy', 'root', '');
}
    catch (exception $e){
    die ('erreur : ' . $e->getMessage());
}
/**
 * création de l'objet permetant de se connecter à la DB
 */
?>
