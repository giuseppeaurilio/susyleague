<?php 
include("dbinfo_susyleague.inc.php");
date_default_timezone_set('Europe/Rome');
$date = date('Y-m-d');

$id_annuncio=mysql_escape_String($_GET['id_annuncio']);

    session_start();
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	$allenatore="";
	}
	else { 
	$allenatore= $_SESSION['allenatore'];
	$id_squadra_logged= $_SESSION['login'];
	
	$con=mysqli_connect($localhost,$username,$password,$database) or die( "Unable to select database");


	$query="DELETE FROM mercato WHERE id_annuncio='$id_annuncio' and `id_squadra`='$id_squadra_logged'";

	//echo $query;
	$result=mysqli_query($con,$query);
	
	
	
	
	
	}
header("Location: {$_SERVER['HTTP_REFERER']}");
exit;
