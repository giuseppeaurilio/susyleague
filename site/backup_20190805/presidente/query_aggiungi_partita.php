<?php

$id_giornata=$_POST['id_giornata'];
$id_partita=$_POST['id_partita'];
$id_sq_casa=$_POST['id_squadra_casa'];
$id_sq_ospite=$_POST['id_squadra_ospite'];


include("../dbinfo_susyleague.inc.php");
$link = mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query = "REPLACE INTO `calendario`(`id_giornata`, `id_partita`, `id_sq_casa`, `id_sq_ospite`) VALUES ('" . $id_giornata ."','". $id_partita ."','". $id_sq_casa . "','" . $id_sq_ospite ."')";
$result=mysql_query($query);
echo $query
?>
