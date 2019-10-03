<?php
function getOffertaMassima($idSquadra){
    include "../dbinfo_susyleague.inc.php";

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
    $conn = new mysqli($localhost, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query_generale="SELECT valore FROM generale where nome_parametro='fantamilioni'";
    $result_generale = $con->query($query_generale);
    $f=mysqli_fetch_assoc($result_generale);
    $fantamilioni=$f["valore"];

    $query_spesi ="select SUM(costo) as costo
    from rose 
    where id_sq_fc =" + $idSquadra;
    $result_spesi = $con->query($query_spesi);
    $s=mysqli_fetch_assoc($result_spesi);
    $spesi=$f["costo"];

    return $fantamilioni - $spesi;
}

function hasJolly($idSquadra){
    include "../dbinfo_susyleague.inc.php";

    // Create connection
    $conn = new mysqli($localhost, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return false;
}
?>