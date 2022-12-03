<?php
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


$id_squadra=$conn->real_escape_string($_POST['id_squadra']);
$nome_squadra=$conn->real_escape_string($_POST['squadra']);
$allenatore=$conn->real_escape_string($_POST['allenatore']);
$telefono=$conn->real_escape_string($_POST['telefono']);
$email=$conn->real_escape_string($_POST['email']);
$password_squadra=$conn->real_escape_string($_POST['password']);



$query = "REPLACE INTO `sq_fantacalcio`(`id`, `squadra`, `allenatore`, `telefono`, `email`, `password`) VALUES ('" . $id_squadra ."','" . $nome_squadra . "','" .$allenatore ."','" . $telefono."','". $email ."','". $password_squadra . "')";
echo $query;
$result=$conn->query($query);

?> 

