<?php 
include("../dbinfo_susyleague.inc.php");
#echo $username;
mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$id_giocatore=$_GET["id_giocatore"];



$query="DELETE FROM `rose` WHERE `id_giocatore`='". $id_giocatore . "'";

//$query="INSERT INTO `rose` (`id_sq_fc`, `id_giocatore`, `costo`) VALUES ('" . $id_sq_fc ."', '". $id_giocatore ."', '". $costo . "')";
//echo $query . "<br>";
$result=mysql_query($query);
//echo "Giocatore rimosso";
//echo $_SERVER['HTTP_REFERER'];
//sleep(2);

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>

