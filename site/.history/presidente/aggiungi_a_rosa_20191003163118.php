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
$query="INSERT INTO `rose` (`id_sq_fc`, `id_giocatore`, `costo`) VALUES ('" . $id_sq_fc ."', '". $id_giocatore ."', '". $costo . "')";
//echo $query . "<br>";
$result=$conn->query($query);
//echo "Giocatore aggiunto";
//echo $_SERVER['HTTP_REFERER'];
//sleep(2);
$esito = "errore";

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
