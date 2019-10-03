<?php
function getParametro($parametro){
    global $localhost;
    global $username;
    global $password;
    global $database;

    $conn = new mysqli($localhost, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query_generale="SELECT valore FROM generale where nome_parametro='$parametro'";
    $result_generale = $conn->query($query_generale);
    $f=mysqli_fetch_assoc($result_generale);
    return $f["valore"];
}

function getFantamilioni()
{
    return getParametro("fantamilioni");
}

function getNumPortieri()
{
    return 3;
}

function getNumDifensori()
{
    return 9;
}

function getNumCentrocapisti()
{
    return 9;
}

function getNumAttaccanti()
{
    return 7;
}

function getNumJolly()
{
    return 1;
}

function getValoreFattoreCasa()
{
    return 1;
}

function getModuli()
{
    $moduli = array();
    array_push($moduli,"5-4-1");
    array_push($moduli,"5-3-2");
    array_push($moduli,"4-5-1");
    array_push($moduli,"4-4-2");
    array_push($moduli,"4-3-3");
    array_push($moduli,"3-4-3");
    array_push($moduli,"3-5-2");

    return $moduli;
}

?>
