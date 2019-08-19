<?php


include("../dbinfo_susyleague.inc.php");
mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


$id_sondaggio=$_POST["id_sondaggio"];
$testo=mysql_real_escape_string($_POST["testo"]);

$opzioni=$_POST["mytext"];
$risp_multipla=$_POST["risp_multipla"];

$g_fine=mysql_escape_String($_POST['g_fine']);
$m_fine=mysql_escape_String($_POST['m_fine']);
$a_fine=mysql_escape_String($_POST['a_fine']);
$h_fine=mysql_escape_String($_POST['h_fine']);
$min_fine=mysql_escape_String($_POST['min_fine']);


#echo $id_sondaggio;
#echo $testo;

#print_r($id_sondaggio);
#echo "risp_mult=". $risp_multipla;
#if ($risp_multipla) echo "multipla"; else echo "singola";
if ($risp_multipla) $rm=1; else $rm=0;
#echo $risp_multipla!="";
#echo "<br> opzioni  $opzioni";

$query="REPLACE INTO `sondaggi` (`id`, `testo`, `scadenza`, `risposta_multipla`) VALUES ('$id_sondaggio', '$testo', '" .$a_fine . "-" . $m_fine . "-" . $g_fine . " " . $h_fine . ":" . $min_fine ."', '" .$rm . "')";
#echo $query;

mysql_query($query);

$query="DELETE FROM `sondaggi_opzioni` WHERE `id_sondaggio`='$id_sondaggio'";
#echo $query;
mysql_query($query);

$j=1;	
foreach ($opzioni as $value) {

		
	$opzione=mysql_real_escape_string($value);
	$query="INSERT INTO `sondaggi_opzioni` (`id`, `id_sondaggio`, `opzione`) VALUES ('$j', '$id_sondaggio', '$opzione')";
	mysql_query($query);
	#echo $query;
	++$j;
}


mysql_close();
header('Location: ' . $_SERVER['HTTP_REFERER']);



?>
