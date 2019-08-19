<?php 
	session_start();
	if (!(isset($_SESSION['login'])  && ($_SESSION['login'] == '0'))) {
	$allenatore="";
	#echo "login=" . $_SESSION['login'] .'*'.$_SESSION['allenatore'] .'*' ;
	header ("Location: ../login.php?&caller=invio_formazione.php");
	#echo isset($_SESSION['login']) ;
	#echo ($_SESSION['login'] == '0');
	}
	else { 
	$allenatore= $_SESSION['allenatore'];
	$id_squadra= $_SESSION['login'];
	}
	
include("../menu.php");
?>
