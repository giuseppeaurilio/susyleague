
<?php 
// include_once ("../dbinfo_susyleague.inc.php");
// //echo $username;
// if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
// echo "Connected successfully";
// include_once("~/dbinfo_susyleague.inc.php");
// $conn = getConnection();
include_once("../dbinfo_susyleague.inc.php");
$conn = getConnection();
$costo=$_GET["costo"];


$sommario=$_GET["sommario"];

//echo "costo=" . $costo ."<br>";
//echo "sommario=" . $sommario ."<br>";

$sommario_a=explode( '_', $sommario );

$id_giocatore=$sommario_a[0];
$id_sq_fc=$sommario_a[1];
$ruolo=$sommario_a[2];
$min=$sommario_a[3];
$max=$sommario_a[4];
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
// print_r($riepilogo["giocatori"]);
//verifico il numero di giocatori per ruolo
//nel caso il numero di giocatori base della rosa sia già stato aquistato, aggiungo come jolly
foreach($riepilogo["giocatori"] as $row){
    if($ruolo == $row["ruolo"])
    {
        switch($row["ruolo"])
        {
            case "P":
                if($row["numero"] >= $numpor)
                {   
                    if($numjollyscelti < $numjolly)
                    {   
                        $esito = "warning";
                        $message = "Il giocatore è stato aggiunto come jolly.";
                    }
                    else{
                        $esito = "error";
                        $message = "Numero massimo di portieri raggiunto.";
                    }
                }
                else
                {   
                    $esito = "info";
                    $message = "operazione eseguita";
                }
                break;
            case "D":
                if($row["numero"] >= $numdif)
                {   
                    if($numjollyscelti < $numjolly)
                    {   
                        $esito = "warning";
                        $message = "Il giocatore è stato aggiunto come jolly.";
                    }
                    else{
                        $esito = "error";
                        $message = "Numero massimo di difensori raggiunto.";
                    }
                }
                else
                {   
                    $esito = "info";
                    $message = "operazione eseguita";
                }
                break;
            case "C":
                if($row["numero"] >= $numcen)
                {   
                    if($numjollyscelti < $numjolly)
                    {   
                        $esito = "warning";
                        $message = "Il giocatore è stato aggiunto come jolly.";
                    }
                    else{
                        $esito = "error";
                        $message = "Numero massimo di centrocampisti raggiunto.";
                    }
                }
                else
                {   
                    $esito = "info";
                    $message = "operazione eseguita";
                }
                break;
            case "A":
                if($row["numero"] >= $numatt)
                {   
                    if($numjollyscelti < $numjolly)
                    {   
                        $esito = "warning";
                        $message = "Il giocatore è stato aggiunto come jolly.";
                    }
                    else{
                        $esito = "error";
                        $message = "Numero massimo di giocatori raggiunto.";
                    }

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
if( $esito == "info"  && $costo > $offertamassima )
{
    $esito = "error";
    $message = "Fantamilioni insufficienti";
}

if($esito != "error"){
    // $query="INSERT INTO `rose` (`id_sq_fc`, `id_giocatore`, `costo`) VALUES ('" . $id_sq_fc ."', '". $id_giocatore ."', '". $costo . "')";
    $query="UPDATE `rose` SET `id_sq_fc`=$id_sq_fc,`costo`=$costo where `id_giocatore`=$id_giocatore";
    $result=$conn->query($query);

    $query="INSERT INTO `rose_asta` (`id_sq_fc`, `id_giocatore`, `costo`) VALUES ('" . $id_sq_fc ."', '". $id_giocatore ."', '". $costo . "')";
    $result=$conn->query($query);
}

// echo '<br> '. $esito;
// echo '<br> '. $message;
// echo '<br> '. $numjolly;
// echo '<br> '. $numjollyscelti;


$url = parse_url($_SERVER['HTTP_REFERER']);

$url['query'] = 'ruolo=' . $ruolo ."&min=". $min ."&max=". $max ."&esito=". $esito ."&message=" .$message;

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

