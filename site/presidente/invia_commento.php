<?php
$commento=$_GET['commento'];
$id_giornata=$_GET['id_giornata'];
//echo "commento=".$commento . "<br>";
//echo "giornata=" . $id_giornata. "<br>";

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

mysqli_set_charset('utf8', $db); 

$commento_esc=mysqli_real_escape_string($conn,$commento);
$query="UPDATE `giornate` SET `commento`='" . $commento_esc."' WHERE `id_giornata`='" .$id_giornata  ."'";
echo $query . "<br>";
$conn->query($query);

header("Location: {$_SERVER["HTTP_REFERER"]}");
?>
