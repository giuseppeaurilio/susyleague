<?php
 include_once("../DB/calcolarisultato.php");

$id_girone=$_GET['id_girone'];
$idcasa=$_GET['idcasa'];
$idospite=$_GET['idospite'];
$partita = new Partita($id_girone, $idcasa, $idospite, true, 1);
$result = $partita->calcolaRisultatoPartita();
print_r($result);
?>