<?php 
include("../dbinfo_susyleague.inc.php");
//echo $username;
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";



$costo=$_GET["costo"];
$sommario=$_GET["sommario"];

//echo "costo=" . $costo ."<br>";
//echo "sommario=" . $sommario ."<br>";

$sommario_a=explode( '_', $sommario );

$id_giocatore=$sommario_a[0];
$id_sq_fc=$sommario_a[1];
$esito = "";
include_once ("DB/asta.php");
include_once "DB/parametri.php";

$offertamassima = getOffertaMassima($squadra["id"]);
$riepilogo = getRiepilogoAsta($squadra["id"]);
$numjollyscelti = hasJolly($squadra["id"]);

$numpor = getNumPortieri();
$numdif = getNumDifensori();
$numcen = getNumCentrocampisti();
$numatt = getNumAttaccanti();
$numjolly = getNumJolly();

//verifico se la squadra ha posti nel ruolo disponibili
//verifico il numero di giocatori per ruolo
//nel caso il numero di giocatori base della rosa sia già stato aquistato, aggiungo come jolly

//verifico se la squadra ha soldi a sufficienza
if( $costo> $offertamassima )
    $esito =" Fantamilioni non sufficienti";

if($esito == ""){
    $query="INSERT INTO `rose` (`id_sq_fc`, `id_giocatore`, `costo`) VALUES ('" . $id_sq_fc ."', '". $id_giocatore ."', '". $costo . "')";
    $result=$conn->query($query);
}

$url = parse_url($_SERVER['HTTP_REFERER']);

$url['query'] = 'ruolo=' . $sommario_a[2] ."&esito=" . $esito;
// if(isset($url['query']))
// {
//     $url['query'] = 'ruolo=' . $sommario_a[2];
// }
// else
// {
//     $url['query']["ruolo"] = $sommario_a[2];
// }
// echo build_url($url);
header('Location: ' . build_url($url));

function build_url(array $parts)
    {
        $scheme   = isset($parts['scheme']) ? ($parts['scheme'] . '://') : '';
        $host     = $parts['host'] ?? '';
        $port     = isset($parts['port']) ? (':' . $parts['port']) : '';
        $user     = $parts['user'] ?? '';
        $pass     = isset($parts['pass']) ? (':' . $parts['pass'])  : '';
        $pass     = ($user || $pass) ? ($pass . '@') : '';
        $path     = $parts['path'] ?? '';
        $query    = isset($parts['query']) ? ('?' . $parts['query']) : '';
        $fragment = isset($parts['fragment']) ? ('#' . $parts['fragment']) : '';
        return implode('', [$scheme, $user, $pass, $host, $port, $path, $query, $fragment]);
    }
?>
