<?php
function getParametro($parametro){
    // global $localhost;
    // global $username;
    // global $password;
    // global $database;
    // global $conn;
    // if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    // include_once("dbinfo_susyleague.inc.php");
    $conn = getConnection();

    $query_generale="SELECT valore FROM generale where nome_parametro='$parametro'";
    $result_generale = $conn->query($query_generale);
    $f=mysqli_fetch_assoc($result_generale);
    // if(isset($conn))
    // {$conn->close();}
    return $f["valore"];
}

function getFantamilioni()
{
    if(!isset($_SESSION['fantamilioni']))
    {
        $_SESSION['fantamilioni'] = getParametro("fantamilioni");
    }
    return $_SESSION['fantamilioni'];
}

function getAnno()
{
    if(!isset($_SESSION['anno']))
    {
        $_SESSION['anno'] = getParametro("anno");
    }
    return $_SESSION['anno'];
}

function getStrAnno()
{
    return  str_replace("/", "-", getAnno());
}
function getStrAnnoPrecedente()
{
    $anno = getAnno();
    return ((int)(explode("/", $anno)[0])-1)."_".((int)(explode("/", $anno)[1])-1);;
}

function getNumPortieri()
{
    return 3;
}

function getNumDifensori()
{
    return 9;
}

function getNumCentrocampisti()
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

function getOffertaMinima()
{
    return 1;
}

function getNumeroFantasquadre()
{
    return 12;
}

function getValoreFattoreCasa()
{
    return getParametro("addizionale_casa");
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
