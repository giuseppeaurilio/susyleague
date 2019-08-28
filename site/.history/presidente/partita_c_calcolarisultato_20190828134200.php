<?php
 include_once("../DB/calcolarisultato.php");

$idgiornata=$_GET['idgiornata'];
$idpartita=$_GET['idpartita'];
$idcasa=$_GET['idcasa'];
$idospite=$_GET['idospite'];
$partita = new Partita($idgiornata, $idpartita, $idcasa, $idospite, true, 1);
$result = $partita->calcolaRisultatoPartita();
print_r($result);
?>