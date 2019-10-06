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
$ruolo=$sommario_a[2];
$esito = "info";
$message = "";
include_once ("../DB/asta.php");
include_once "../DB/parametri.php";

$offertamassima = getOffertaMassima($id_sq_fc);
$riepilogo = getRiepilogoAsta($id_sq_fc);
$numjollyscelti = hasJolly($id_sq_fc);

$numpor = getNumPortieri();
$numdif = getNumDifensori();
$numcen = getNumCentrocampisti();
$numatt = getNumAttaccanti();
$numjolly = getNumJolly();
print_r($riepilogo["giocatori"]);
//verifico il numero di giocatori per ruolo
//nel caso il numero di giocatori base della rosa sia già stato aquistato, aggiungo come jolly
foreach($riepilogo["giocatori"] as $row){
    if($ruolo == $row["ruolo"])
    {
        switch($row["ruolo"])
        {
            case "P":
                if($row["numero"] == $numpor +  $numjolly)
                {   
                    $esito = "error";
                    $message = "numero massimo di giocatori raggiunto";
                }
                else if($row["numero"] == $numpor && $numjollyscelti < $numjolly )
                {   
                    $esito = "warning";
                    $message = "il giocatore è stato aggiunto come jolly";
                }
                else
                {   
                    $esito = "info";
                    $message = "operazione eseguita";
                }
                break;
            case "D":
                if($row["numero"] == $numdif +  $numjolly)
                {   
                    $esito = "error";
                    $message = "numero massimo di giocatori raggiunto";
                }
                else if($row["numero"] == $numdif && $numjollyscelti < $numjolly )
                {   
                    $esito = "warning";
                    $message = "il giocatore è stato aggiunto come jolly";
                }
                else
                {   
                    $esito = "info";
                    $message = "operazione eseguita";
                }
                break;
            case "C":
                if($row["numero"] == $numcen     +  $numjolly)
                {   
                    $esito = "error";
                    $message = "numero massimo di giocatori raggiunto";
                }
                else if($row["numero"] == $numcen && $numjollyscelti < $numjolly )
                {   
                    $esito = "warning";
                    $message = "il giocatore è stato aggiunto come jolly";
                }
                else
                {   
                    $esito = "info";
                    $message = "operazione eseguita";
                }
                break;
            case "A":
                if($row["numero"] == $numatt +  $numjolly)
                {   
                    $esito = "error";
                    $message = "numero massimo di giocatori raggiunto";
                }
                else if($row["numero"] == $numatt && $numjollyscelti < $numjolly )
                {   
                    $esito = "warning";
                    $message = "il giocatore è stato aggiunto come jolly";
                }
                else
                {   
                    $esito = "info";
                    $message = "operazione eseguita";
                }
                break;
        }
    }
}


//verifico se la squadra ha soldi a sufficienza
if( $costo > $offertamassima )
{
    $esito = "error";
    $message = "Fantamilioni insufficienti";
}

if($esito != "error"){
    $query="INSERT INTO `rose` (`id_sq_fc`, `id_giocatore`, `costo`) VALUES ('" . $id_sq_fc ."', '". $id_giocatore ."', '". $costo . "')";
    $result=$conn->query($query);
}

echo '<br> '. $esito;
echo '<br> '. $message;
echo '<br> '. $numjollyscelti;


$url = parse_url($_SERVER['HTTP_REFERER']);

$url['query'] = 'ruolo=' . $ruolo ."&esito=". $esito ."&message=" .$message;

// header('Location: ' . build_url($url));

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
