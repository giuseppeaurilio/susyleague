<?php


// include("../dbinfo_susyleague.inc.php");
// mysql_connect($localhost,$username,$password);
// @mysql_select_db($database) or die( "Unable to select database");

include("../dbinfo_susyleague.inc.php");
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_sondaggio=$_GET["id_sondaggio"];

$query="DELETE FROM `sondaggi` WHERE `id`='$id_sondaggio'";
#echo $query;
// mysql_query($query);
$result=$conn->query($query);

$query="DELETE FROM `sondaggi_opzioni` WHERE `id_sondaggio`='$id_sondaggio'";
#echo $query;
// mysql_query($query);
$result=$conn->query($query);

$query="DELETE FROM `sondaggi_risposte` WHERE `id_sondaggio`='$id_sondaggio'";
#echo $query;
// mysql_query($query);
$result=$conn->query($query);

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
