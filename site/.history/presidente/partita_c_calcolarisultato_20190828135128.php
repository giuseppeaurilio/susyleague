<?php
 include_once("../DB/calcolarisultato.php");

$idgiornata=$_GET['idgiornata'];
// $idpartita=$_GET['idpartita'];
// $idcasa=$_GET['idcasa'];
// $idospite=$_GET['idospite'];
// $partita = new Partita($idgiornata, $idpartita, $idcasa, $idospite, true, 1);
// $result = $partita->calcolaRisultatoPartita();
// print_r($result);
include "../dbinfo_susyleague.inc.php";

// Create connection
$conn = new mysqli($localhost, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = 'SELECT * FROM `calendario` where id_giornata = ' . $idgiornata .' order by id_partita';

$result=$conn->query($query);

$arraypartite = array();
//recupero i dati dal DB e li trasferisco nell'array di oggetti
while ($giocatore = $result->fetch_assoc()) {
    array_push($arraypartite,array(
        "id_giornata"=>$row["id_giornata"],      
        "id_partita"=>$row["id_partita"],
        "id_sq_casa"=>$row["id_sq_casa"],
        "id_sq_ospite"=>$row["id_sq_ospite"],
    ));
}
$conn->close();
?>