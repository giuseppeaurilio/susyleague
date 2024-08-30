
<?php
include_once ("../send_message_post.php");
// include("../dbinfo_susyleague.inc.php");
// mysql_connect($localhost,$username,$password);
// @mysql_select_db($database) or die( "Unable to select database");ù
include_once  ("../dbinfo_susyleague.inc.php");
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}


if (isset($_POST['id_giornata']))
	{
	$id_giornata=$_POST['id_giornata'];
	}	
	
	
if(isset($_POST['calcolo']) && $_POST['calcolo'] == '1') 
	{
		send_message_post("Il presidente ha appena fatto il conteggio della giornata $id_giornata");
		echo "messaggio calcolo giornata $id_giornata inviato";
		echo "</br>";
	}
	
if(isset($_POST['risultati']) && $_POST['risultati'] == '1') 
	{
		$query2="SELECT b.squadra as sq_casa, c.squadra as sq_ospite, d.gol_casa, d.gol_ospite, d.voto_casa, d.voto_ospite  
		FROM calendario as a 
		inner join sq_fantacalcio as b on a.id_sq_casa=b.id inner join sq_fantacalcio as c on a.id_sq_ospite=c.id 
		left join punteggio_finale as d on a.id_giornata=d.id_giornata and a.id_partita=d.id_partita where a.id_giornata=". $id_giornata ." order by a.id_partita";
//		echo $query2;
		// $result_giornata=mysql_query($query2);
		$result_giornata  = $conn->query($query2) or die($conn->error);
		// $num_giornata=mysql_numrows($result_giornata);
		// $num_giornata=$result_giornata->count();
		$j=0;
		$testo="RISULTATI GIORNATA $id_giornata\n\n";
		// while ($j < $num_giornata) 
		while ($row=$result_giornata->fetch_assoc()) {
		{
			$punti_casa="";
			$gol_casa="";
			$gol_ospite="";
			$punti_ospite="";

			// $sq_casa=mysql_result($result_giornata,$j,"sq_casa");
			// $sq_ospite=mysql_result($result_giornata,$j,"sq_ospite");
			// $punti_casa=mysql_result($result_giornata,$j,"voto_casa");
			// $gol_casa=mysql_result($result_giornata,$j,"gol_casa");
			// $gol_ospite=mysql_result($result_giornata,$j,"gol_ospite");
			// $punti_ospite=mysql_result($result_giornata,$j,"voto_ospite");

			$sq_casa=$row["sq_casa"];
			$sq_ospite=$row["sq_ospite"];//mysql_result($row,$j,"sq_ospite");
			$punti_casa=$row["voto_casa"];//mysql_result($row,$j,"voto_casa");
			$gol_casa=$row["gol_casa"];//mysql_result($row,$j,"gol_casa");
			$gol_ospite=$row["gol_ospite"];//mysql_result($row,$j,"gol_ospite");
			$punti_ospite=$row["gol_ospite"];//mysql_result($row,$j,"gol_ospite");

			$testo.= "$sq_casa $gol_casa ($punti_casa) \n$sq_ospite $gol_ospite ($punti_ospite)\n";
			
			$testo .= "____________________________\n";
			++$j;
		}
		$testo.=  "\nI risultati della giornata $id_giornata sono disponibili qui http://susyleague.000webhostapp.com/display_giornata.php?&id_giornata=$id_giornata";
		send_message_post($testo);
//		echo "messaggio $testo \n";
		echo "messaggio risultati invato";
		echo "</br>";

	}
if(isset($_POST['classifiche']) && $_POST['classifiche'] == '1') 
	{
		send_message_post("Le classifiche alla giornata $id_giornata sono disponibili qui http://susyleague.000webhostapp.com/display_classifiche.php");
		echo "messaggio con link alle classifiche inviato";
		echo "</br>";
	}
mysql_set_charset("UTF8");
	
if(isset($_POST['commento']) && $_POST['commento'] == '1') 
	{
		$query="select * from giornate where id_giornata=". $id_giornata;

		$result_commento=mysql_query($query);
		#$num_commento=mysql_numrows($result_commento);
		$commento=mysql_result($result_commento,0,"commento");
		
		if ($commento<>"")
		{

			$testo = "Commento del presidente:\n$commento";
//			echo $testo;
			send_message_post($testo);
			echo "Messaggio con commento inviato";
		}	

		echo "</br>";
	}

?>
