<?php

$competizione=$_POST['competizione'];
$vincitore=$_POST['vincitore'];



include("../dbinfo_susyleague.inc.php");
$link = mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query = "REPLACE INTO `vincitori`(`competizione`, `id_vincitore`) VALUES ('" . $competizione ."','". $vincitore ."')";
$result=mysql_query($query);
echo $query
?>
