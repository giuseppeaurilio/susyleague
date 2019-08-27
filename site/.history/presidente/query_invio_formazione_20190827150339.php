<?php 
include("../dbinfo_susyleague.inc.php");

$id_squadra=preg_replace("/[^A-Za-z0-9]/", '', $_POST['id_squadra']);//mysql_escape_String($_POST['id_squadra']);
$id_giornata=preg_replace("/[^A-Za-z0-9]/", '', $_POST['id_giornata']);//mysql_escape_String($_POST['id_giornata']);
$titolari=preg_replace("/[^A-Za-z0-9]/", '', $_POST['titolari']);//mysql_escape_String($_POST['titolari']);
$panchina=preg_replace("/[^A-Za-z0-9]/", '', $_POST['panchina']);//mysql_escape_String($_POST['panchina']);
$password_all=preg_replace("/[^A-Za-z0-9]/", '', $_POST['password_all']);//mysql_escape_String($_POST['password_all']);

#echo "tutto ok!";
#echo $id_squadra;
#echo $id_giornata;
#echo $titolari;
#echo $password_all;


date_default_timezone_set('Europe/Rome');

$adesso = date('Y-m-d H:i:s');

// $link = mysql_connect($localhost,$username,$password);
// @mysql_select_db($database) or die( "Unable to select database");
include("../dbinfo_susyleague.inc.php");
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$query="select fine from giornate where id_giornata=" . $id_giornata  . " and fine > '" . $adesso ."'";
#echo "<br>query_data=" . $query;
// $result=mysql_query($query);
// $num=mysql_numrows($result); 
$result  = $conn->query($query) or die($conn->error);
$query="SELECT password FROM sq_fantacalcio where id='" . $id_squadra . "'";
#echo $query;
// $result=mysql_query($query);
// $saved_password=mysql_result($result,0,"password");
// $result  = $conn->query($query) or die($conn->error);
$result = mysqli_query($conn,$query);
$row = mysqli_fetch_array($result);
$saved_password= $row['password'];


#if ($num>0){
	#if ($saved_password==$password_all){ 
		$titolari_array=explode("," , $titolari);
		$panchina_array=explode("," , $panchina);
		$num_titolari=count($titolari_array);
		$num_panchina=count($panchina_array);
		echo print_r($titolari_array());
		// echo "<br> num panchina= " . $panchina_array;
		if (($num_titolari==11) and ($num_panchina==8)){
			$giocatori=array_merge ($titolari_array, $panchina_array);
			#print_r($giocatori);
			$i=1;
			$query_ini = "REPLACE INTO `formazioni`(`id_giornata`, `id_squadra`, `id_posizione`, `id_giocatore`, `id_squadra_sa`) VALUES (" . $id_giornata .",". $id_squadra . "," ;

			foreach ($giocatori as $value) {
				
				$query_squadra="SELECT id_squadra FROM giocatori where  id=" .$value ;
				#echo $query_nome;
				$result=mysql_query($query_squadra);
				$id_squadra=mysql_result($result,0,"id_squadra");

				$query=$query_ini . $i . ",'" .$value . "','" . $id_squadra . "')" ;
				$result=mysql_query($query);
				$i=$i+1;
				#echo $query;
			}# end foreach
		echo "Formazione inviata in data " . $adesso;
		} #end if numero giocatori
		else echo "La formazione deve includere necessariamente 11 titolari e 8 riserve";
	#}# end if password corretta
	#else echo "La password inserita e' sbagliata";
#}# end if data corretta
#else echo "E' troppo tardi per inviare la formazione";
?> 
