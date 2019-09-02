<?php

// include_once ('send_message_post.php');

function send_telegram_update() {

	$avvisi=[24,6,1];
	//$avvisi=range(0,150);

	date_default_timezone_set('Europe/Rome');
	$adesso=date('Y-m-d H:i:s');
	$adesso_date = strtotime($adesso);

	include_once ("dbinfo_susyleague.inc.php");
	// mysql_connect($localhost,$username,$password);
	// @mysql_select_db($database) or die( "Unable to select database");
	$conn = new mysqli($localhost, $username, $password,$database);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}


	$query="select * from giornate where  fine > '" . $adesso ."'";
	#echo "<br>query_data=" . $query;
	// $result=mysql_query($query);
	// $num=mysql_numrows($result); 
	$result=$conn->query($query);

	// $i=0;
	// while ($i < $num) {
	while ($row=$result->fetch_assoc()) {
		$fine=$row["fine"];//mysql_result($result,$i,"fine");
		$fine_date=strtotime($fine);
		$giornata=$row["id_giornata"];//mysql_result($result,$i,"id_giornata");
		echo "fine=" . $fine;
		echo "giornata=" . $giornata;
		$diff=($fine_date-$adesso_date)/3600;
		echo "mancano" . $diff;
		foreach ($avvisi as $value) 
		{
			//echo "check $value";
			if (($diff<$value) and ($diff>$value-1))
			{
				//echo "trovato";
				$testo="AVVISO: Mancano meno di $value ore alla chiusura della giornata $giornata. \n\n";
				$query_ni="SELECT * FROM sq_fantacalcio where id not in (select id_squadra from formazioni where id_giornata=$giornata)";
				// $result_ni=mysql_query($query_ni);
				// $num_ni=mysql_numrows($result_ni); 
				$result_ni=$conn->query($query_ni);
				$num_ni=$result_ni->num_rows; 
				//echo "num_ni= $num_ni";
				if ($num_ni==0) 
				{
					echo "Tutte le squadre hanno inviato le formazioni";
					//$testo .= "Tutte le squadre hanno inviato le formazioni";
				}
				else
				{
					$testo .= "Le squadre ";
					echo $testo;		
					// $j=0;
					// echo "pippo $num_ni";
					// while ($j < $num_ni) {
					while ($row=$result_ni->fetch_assoc()) {
						$squadra=$row["squadra"];//mysql_result($result_ni,$j,"squadra");
						//echo "squadra $j";
						$testo .= "$squadra, ";
						// ++$j;
					}
					$testo .= "devono ancora inviare la formazione.\n\n Possono farlo qui: http://susyleague.000webhostapp.com/invio_formazione.php";
					echo $testo;		
				}
			$a=send_message_post($testo);
			echo "messaggio inviato";
			}
		}
			
		// ++$i;
	}
	$conn->close();				
}

?>
