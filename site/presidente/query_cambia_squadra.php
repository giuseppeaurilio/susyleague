<?php
// include_once ("../dbinfo_susyleague.inc.php");

$id_giocatore=$_GET['id_giocatore'];
$id_squadra=$_GET['squadra_serie_a'];

// //echo $id_giocatore;
// //echo $id_squadra;

// // Create connection
// if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
// echo "Connected successfully";
include_once("../dbinfo_susyleague.inc.php");
    $conn = getConnection();


$query="UPDATE `giocatori` SET `id_squadra`=$id_squadra WHERE `id`=$id_giocatore";
 

$conn->query($query);



header("Location: {$_SERVER["HTTP_REFERER"]}");

?>

