<?php 
include_once ("dbinfo_susyleague.inc.php");

$id_squadra=mysql_escape_String($_POST['id_squadra']);
$id_giornata=mysql_escape_String($_POST['id_giornata']);
$titolari=mysql_escape_String($_POST['titolari']);
$panchina=mysql_escape_String($_POST['panchina']);

$password_all=mysql_escape_String($_POST['password_all']);
    session_start();
	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	$allenatore="";
	}
	else { 
	$allenatore= $_SESSION['allenatore'];
	$id_squadra_logged= $_SESSION['login'];
	}
	
$ammcontrollata=preg_replace("/[^0-9]/", '', $_POST['ammcontrollata']);

date_default_timezone_set('Europe/Rome');

$adesso = date('Y-m-d H:i:s');
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$queryupdate='UPDATE `sq_fantacalcio` SET `ammcontrollata`='.$ammcontrollata .' WHERE id=' . $id_squadra;

$result  = $conn->query($queryupdate) or die($conn->error);

$link = mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
$query="select fine from giornate where id_giornata=" . $id_giornata  . " and fine > '" . $adesso ."'";
#echo "<br>query_data=" . $query;
$result=mysql_query($query);
$num=mysql_numrows($result); 

#$query="SELECT password FROM sq_fantacalcio where id='" . $id_squadra . "'";
#echo $query;
#$result=mysql_query($query);
#$saved_password=mysql_result($result,0,"password");
#echo "id_squadra_logged" . $id_squadra_logged;
#echo "allenatore" . $allenatore;
#echo "id_squadra" . $id_squadra;
if ($num>0){
	if ($id_squadra==$id_squadra_logged){ 
		#echo "pippo" .$id_squadra_logged .  $id_squadra . "fine";
		$titolari_array=explode("," , $titolari);
		$panchina_array=explode("," , $panchina);
		$num_titolari=count($titolari_array);
		$num_panchina=count($panchina_array);
		#echo "<br> num titolari= " .$num_titolari;
		#echo "<br> num panchina= " . $num_panchina;
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
	}# end if password corretta
	else echo "Non si e' autenticai per iviare la formazione";
}# end if data corretta
else echo "E' troppo tardi per inviare la formazione";
?> 
