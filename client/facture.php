<?php

session_start(); //démarre session ici doit plus le faire par après

if(!empty($_SESSION['Id'])){
    if(empty($_SESSION['Nom']) || empty($_SESSION['Prenom']) || empty($_SESSION['Role'])) {
        header('location: ../deconnection.php'); //le déconnecte car forçage connection par extérieur
        echo 'essaye de rentrer dans système';
    }
    elseif ($_SESSION['Role'] != 'Client'){
        echo 'pas droit admin';
        header('location:../index.php');
    }
}
else{
    header('location: ../index.php');
}

header('Content-Type: application/pdf');

require '../classes/pdf/fpdf.php'; //pour pdf

if(empty($_GET['Id'])){ //si pas défini pour quel course
    header('location: course.php');
}
else{
    $Id = $_GET['Id'];
}

include_once '../classes/course.php';

$course = new Course();
$resultat = $course->Get($Id);
//var_dump($resultat);


$pdf = new FPDF();

// Ajouter une page au document
$pdf->AddPage();

// Ajouter du texte
$pdf->SetFont('Arial', 'B', 24);
$pdf->Cell(40, 10, utf8_decode('Facture de la course N°'.$resultat['Id']));

// Ajouter du contenu au PDF
$pdf->SetFont('Arial', '', 12);
$pdf->Ln(10); // Saut de ligne
$pdf->MultiCell(0, 10, utf8_decode('Le client nommé '.$resultat['NomClient'].' '.$resultat['PrenomClient'].' a utilisé les services de Taxeasy le '.date('d-m-y',strtotime($resultat['DateDebut'] ))));
$pdf->MultiCell(0, 10, utf8_decode('Il a demandé une course reliant '.$resultat['NumeroDepart'].' '.$resultat['RueDepart'].' à '.$resultat['CPDepart'].' '.$resultat['VileDepart'].' à '.$resultat['NumeroFin'].' '.$resultat['RueFin'].' à '.$resultat['CPFin'].' '.$resultat['VileFin'])) ;
$pdf->MultiCell(0, 10, utf8_decode('Pour réaliser ce trajet, le chauffeur a parcouru '.$resultat['DistanceParcourue']. ' km pour un tarif lors du dit service de '.$resultat['Tarif']).' euro/km.' );
$pdf->MultiCell(0, 10, utf8_decode('Le client se voit donc réclamé la somme de '.$resultat['Prix']).' euro '.utf8_decode('pour au plus tard le '.date("d-m-y",strtotime('+1 Months', strtotime($resultat['DateDebut']))))) ;
$pdf->MultiCell(0, 10, utf8_decode('Le paiement peut être effectué sur les compte suivant BEBONNUMERODECOMPTE')) ;

$pdf->MultiCell(0, 10, 'Ce fut un plaisir de travailler avec vous') ;

// Sauvegarder le PDF dans un fichier
$pdf->Output(utf8_decode('Facture de la course N°'.$resultat['Id'].'.pdf'), 'D');

?>