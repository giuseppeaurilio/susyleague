<?php 
// include_once ("../dbinfo_susyleague.inc.php");
// if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
// echo "Connected successfully";
include_once("../dbinfo_susyleague.inc.php");
$conn = getConnection();


$id_giocatore=$_GET["id_giocatore"];



$query="DELETE FROM `rose` WHERE `id_giocatore`='". $id_giocatore . "'";

//$query="INSERT INTO `rose` (`id_sq_fc`, `id_giocatore`, `costo`) VALUES ('" . $id_sq_fc ."', '". $id_giocatore ."', '". $costo . "')";
//echo $query . "<br>";
$result=$conn->query($query);
//echo "Giocatore rimosso";
//echo $_SERVER['HTTP_REFERER'];
//sleep(2);

$query="DELETE FROM `rose_asta` WHERE `id_giocatore`='". $id_giocatore . "'";
$result=$conn->query($query);

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>

