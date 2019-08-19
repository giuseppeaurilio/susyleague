<?php
include("../dbinfo_susyleague.inc.php");

$id_giocatore=$_GET['id_giocatore'];
$id_squadra=$_GET['squadra_serie_a'];

//echo $id_giocatore;
//echo $id_squadra;

$query="UPDATE `giocatori` SET `id_squadra`=$id_squadra WHERE `id`=$id_giocatore";
//echo $query;
mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database"); 

mysql_query($query);

mysql_close();

header("Location: {$_SERVER["HTTP_REFERER"]}");

?>

