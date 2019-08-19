<?php 
include("../dbinfo_susyleague.inc.php");


$id_squadra=$_GET['id_squadra'];
$id_giornata=$_GET['id_giornata'];
$giocatori=$_GET['giocatori'];

$link = mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query_ini = "REPLACE INTO `formazioni`(`id_giornata`, `id_squadra`, `id_posizione`, `nome`, `squadra`, `ruolo`, `voto`, `voto_md`) VALUES (" . $id_giornata .",". $id_squadra . "," ;
$query_ini=" UPDATE `formazioni` SET `voto`='16', `voto_md`='44' WHERE `id_giornata`='1' and`id_squadra`='10' and`id_posizione`='1'";

$giocatori_line_array=explode("," , $giocatori);
$i=1;
#echo "<br> array=";
print_r($giocatori_line_array);
foreach ($giocatori_line_array as $giocatore_line) {
	$giocatore=explode("_" , $giocatore_line);
	#echo "dati array=";
	print_r($giocatore);
	if ($giocatore[1]==""){$giocatore[1]="null";}
	if ($giocatore[2]==""){$giocatore[2]="null";}
	$query=$query_ini . $i . ",'" . mysql_real_escape_string($giocatore[0]) . "','".  $giocatore[1] . "','" .  $giocatore[2] . "'," .  $giocatore[3] . ",".  $giocatore[4] .")";
	$query=" UPDATE `formazioni` SET `voto`=$giocatore[1], `voto_md`=$giocatore[2] WHERE `id_giornata`=$id_giornata and`id_squadra`=$id_squadra and`id_posizione`=$giocatore[0];";

	echo $query;
	$result=mysql_query($query);
	$i++;
	
}// end giocatori

?>
