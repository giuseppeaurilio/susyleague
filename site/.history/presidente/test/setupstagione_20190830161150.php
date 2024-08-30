<?php
include_once ("../../dbinfo_susyleague.inc.php");
include_once  "insertrose.php"; 

$queryportieri ="SELECT *
FROM `sq_fantacalcio` sqf";


$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
try{

    // include_once "../coppaitalia_c_generacalendario.php";
    include_once "../torneoconsolazione_c_generacalendario.php";
    $girone = 4;
    $idsquadre = array();
    $sqfid  = 1;
    for($sqfid = 1 ; $sqfid <= 6; $sqfid++)
    {
        $query  = queryInsertInGirone($girone, $sqfid);
        print("<pre> ".print_r($query,true)." </pre>").'<br>';
        $res  = $conn->query($query) or die($conn->error); 
        array_push($idsquadre, $sqfid);
        print("<pre> Aggiunta ".print_r($sqfid,true)." al girone ".$girone."</pre>").'<br>';
    }
    $girone = 'a';   
    generaCalendario($girone, $idsquadre);


    $girone = 5;
    $idsquadre = array();

    for($sqfid = 7 ; $sqfid <= 12; $sqfid++)
    {
        $res  = $conn->query(queryInsertInGirone($girone, $sqfid)) or die($conn->error); 
        array_push($idsquadre, $sqfid);
        print("<pre> Aggiunta ".print_r($sqfid,true)." al girone ".$girone."</pre>").'<br>';
    }
    $girone = 'b';   
    generaCalendario($girone, $idsquadre);


    //girone  torneo di consolazione
    $idsquadre = array();
    for($sqfid = 1 ; $sqfid <= 10; $sqfid++)
    {
        $res  = $conn->query(queryInsertInGironeConsolazione($sqfid)) or die($conn->error); 
        array_push($idsquadre, $sqfid);
        print("<pre> Aggiunta ".print_r($sqfid,true)." al girone girone di consolazione.</pre>").'<br>';
    }
    
    generaCalendarioConsolazione($idsquadre);

    //finale campionato
    aggiungi_partita(64, 1, 2);
    //finale coppa italia
    aggiungi_partita(67, 3, 4);
    //finale coppa coppe
    aggiungi_partita(68, 5, 6);
    // per ogni squadra, genero una formazione per tutte le partite
    for($i = 1; $i<= 12; $i++ )
    {
        //recupero la rosa della squadra
        $arrayrosa =  array();
        //recupero le partite in casa
        $arraypartitecasa =  array();
        foreach($arraypartitecasa as $parita)
        {
            inserisciFormazione($i, $partita, generaformazione($arrayrosa));
        }

        //recupero le partite in trasferta
        $arraypartitetrasferta =  array();
        foreach($arraypartitecasa as $parita)
        {
            inserisciFormazione($i, $partita, generaformazione($arrayrosa));
        }
    }

    // per ogni partita, inserisco voti randomici alla formazione
    $arraypartitecasa =  array();
    foreach($arraypartite as $partita)
    {
        inseriscivoti($partita);
    }

    $arraypartitetrasferta =  array();
    foreach($arraypartite as $partita)
    {
        inseriscivoti($partita);
    }

}
catch(Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
finally{
    $conn->close();
}

function queryInsertInGirone($girone, $sqfid)
{
    return $querygironicoppaitalia ="INSERT INTO `gironi_ci_squadre`(`id_girone`, `id_squadra`, `squadra_materasso`) VALUES (".$girone .",".$sqfid .",false)";
}

function queryInsertInGironeConsolazione($sqfid)
{
    return $querygironiconsolazione ="INSERT INTO `gironi_tc_squadre`(`id_girone`, `id_squadra`) VALUES (6,".$sqfid .")";
}

function generaCalendario($girone, $idsquadre)
{
    $n = count($idsquadre);
    $tabellone=generateRoundRobinPairings($n);
    $map=range(1, $n);
    shuffle($map);
    $tabellone_shuffled=mappa($tabellone,$map);
    //devo aggiungere 15 partite. le giornate predisposte vanno dalla 34 alla 63 (30 giornate)
    if($girone == "a"){
        $g = 34;
    }
    else{
        $g = 49;
    }
    for ($giornata = 1; $giornata <= ($n -1); $giornata++) {
        foreach ($tabellone_shuffled[$giornata] as $partita) {
            aggiungi_partita($g, $idsquadre[$partita["casa"]-1], $idsquadre[$partita["ospite"]-1]);
            $g++;
        }
    }
    echo json_encode(array(
        'result' => "true",
        'message' => "Operazione correttamente eseguita",
    ));
}

function generaCalendarioConsolazione( $idsquadre)
{
    // include_once "../torneoconsolazione_c_generacalendario.php";
    $n = count($idsquadre);
    $tabellone=generateRoundRobinPairings($n);
    $map=range(1, $n);
    shuffle($map);
    $tabellone_shuffled=mappa($tabellone,$map);
    //devo aggiungere 2 partite. le giornate predisposte vanno sono 65 e 66
    $giornata1 = $tabellone_shuffled[1];
    $giornata2 = $tabellone_shuffled[2];
    // print_r('giornata1');print_r($giornata1);
    // print_r('giornata2');print_r($giornata2);
    cancella_partite(65);
    foreach ($giornata1 as $partita) {
        aggiungi_partita(65, $idsquadre[$partita["casa"]-1], $idsquadre[$partita["ospite"]-1]);
    }
    cancella_partite(66);
    foreach ($giornata2 as $partita) {
        aggiungi_partita(66, $idsquadre[$partita["casa"]-1], $idsquadre[$partita["ospite"]-1]);
    }
    echo json_encode(array(
        'result' => "true",
        'message' => "Operazione correttamente eseguita",
    ));
}

function queryInsertGiocatoreFormazione()
{
    return $query ="";
}

function queryInsertGiocatoreVoto()
{
    return $query ="";
}

function generaFormazione($idSquadra){
    $ret = array();
    //recupero tutta la rosa della squadra

    //decido un modulo
    $modulo = getmModuloRandom();

    //aggiungo il portiere

    //aggiungo i difensori

    //aggiungo i centrocampisti
    
    //aggiungo gli  attaccanti

    return $ret;
}

function getmModuloRandom(){

    $moduli = $array(
        array("3", "5", "2" ),
        array("3", "4", "3" ),
        array("4", "3", "3" ),
        array("4", "4", "2" ),
        array("4", "5", "1" ),
        array("5", "3", "2" ),
        array("5", "4", "1" ),
    );

    return array_rand($moduli);
}


function getVotoRandom($ruolo){
    $votiPortiere = array("","4", "5", "6","7", "5.5", "6.5");
    $votiDifensore = array("","4", "5", "6","7", "4.5", "5.5", "6.5");
    $votiPortiereMD = array("","4", "5", "6","7", "4.5", "5.5", "6.5");
    $votiCentrocampista = array("","4", "5", "6","7","8","9","10","11", "4.5", "5.5", "6.5", "7.5", "8.5", "9.5", "10.5");
    $votiCentrocampista = array("","4", "5", "6","7","8","9","10","11","12","13","14", "4.5", "5.5", "6.5", "7.5", "8.5", "9.5", "10.5", "11.5", "12.5", "13.5");
    $ret;
    switch ($ruolo){
        case "P": $ret = array_rand($votiPortiere); break;
        case "D": $ret = array_rand($votiDifensore); break;
        case "DM":$ret =  array_rand($votiPortiereMD); break;
        case "C":$ret = array_rand($votiCentrocampista); break;
        case "A":$ret =  array_rand($votiAttaccante); break;
    }

    return  $ret;
}

function inserisciFormazione($idSquadra, $partita, $formazionearray)
{
    foreach($formazionearray as $giocatore)
    {
        //insert giocatore in partita
    }
}
?>
