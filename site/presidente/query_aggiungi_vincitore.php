<?php

$competizione=$_POST['competizione'];
$vincitore=$_POST['vincitore'];



// include_once ("../dbinfo_susyleague.inc.php");
// // Create connection
// if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
// // echo "Connected successfully";
include_once("../dbinfo_susyleague.inc.php");
    $conn = getConnection();


$query = "REPLACE INTO `vincitori`(`competizione`, `id_vincitore`) VALUES ('" . $competizione ."','". $vincitore ."')";
$result=$conn->query($query);
echo $query
?>
