<?php
include_once "parametri.php";

function getOffertaMassima($idSquadra){

    global $localhost;
    global $username;
    global $password;
    global $database;

    $conn = new mysqli($localhost, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $fantamilioni=getFantamilioni();

    $query_riepilogo ="select IFNULL(SUM(costo), 0) as spesi, COUNT(id_giocatore) as numero
    from rose 
    where id_sq_fc =" . $idSquadra;
    // echo $query_riepilogo;
    $result_riepilogo = $conn->query($query_riepilogo);
    $s=mysqli_fetch_assoc($result_riepilogo);
    $num=$s["numero"];
    $spesi=$s["spesi"];

    $numpor = getNumPortieri();
    $numdif = getNumDifensori();
    $numcen = getNumCentrocampisti();
    $numatt = getNumAttaccanti();
    $numjolly = getNumJolly();
    $offminima = getOffertaMinima();
    $giocatoridacomprare = ($numpor + $numdif + $numcen + $numatt + $numjolly) - $num ;
    $budgetrimanente = $fantamilioni - $spesi;
    return $budgetrimanente - (($giocatoridacomprare - 1) * $offminima);

}
function getMilioniRimanenti($idSquadra){
    global $localhost;
    global $username;
    global $password;
    global $database;
    
    $conn = new mysqli($localhost, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $fantamilioni=getFantamilioni();

    $query_riepilogo ="select IFNULL(SUM(costo), 0) as spesi, COUNT(id_giocatore) as numero
    from rose 
    where id_sq_fc =" . $idSquadra;
    // echo $query_riepilogo;
    $result_riepilogo = $conn->query($query_riepilogo);
    $s=mysqli_fetch_assoc($result_riepilogo);
    $spesi=$s["spesi"];

    return $fantamilioni - $spesi;
}

function hasJolly($idSquadra){
    // include_once "dbinfo_susyleague.inc.php";

    // Create connection
    $conn = new mysqli($localhost, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return false;
}
?>