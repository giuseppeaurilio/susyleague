<?php
 include_once("../DB/calcolarisultato.php");

$idpartita=$_GET['idpartita'];
$idcasa=$_GET['idcasa'];
$idospite=$_GET['idospite'];
$partita = new Partita($idpartita, $idcasa, $idospite, true, 1);
$result = $partita->calcolaRisultatoPartita();
print_r($result);
?>