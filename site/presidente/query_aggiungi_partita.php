<?php

$id_giornata=$_POST['id_giornata'];
$id_partita=$_POST['id_partita'];
$id_sq_casa=$_POST['id_squadra_casa'];
$id_sq_ospite=$_POST['id_squadra_ospite'];


// include_once ("../dbinfo_susyleague.inc.php");
// // Create connection
// if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
// echo "Connected successfully";
include_once("../dbinfo_susyleague.inc.php");
    $conn = getConnection();



$query = "REPLACE INTO `calendario`(`id_giornata`, `id_partita`, `id_sq_casa`, `id_sq_ospite`) VALUES ('" . $id_giornata ."','". $id_partita ."','". $id_sq_casa . "','" . $id_sq_ospite ."')";
$result=$conn->query($query);
echo $query
?>
