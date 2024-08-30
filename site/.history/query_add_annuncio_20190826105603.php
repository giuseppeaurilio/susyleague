<?php 
include("dbinfo_susyleague.inc.php");
date_default_timezone_set('Europe/Rome');
$date = date('Y-m-d');

$testo=mysql_escape_String($_GET['testo_annuncio']);

    session_start();
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	$allenatore="";
	}
	else { 
	$allenatore= $_SESSION['allenatore'];
	$id_squadra_logged= $_SESSION['login'];
	
	$con=mysqli_connect($localhost,$username,$password,$database) or die( "Unable to select database");


	$query="INSERT INTO `mercato` (`id_squadra`, `testo`, `data_annuncio`) VALUES ('$id_squadra_logged', '$testo', '$date');";
	//echo $query;
	$result=mysqli_query($con,$query);
	
	
	
	
	
	}
header("Location: {$_SERVER['HTTP_REFERER']}");
exit;
