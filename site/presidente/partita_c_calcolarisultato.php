<?php
include_once ("../DB/calcolarisultato.php");
include_once ("../DB/statistiche.php");
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

// $query = 'SELECT * FROM `calendario` where id_giornata = ' . $idgiornata .' order by id_partita';
$query = "SELECT c.*, g.giornata_serie_a_id FROM `calendario` as c 
left join giornate as g on c.id_giornata = g.id_giornata
where c.id_giornata =  $idgiornata 
order by id_partita";

$result=$conn->query($query);

$arraypartite = array();
$giornata_serie_a = 0;
//recupero i dati dal DB e li trasferisco nell'array di oggetti
while ($row = $result->fetch_assoc()) {
    array_push($arraypartite,array(
        "id_giornata"=>$row["id_giornata"],      
        "id_partita"=>$row["id_partita"],  
        "id_sq_casa"=>$row["id_sq_casa"],
        "id_sq_ospite"=>$row["id_sq_ospite"],
        "mdcasa"=>$row["use_mdcasa"],
        "mdospite"=>$row["use_mdospite"],
    ));
    $giornata_serie_a = $row["giornata_serie_a_id"];
}
$conn->close();
include_once ("../DB/parametri.php");
$usamediadifesa;
$valorefattorecasa;

switch($idgirone)
{
    case 1://apertura
    case 5://tabellone coppa italia
    case 7://finale campionato
        $usamediadifesa = true;
        $valorefattorecasa = getValoreFattoreCasa();//non deve essere utilizzato nella finale coppa italia
        break;
    case 2://chiusura
    case 3://play off play out
    case 4://coppa italia - girone
    case 8://supercoppa
    case 9://finale coppa italia - turno secco
        $usamediadifesa = true;
        $valorefattorecasa = 0;
        break;
    case 6://coppa delle coppe
        $usamediadifesa = false;
        $valorefattorecasa = 0;
        break;
}
foreach($arraypartite as $partita){ 
    $p = new Partita($partita["id_giornata"],
                     $partita["id_sq_casa"], 
                     $partita["id_sq_ospite"],
                     $usamediadifesa, 
                     $valorefattorecasa,
                     $partita["mdcasa"],
                     $partita["mdospite"]);
    $result = $p->calcolaRisultatoPartita();
    // print("<pre>".print_r($result   ,true)."</pre>").'<br>';

    $conn = new mysqli($localhost, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // print("<pre>".print_r($result   ,true)."</pre>").'<br>';
    $queryupdate = 'UPDATE `calendario` 
                    SET `gol_casa`='.$result->golCasa.'
                    ,`gol_ospiti`='.$result->golOspite.'
                    ,`punti_casa`='.$result->punteggioCasa.'
                    ,`punti_ospiti`='.$result->punteggioOspite.'
                    ,`fattorecasa`='.$result->punteggioFattoreCasa.'
                    ,`md_casa`='.$result->punteggioMediaDifesaAvversariaCasa.'
                    ,`numero_giocanti_casa`='.$result->numeroVotiCasa.'
                    ,`md_ospite`='.$result->punteggioMediaDifesaAvversariaOspite.'
                    ,`numero_giocanti_ospite`='.$result->numeroVotiOspite.'
                    where id_giornata = ' .$partita["id_giornata"].
                    ' and id_partita = ' .$partita["id_partita"].
                    ' and id_sq_casa = ' .$partita["id_sq_casa"].
                    ' and id_sq_ospite = ' .$partita["id_sq_ospite"];

    // print("<pre>".print_r($queryupdate   ,true)."</pre>").'<br>';
    $result=$conn->query($query);
    // echo  $database;
    // print("<pre>".print_r($result   ,true)."</pre>").'<br>';
    if ($conn->query($queryupdate) === TRUE) {
        // echo "Record updated successfully <br>";
    } else {
        echo "Error updating record: " . $conn->error. '<br>';
    }
    
    $conn->close();

    statistiche_miglioreformazione_digiorntata($giornata_serie_a, $partita["id_sq_casa"]);
    statistiche_miglioreformazione_digiorntata($giornata_serie_a, $partita["id_sq_ospite"]);
}
echo json_encode(array(
    'result' => "true",
    'message' => "risultati calcolati",
));
?>