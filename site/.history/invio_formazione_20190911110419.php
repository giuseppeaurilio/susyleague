<?php
include("menu.php");

?>
<?php

if(!isset($_SESSION)) 
{
	session_start();
}
date_default_timezone_set('Europe/Rome');

#$date1 = date_create_from_format('d-m-Y H:i:s', '18-08-2015 23:20:10');

$adesso = date('Y-m-d H:i:s');

$query_giornate="SELECT * from giornate where inizio <' " . $adesso ." ' and fine >'" . $adesso . "'";


$result_giornate=$conn->query($query_giornate);

$num_giornate=$result_giornate->num_rows;
// echo $adesso;
// print_r($result_giornate);
if ($num_giornate>0) {

	// if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	// $allenatore="";
	// header ("Location: login.php?&caller=invio_formazione.php");
	// }
	// else { 
	// $allenatore= $_SESSION['allenatore'];
	// $id_squadra= $_SESSION['login'];
	// }
	$allenatore= "";
	$id_squadra= "";
	 if (isset($_SESSION['login']) && isset($_SESSION['allenatore']))
	 {
		$allenatore= $_SESSION['allenatore'];
		$id_squadra= $_SESSION['login'];
	 }
	// echo $allenatore;
	// echo "<br/>";
	// echo $id_squadra;
	// include("menu.php");
    
    ?>
    <style>
	table th:nth-child(1),
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
		$descrizioneGiornata = "";
		if($id <= 22)
		{ $descrizioneGiornata ="Campionato - Apertura. Giornata ". $id;}
		else if ($id>22 && $id<= 33)
		{ $descrizioneGiornata ="Campionato - Chiusura. Giornata ". $id - 22;}
		else if ($id>33 && $id<= 48)
		{ $descrizioneGiornata ="Coppa Italia - Girone Narpini. Giornata ". ($id );}
		else if ($id>48 && $id<= 63)
		{ $descrizioneGiornata ="Coppa Italia - Girone Gianluca. Giornata ". ($id );}//(floor(($id-48)/3) + 1);}
		else if ($id == 64 )
		{ $descrizioneGiornata ="Coppa Italia - Quarto 1 - Andata";}
		else if ($id == 65 )
		{ $descrizioneGiornata ="Coppa Italia - Quarto 1 - Ritorno";}

		else if ($id == 66 )
		{ $descrizioneGiornata ="Coppa Italia - Quarto 2 - Andata";}
		else if ($id == 67 )
		{ $descrizioneGiornata ="Coppa Italia - Quarto 2 - Ritorno";}

		else if ($id == 68 )
		{ $descrizioneGiornata ="Coppa Italia - Quarto 3 - Andata";}
		else if ($id == 69 )
		{ $descrizioneGiornata ="Coppa Italia - Quarto 3 - Ritorno";}

		else if ($id == 70 )
		{ $descrizioneGiornata ="Coppa Italia - Quarto 4 - Andata";}
		else if ($id == 71 )
		{ $descrizioneGiornata ="Coppa Italia - Quarto 4 - Ritorno";}

		else if ($id == 72 )
		{ $descrizioneGiornata ="Coppa Italia - Semifinale 1 - Andata";}
		else if ($id == 73 )
		{ $descrizioneGiornata ="Coppa Italia - Semifinale 1 - Ritorno";}

		else if ($id == 74 )
		{ $descrizioneGiornata ="Coppa Italia - Semifinale 2 - Andata";}
		else if ($id == 75 )
		{ $descrizioneGiornata ="Coppa Italia - Semifinale 2 - Ritorno";}

		else if ($id == 76 )
		{ $descrizioneGiornata ="Finale COPPA ITALIA";}
		else if ($id == 77 || $id == 78)
		{ $descrizioneGiornata ="Coppa delle coppe - Giornata" . ($id-76);}

		else if ($id == 79)
		{ $descrizioneGiornata ="Finale CAMPIONATO";}

		else if ($id == 79)
		{ $descrizioneGiornata ="SUPERCOPPA";}

		else
		{ $descrizioneGiornata ="mancante ".$id ;}



		?>
		<div class="giornata">
		<h2 style=""><?php echo $descrizioneGiornata;?></h2>
		<h3><?php echo (($inizio!= "") ? date('d/m H:i', strtotime($inizio)) : "") ."  ->  " .(($fine!= "") ? date('d/m H:i', strtotime($fine)) : "") ;?></h3>
		<table style="width:100%">
					<tr>
						<th style="width:50%">CASA</th>
						<th style="width:50%">TRASFERTA</th>
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
				if ($id_squadra != "" && $id_squadra==$id_casa) {
					// echo '<li><a href="'. $link . '?&id_giornata=' .$id . '&id_squadra=' . $id_casa . '">'. $sq_casa .'</a></li>';
					echo '<td><a href="'. $link . '?&id_giornata=' .$id . '&id_squadra=' . $id_casa . '">'. $sq_casa .'</a></td>';
				}
				else {
					// echo '<li>' .$sq_casa .'</li>';
					echo '<td>' .$sq_casa .'</td>';
				}
				
				if ($id_squadra != "" && $id_squadra==$id_ospite) {
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
		echo '</div>';
		++$i;
		} 

}
else
{
	// include("menu.php");
	echo 'nessuna partita in programma';
}


?>
<?php 
include("footer.php");
?>
