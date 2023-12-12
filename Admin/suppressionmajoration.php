<?php
include_once 'navbar.php';

include_once '../classes/majoration.php';

if(!empty($_GET['Id'])){
    $majo = new Majoration();
    $majo->Delete($_GET['Id']);
    header('location: majoration.php');
}
else{
    header('location: majoration.php');
}
?>
