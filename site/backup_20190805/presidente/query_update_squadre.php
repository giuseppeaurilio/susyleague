<?php
include("../dbinfo_susyleague.inc.php");

$id_squadra=mysql_escape_String($_POST['id_squadra']);
$nome_squadra=mysql_escape_String($_POST['squadra']);
$allenatore=mysql_escape_String($_POST['allenatore']);
$telefono=mysql_escape_String($_POST['telefono']);
$email=mysql_escape_String($_POST['email']);
$password_squadra=mysql_escape_String($_POST['password']);


//echo "tutto ok!";
//echo $id_squadra;
//echo $id_giornata;
//echo $titolari;


mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


$query = "REPLACE INTO `sq_fantacalcio`(`id`, `squadra`, `allenatore`, `telefono`, `email`, `password`) VALUES ('" . $id_squadra ."','" . $nome_squadra . "','" .$allenatore ."','" . $telefono."','". $email ."','". $password_squadra . "')";
echo $query;
$result=mysql_query($query);





?> 

