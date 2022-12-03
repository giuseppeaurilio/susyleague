
<?php 
include_once ("menu.php");
?>


<?php 
include_once("../DB/serie_a.php");
include_once("../DB/fantacalcio.php");
include_once "../DB/calendario.php";

$giornatasa = seriea_getGiornataUltima();
if(!is_null($giornatasa))
{
	$giornatefc = fantacalcio_getPartite_bySerieAId($giornatasa["id"]);
    echo "<h2>Elenco partite della ".$giornatasa["descrizione"]." di Serie A</h2>";
    echo '<h3><a class="link" style="color: white;" href="./amministra_voti.php?giornata_serie_a_id='.$giornatasa["id"].'">Inserisci Voti</a></h3>';
    $prev = "";
	$index=0;
    // print_r ($giornatefc);
    $link="calcola_giornata.php";
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
            echo '<h3><a class="link" style="color: white;" href="'. $link . '?&id_giornata='.$giornatafc["id_giornata"] . '&id_girone=' .$giornatafc["id_girone"] . '">Calcola risultati</a></h3>';
			echo '<table style="width:100%">
					<tr>
                    <th style="width:45%">CASA</th>
                    <th style="width:auto; ">&nbsp;</th>
                    <th style="width:45%">TRASFERTA</th>
					</tr>';
			
		}
		else if( $prev != $descrizioneGiornata)
		{
			echo '</table>';
			echo '</div>';
			$prev = $descrizioneGiornata;
			echo '<div class="giornata">';
			echo '<h2 style="">'.$descrizioneGiornata.'</h2>';
            echo '<h3><a class="link" style="color: white;" href="'. $link . '?&id_giornata='.$giornatafc["id_giornata"] . '&id_girone=' .$giornatafc["id_girone"] . '">Calcola risultati</a></h3>';
			echo '<table style="width:100%">
					<tr>
                    <th style="width:45%">CASA</th>
                    <th style="width:auto;">&nbsp;</th>
                    <th style="width:45%">TRASFERTA</th>
					</tr>';
			
		}

		
		$index++;
		
		if($index%2== 0)
			echo '<tr class="result">';
		else
			echo '<tr class="result alternate" >';
		// if ($id_squadra != "" && $id_squadra==$giornatafc["id_sq1"]) {
			
		// 	echo '<td style="background: lightgoldenrodyellow; text-align: right;"></td>';
		// }
		// else {
        echo '<td style=" text-align: right; ">' . $giornatafc["sq1"] .'</td>';
        echo '<td style="text-align:center;">'.$giornatafc["gol_casa"].'-'.$giornatafc["gol_ospiti"].'</td>';
        echo '<td>' .$giornatafc["sq2"] .'</td>';
		
		echo '</tr>';			
	}
	echo '</table>';
    
  
	echo '</div>';
	if($index == 0)
	{
		echo '<h3>Nessuna partita in programma</h3>';
	}
}

?>
<?php 
include_once ("../footer.php");
?>
