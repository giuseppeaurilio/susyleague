<?php
#echo "pippo";
$voti=$_POST["selectedIDs"];
$id_sondaggio=$_POST["id_sondaggio"];
#print_r($voti);
#echo $id_sondaggio;

    session_start();
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	$allenatore="";
	header ("Location: login.php?&caller=invio_formazione.php");
	}
	else { 
	$allenatore= $_SESSION['allenatore'];
	$id_squadra_logged= $_SESSION['login'];
	}
	

include("dbinfo_susyleague.inc.php");
mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

date_default_timezone_set('Europe/Rome');

$adesso = date('Y-m-d H:i:s');

$query="SELECT * FROM sondaggi where id=" . $id_sondaggio . " and scadenza > '" . $adesso ."'";
$result=mysql_query($query);
$num=mysql_numrows($result); 
#echo "numbers=" . $num;
if ($num>0){
	$query="DELETE FROM `sondaggi_risposte` WHERE `id_sondaggio`='" . $id_sondaggio . "' and`id_squadra`='". $id_squadra_logged ."'";
		#echo $query;
		$result=mysql_query($query);
	foreach ($voti as $value) {
		$query="REPLACE INTO `sondaggi_risposte` (`id_squadra`, `id_sondaggio`, `id_opzione`) VALUES ('". $id_squadra_logged ."', '" . $id_sondaggio . "', '" . $value . "')";
		#echo $query;
		$result=mysql_query($query);
	}
echo "il tuo voto e' stato inserito correttamente";
}
else {
	echo "non e' possible inviare il voto";
}
#header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
