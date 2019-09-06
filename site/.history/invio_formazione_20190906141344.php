<?php

if(!isset($_SESSION)) 
{
	session_start();
}
date_default_timezone_set('Europe/Rome');

#$date1 = date_create_from_format('d-m-Y H:i:s', '18-08-2015 23:20:10');

$adesso = date('Y-m-d H:i:s');

#print_r($adesso);

include_once ("dbinfo_susyleague.inc.php");

// Create connection
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";



$query_giornate="SELECT * from giornate where inizio <' " . $adesso ." ' and fine >'" . $adesso . "'";


$result_giornate=$conn->query($query_giornate);

$num_giornate=$result_giornate->num_rows;
// echo $adesso;
// print_r($result_giornate);
if ($num_giornate>0) {

	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	$allenatore="";
	header ("Location: login.php?&caller=invio_formazione.php");
	}
	else { 
	$allenatore= $_SESSION['allenatore'];
	$id_squadra= $_SESSION['login'];
	}
	
	include("menu.php");
    
    ?>
    <style>
	table td:nth-child(1) {  
		text-align:right;
	}
	</style>
	
    <?php
	//echo "allenatore=" . $allenatore;
	$i=0;
	while ($row=$result_giornate->fetch_assoc()) {

		$id=$row["id_giornata"];
		$inizio=$row["inizio"];
		$fine=$row["fine"];
		$query2="SELECT a.id_sq_casa as id_casa, a.id_sq_ospite as id_ospite, b.squadra as sq_casa, c.squadra as sq_ospite, a.gol_casa, a.gol_ospiti, a.punti_casa, a.punti_ospiti FROM calendario as a inner join sq_fantacalcio as b on a.id_sq_casa=b.id inner join sq_fantacalcio as c on a.id_sq_ospite=c.id where a.id_giornata=".$id ." order by a.id_partita" ;
		#echo $query2;
		$result_giornata=$conn->query($query2);
		$num_giornata=$result_giornata->num_rows;

		?>
		<?php
		$descrizioneGiornata = ""
		?>
		<h2><?php echo "Giornata " .$descrizioneGiornata;?></h2>
		<h3><?php echo $inizio ."  -->  " .$fine ;?></h3>
		<table>
					<tr>
						<th>CASA</th>
						<th>TRASFERTA</th>
					</tr>
		<?php
		$j=0;
		while ($row=$result_giornata->fetch_assoc()) {
			$id_casa=$row["id_casa"];
			$id_ospite=$row["id_ospite"];
			$punti_casa=$row["punti_casa"];
			$gol_casa=$row["gol_casa"];
			$sq_casa=$row["sq_casa"];
			$sq_ospite=$row["sq_ospite"];
			$gol_ospite=$row["gol_ospiti"];
			$punti_ospite=$row["punti_ospiti"];
			$link="invio_formazione_squadra.php"
			?>
			<!-- <ul id="squadre"> -->
				
			<tr>
				<?php
				if ($id_squadra==$id_casa) {
					// echo '<li><a href="'. $link . '?&id_giornata=' .$id . '&id_squadra=' . $id_casa . '">'. $sq_casa .'</a></li>';
					echo '<td><a href="'. $link . '?&id_giornata=' .$id . '&id_squadra=' . $id_casa . '">'. $sq_casa .'</a></td>';
				}
				else {
					// echo '<li>' .$sq_casa .'</li>';
					echo '<td>' .$sq_casa .'</td>';
				}
				
				if ($id_squadra==$id_ospite) {
					// echo '<li><a href="'. $link . '?&id_giornata=' .$id . '&id_squadra=' . $id_ospite . '">'. $sq_ospite .'</a></li>';
					echo '<td><a href="'. $link . '?&id_giornata=' .$id . '&id_squadra=' . $id_ospite . '">'. $sq_ospite .'</a></td>';
				}
				else {
					// echo '<li>' .$sq_ospite .'</li>';
					echo '<td>' .$sq_ospite .'</td>';
				}
				?>
			</tr>
			
			<!-- </ul> -->
			<?php
			++$j;
		} 
		echo "</table>";
		++$i;
		} 

}
else
{
	include("menu.php");
	echo 'nessuna partita in programma';
}


?>
<?php
include("footer.html");

?>

</body>
</html>
