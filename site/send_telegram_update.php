<?php

include_once ('send_message_post.php');

function send_telegram_update() {

	$avvisi=[24, 6, 1];
	//$avvisi=range(0,150);

	date_default_timezone_set('Europe/Rome');
	$adesso=date('Y-m-d H:i:s');
	// echo date("Y-m-d H:i:s") . '<br>';
	// $adesso_date = strtotime($adesso);

	// include_once ("dbinfo_susyleague.inc.php");
	// mysql_connect($localhost,$username,$password);
	// @mysql_select_db($database) or die( "Unable to select database");
	// $conn = new mysqli($localhost, $username, $password,$database);

	// // Check connection
	// if ($conn->connect_error) {
	// 	die("Connection failed: " . $conn->connect_error);
	// }

	include_once("DB/serie_a.php");
    include_once("DB/fantacalcio.php");
    include_once "DB/calendario.php";
    
    $giornatasa = seriea_getGiornataProssima();
	print_r($giornatasa);
	// $query="select * from giornate where  fine > '" . $adesso ."'";
	// #echo "<br>query_data=" . $query;
	// // $result=mysql_query($query);
	// // $num=mysql_numrows($result); 
	// $result=$conn->query($query);
	// echo $query;

	// $i=0;
	// while ($i < $num) {
	if($giornatasa != null){

		$inizio=$giornatasa["inizio"];//mysql_result($result,$i,"fine");
		// $fine_date=strtotime($fine);
		// $giornata=$giornatasa["id_giornata"];//mysql_result($result,$i,"id_giornata");
		echo "<br>inizio=" . $inizio;
		echo "<br>adesso=" . date("Y-m-d H:i:s");
		echo "<br>giornata=" . $giornatasa["descrizione"];
		// echo 
		$strinizio = strtotime($inizio);
		$stradesso = strtotime($adesso);
		// echo $strin
		$diff=($strinizio-$stradesso)/3600;
		 echo "<br> mancano " . $diff ."<br>";
		foreach ($avvisi as $value) 
		{
			
			
			if (($diff<$value) and ($diff>$value-1))
			{
				$giornatefc = fantacalcio_getGiornate_bySerieAId($giornatasa["id"]);
				foreach ($giornatefc as $giornatafc) 
				{
					// echo "<br> trovato";
					include_once "DB/calendario.php";
					$descrizioneGiornata = getDescrizioneGiornata($giornatafc["id_giornata"]);
					$testo="AVVISO: Mancano meno di $value ore alla chiusura delle partite $descrizioneGiornata. \n\n";
					// $testo="AVVISO: Mancano meno di $value ore alla chiusura della giornata $giornata. \n\n";

					// $query_ni="SELECT * FROM sq_fantacalcio 
					// where id  in (
					// 	select distinct id_sq_casa from calendario where id_giornata=".$giornatasa["id"] ."
					// 	union 
					// 	select distinct id_sq_ospite from calendario where id_giornata=".$giornatasa["id"]."
					// ) 
					// and id not in (select distinct id_squadra from formazioni where id_giornata=".$giornatasa["id"].")";
					// $result_ni=mysql_query($query_ni);
					// $num_ni=mysql_numrows($result_ni); 
					// $result_ni=$conn->query($query_ni);
					// $num_ni=$result_ni->num_rows; 
					//echo "num_ni= $num_ni";
					$squadresenzaformazione = fantacalcio_getSquadreSenzaFormazione($giornatafc["id_giornata"]);
					if (count($squadresenzaformazione)==2) 
					{
						// echo "Tutte le squadre hanno inviato le formazioni";
						$testo .= "Tutte le squadre hanno inviato la formazione";
					}
					else
					{
						$testo .= "Le squadre ";
						echo $testo;		
						foreach($squadresenzaformazione as $squadra)
						{
							$testo .= " ". $squadra["squadra"].", " ;
						}
						// while ($row=$result_ni->fetch_assoc()) {
						// 	$squadra=$row["squadra"];//mysql_result($result_ni,$j,"squadra");
						// 	//echo "squadra $j";
						// 	$testo .= "$squadra, ";
						// 	// ++$j;
						// }
						$testo .= " devono ancora inviare la formazione.\n\n Possono farlo qui: https://www.susyleague.it/invio_formazione.php";
							
					}
					// echo "<br>".$testo;	
					$a=send_message_post($testo);
					// echo "messaggio inviato";
				}
			}
		}
	}
	// $testo = "this is a test message";
	// echo $testo;
	// $a=send_message_post($testo);
}

?>
