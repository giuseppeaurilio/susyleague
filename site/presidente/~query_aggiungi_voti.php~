<?php 
include("../dbinfo_susyleague.inc.php");


$id_squadra=mysql_escape_String($_POST['id_squadra']);
$id_giornata=mysql_escape_String($_POST['id_giornata']);
$giocatori=mysql_escape_String($_POST['giocatori']);

$link = mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query_ini = "REPLACE INTO `formazioni`(`id_giornata`, `id_squadra`, `id_posizione`, `nome`, `squadra`, `ruolo`, `voto`, `voto_md`) VALUES (" . $id_giornata .",". $id_squadra . "," ;

$giocatori_line_array=explode("," , $giocatori);
$i=1;
#echo "<br> array=";
print_r($giocatori_line_array);
foreach ($giocatori_line_array as $giocatore_line) {
	$giocatore=explode("_" , $giocatore_line);
	#echo "dati array=";
	print_r($giocatore);
	if ($giocatore[3]==""){$giocatore[3]="null";}
	if ($giocatore[4]==""){$giocatore[4]="null";}
	$query=$query_ini . $i . ",'" . mysql_real_escape_string($giocatore[0]) . "','".  $giocatore[1] . "','" .  $giocatore[2] . "'," .  $giocatore[3] . ",".  $giocatore[4] .")";
	echo $query;
	$result=mysql_query($query);
	$i++;
	
}// end giocatori

?>
