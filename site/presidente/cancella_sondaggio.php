<?php


include("../dbinfo_susyleague.inc.php");
mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


$id_sondaggio=$_GET["id_sondaggio"];

$query="DELETE FROM `sondaggi` WHERE `id`='$id_sondaggio'";
#echo $query;
mysql_query($query);

$query="DELETE FROM `sondaggi_opzioni` WHERE `id_sondaggio`='$id_sondaggio'";
#echo $query;
mysql_query($query);

$query="DELETE FROM `sondaggi_risposte` WHERE `id_sondaggio`='$id_sondaggio'";
#echo $query;
mysql_query($query);

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
