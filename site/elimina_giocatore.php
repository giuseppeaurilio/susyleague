<?php 

include("menu.php");
include("../dbinfo_susyleague.inc.php");
$link=mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$id_giocatore=$_GET['id_giocatore'];
//echo "pippo";
//echo $id_giocatore;
$query="select * from formazioni where id_giocatore=$id_giocatore";
//echo $query;

$result=mysql_query($query);
$num=mysql_numrows($result); 

if ($num>0)
 {
	echo "Il giocatore che si vuole eliminare e' stato schierato almeno una volta e non puo'essere eliminato!";
}
else {
	$query="select * from rose where id_giocatore=$id_giocatore";
	$result=mysql_query($query);
	$num=mysql_numrows($result);
	if ($num>0)
	{
	echo "Il giocatore che si vuole eliminare e' incluso in una rosa. Eliminarlo dalla rosa della squadra di fantacalcio prima di eliminarlo dalla lista dei giocaotri!";
	}
	else
	{	
	$query="DELETE FROM `giocatori` WHERE `id`=$id_giocatore";
	//echo $query;
	echo "Giocatore eliminato";
	$result=mysql_query($query) or die(mysql_error($link));
}
}


