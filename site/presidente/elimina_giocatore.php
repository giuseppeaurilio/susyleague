<?php 

include("menu.php");
include("../dbinfo_susyleague.inc.php");


// Create connection
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";


$id_giocatore=$_GET['id_giocatore'];
//echo "pippo";
//echo $id_giocatore;
$query="select * from formazioni where id_giocatore=$id_giocatore";
//echo $query;

$result=$conn->query($query);
$num=$result->num_rows; 

if ($num>0)
 {
	echo "Il giocatore che si vuole eliminare e' stato schierato almeno una volta e non puo'essere eliminato!";
}
else {
	$query="select * from rose where id_giocatore=$id_giocatore";
	$result=$conn->query($query);
	$num=$result->num_rows;
	if ($num>0)
	{
		echo "Il giocatore che si vuole eliminare e' incluso in una rosa. Eliminarlo dalla rosa della squadra di fantacalcio prima di eliminarlo dalla lista dei giocaotri!";
	}
	else
	{	
		$query="DELETE FROM `giocatori` WHERE `id`=$id_giocatore";
		//echo $query;
		echo "Giocatore eliminato";
		$result=$conn->query($query);
	}
}


