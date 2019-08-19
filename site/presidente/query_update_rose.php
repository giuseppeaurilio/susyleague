<?
include("../dbinfo_susyleague.inc.php");

$id_squadra=mysql_escape_String($_POST['id_squadra']);
$id_posizione=mysql_escape_String($_POST['id_posizione']);
$costo=mysql_escape_String($_POST['costo']);
$ruolo=mysql_escape_String($_POST['ruolo']);
$squadra=mysql_escape_String($_POST['squadra']);
$nome=mysql_escape_String($_POST['nome']);


$query = "REPLACE INTO `rose` (`sq_fantacalcio_id`,`id_posizione`,`nome`,`ruolo`, `squadra`,`costo`) VALUES ('"  . $id_squadra . "','" . $id_posizione . "','" . $nome . "','"  . $ruolo . "','"  . $squadra. "','"  . $costo . "')";



mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database"); 

mysql_query($query);
echo $query;
mysql_close();

?> 