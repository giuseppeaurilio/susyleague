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