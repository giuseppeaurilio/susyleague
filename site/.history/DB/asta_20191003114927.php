<?php
    include_once "dbinfo_susyleague.inc.php";
function getOffertaMassima($idSquadra){
    // include_once "dbinfo_susyleague.inc.php";

    $conn = new mysqli($localhost, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query_generale="SELECT valore FROM generale where nome_parametro='fantamilioni'";
    $result_generale = $con->query($query_generale);
    $f=mysqli_fetch_assoc($result_generale);
    $fantamilioni=$f["valore"];


}
function getMilioniRimanenti($idSquadra){

    // $username="id258940_susy79";
    // $password="andspe79";
    // $database="id258940_susy_league_2019-20_2";
    // $localhost = "localhost";
    $conn = new mysqli($localhost, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query_generale="SELECT valore FROM generale where nome_parametro='fantamilioni'";
    $result_generale = $conn->query($query_generale);
    $f=mysqli_fetch_assoc($result_generale);
    $fantamilioni=$f["valore"];

    $query_riepilogo ="select SUM(costo) as costo, COUNT(id_giocatore) as somma
    from rose 
    where id_sq_fc =" + $idSquadra;
    $result_riepilogo = $conn->query($query_riepilogo);
    $s=mysqli_fetch_assoc($result_riepilogo);
    $spesi=$f["costo"];

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