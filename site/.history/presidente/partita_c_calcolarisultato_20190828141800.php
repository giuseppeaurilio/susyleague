<?php
 include_once("../DB/calcolarisultato.php");
$idgirone=$_GET['idgirone'];
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
while ($row = $result->fetch_assoc()) {
    array_push($arraypartite,array(
        "id_giornata"=>$row["id_giornata"],      
        "id_partita"=>$row["id_partita"],
        "id_sq_casa"=>$row["id_sq_casa"],
        "id_sq_ospite"=>$row["id_sq_ospite"],
    ));
}
$conn->close();

$usamediadifesa;
$valorefattorecasa;

switch($idgirone)
{
    case 1:
        $usamediadifesa = true;
        $valorefattorecasa = 1;
        break;
    case 2:
    case 3:
        $usamediadifesa = true;
        $valorefattorecasa = 0;
        break;
    case 5:
    case 7:
    case 8:
        $usamediadifesa = true;
        $valorefattorecasa = 0;
        break;
    case 6:
        $usamediadifesa = false;
        $valorefattorecasa = 0;
        break;
}
foreach($partita as $arraypartite){
    $p = new Partita($partita["id_giornata"],
                        $partita["id_giornata"], $idcasa, $idospite, true, 1);
    $result = $partita->calcolaRisultatoPartita();
}

?>