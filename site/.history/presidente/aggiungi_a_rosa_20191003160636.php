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


$url = parse_url($_SERVER['HTTP_REFERER']);
if(isset($url['query']))
{
    $url["ruolo"] = $sommario_a[2];
}
else
{
    $url = $_SERVER['HTTP_REFERER'] . "?ruolo=". $sommario_a[2];
}
echo $url;
// header('Location: ' . http_build_url($url));

?>
