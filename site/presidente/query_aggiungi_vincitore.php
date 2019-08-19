<?php

$competizione=$_POST['competizione'];
$vincitore=$_POST['vincitore'];



include("../dbinfo_susyleague.inc.php");
// Create connection
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";


$query = "REPLACE INTO `vincitori`(`competizione`, `id_vincitore`) VALUES ('" . $competizione ."','". $vincitore ."')";
$result=$conn->query($query);
echo $query
?>
