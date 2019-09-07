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

<style>
/* table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}


.a-form  {
 font-family: Arial;
 font-size: 20px;
    padding: 50px 50px;
}

.floatbox {
    float:left; /*force into block level for dimensions*/
    //width:400px;
    /* height:1100; */
    //background:blue;
    color:#000;
    margin:20px 20px 0 0;
}

.aggiungi {
    background:yellow;
    color:#000;
    margin:20px 20px 0 0;
}

.summary {
	border: 0;   border-collapse:collapse;
	}

.summary td{
       border:0;
	} */
</style>
