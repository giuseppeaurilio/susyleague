<?php
include("menu.php");

?>
<?php

if(!isset($_SESSION)) 
{
	session_start();
}
$allenatore= "";
$id_squadra= "";
 if (isset($_SESSION['login']) && isset($_SESSION['allenatore']))
 {
	$allenatore= $_SESSION['allenatore'];
	$id_squadra= $_SESSION['login'];
 }
include_once("DB/serie_a.php");
include_once("DB/fantacalcio.php");
include_once "DB/calendario.php";

$giornatasa = seriea_getGiornataProssima();
if(!is_null($giornatasa))
{
	$date = date_create($giornatasa["inizio"]);
	echo '<h2 style="">Serie A '.$giornatasa["descrizione"].'</h2>';
	echo'<h3> Invia la formazione entro le '.date_format($date, 'H:i:s').' del '.date_format($date, 'd/m/Y').'</h3>';
		
	$giornatefc = fantacalcio_getPartite_bySerieAId($giornatasa["id"]);
	// print_r($giornatefc);
	$prev = "";
	$index=0;
	// print_r($giornatefc);
	foreach ($giornatefc as $giornatafc)
	{
		$descrizioneGiornata = getDescrizioneGiornata($giornatafc["id_giornata"]);
		if($prev == "")
		{
			
			// echo 'prev: '. $prev;
			$prev = $descrizioneGiornata;
			// echo 'last: '. $prev;
			echo '<div class="giornata">';
			
			echo '<h2 style="">'.$descrizioneGiornata.'</h2>';
			echo '<table style="width:100%">
					<tr>
						<th style="width:50%">CASA</th>
						<th style="width:50%">TRASFERTA</th>
					</tr>';
			
		}
		else if( $prev != $descrizioneGiornata)
		{
			echo '</table>';
			echo '</div>';
			$prev = $descrizioneGiornata;
			echo '<div class="giornata">';
			echo '<h2 style="">'.$descrizioneGiornata.'</h2>';
			echo '<table style="width:100%">
					<tr>
						<th style="width:50%">CASA</th>
						<th style="width:50%">TRASFERTA</th>
					</tr>';
			
		}

		
		$index++;
		$link="invio_formazione_squadra.php";
		if($index%2== 0)
			echo '<tr class="result">';
		else
			echo '<tr class="result alternate" >';
		if ($id_squadra != "" && $id_squadra==$giornatafc["id_sq1"]) {
			
			echo '<td style="background: lightgoldenrodyellow; text-align: right;"><a class="link" href="'. $link . '?&id_giornata=' 
			.$giornatafc["id_giornata"] . '&id_squadra=' .$giornatafc["id_sq1"] . '">'. $giornatafc["sq1"] .'</a></td>';
		}
		else {
			// echo '<li>' .$sq_casa .'</li>';
			echo '<td style=" text-align: right; ">' . $giornatafc["sq1"] .'</td>';
		}
		
		if ($id_squadra != "" && $id_squadra==$giornatafc["id_sq2"]) {
			echo '<td style="background: lightgoldenrodyellow;"><a class="link" href="'. $link . '?&id_giornata=' 
			.$giornatafc["id_giornata"] . '&id_squadra=' .$giornatafc["id_sq2"] . '">'. $giornatafc["sq2"] .'</a></td>';
		}
		else {
			// echo '<li>' .$sq_ospite .'</li>';
			echo '<td>' .$giornatafc["sq2"] .'</td>';
		}
		echo '</tr>';			
	}
	echo '</table>';
	echo '</div>';
	if($index == 0)
	{
		echo '<h3>Nessuna partita in programma</h3>';
	}
}
else
{
	echo 'nessuna partita in programma';	
}
?>

<?php 
include("footer.php");
?>
