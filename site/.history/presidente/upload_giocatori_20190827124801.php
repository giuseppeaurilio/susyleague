<?php

function parse_giocatori($filename) {
	
	if (($handle = fopen($filename, "r")) !== FALSE) {
		$data = fgetcsv($handle, 1000, ",");
		$counter = 1;
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			include("../dbinfo_susyleague.inc.php");
			$conn = new mysqli($localhost, $username, $password,$database);
			
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			try{
				
				
				$squadra=strtoupper($data[3]);
				$squadra_breve=substr($squadra,0,3);

				$queryfindsquadra = "SELECT * FROM `squadre_serie_a` WHERE squadra_breve='$squadra_breve'";
				$idsquadra = 0;
				// echo "Squadra = " . $squadra . " " . $squadra_breve;
				$resultfindsquadra  = $conn->query($queryfindsquadra);
				if($resultfindsquadra->num_rows == 0)
				{
					$queryinsertsquadra="INSERT INTO `squadre_serie_a`(`squadra`, `squadra_breve`, 'id') VALUES ('$squadra','$squadra_breve', $counter)";
					$result=$conn->query($queryinsertsquadra); 
					echo $counter." ".$squadra;
					if ($result==1) echo " OK"; else echo " ERROR";
					echo "<br>";
					$idsquadra = $counter;
					$counter++;
				}
				else{
					while ($row = $result->fetch_assoc()) {
						$idsquadra = $row["id"];
					}
				}
				
				$nome = preg_replace("/[^\w]/", '', $data[2]);
				$queryfindgiocatore = "SELECT * FROM `giocatori` WHERE nome='$nome'";

				$resultfindgiocaotre  = $conn->query($queryfindgiocatore);
				if($resultfindgiocaotre->num_rows == 0)
				{
					$queryinsertgiocatore="INSERT INTO `giocatori`(`id`, `ruolo`,`nome`,`id_squadra` ) SELECT $data[0],'$data[1]','$nome',$idsquadra 
					from squadre_serie_a where `squadra_breve`='$squadra_breve'";

					$result=$conn->query($queryinsertgiocatore); 
					echo $nome;
					if ($result==1) echo " OK"; else echo " ERROR";
					echo "<br>";
				}
			}
			catch(Exception $e) {
				echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
			finally{
				$conn->close();
			}
			
		}
		fclose($handle);
	}

// inserisci squadre nel database
// inserisci giocatori nel database dove squadra nome viene sostituito da squadra id
}
	
$target_file =  "giocatori_sere_A.csv";
//echo "target_file =". $target_file;
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

if($imageFileType != "csv" ) {
    echo "Errore, solo file .csv sono possibili";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Errore, il file non e'stato caricato perche not ok.";
// if everything is ok, try to upload file
} 
else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		include("../dbinfo_susyleague.inc.php");
		$conn = new mysqli($localhost, $username, $password,$database);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		try{
			echo "Il file ". basename( $_FILES["fileToUpload"]["name"]). " e' stato caricato.";
			echo'<br>';
			$query="Truncate `squadre_serie_a`";
			$result=$conn->query($query);
			echo'Squadre cancellati; <br>';

			$query="Truncate `giocatori`";
			$result=$conn->query($query);
			echo'Giocatori cancellati; <br>';
			parse_giocatori($target_file);
			
			$query="INSERT INTO `squadre_serie_a` (`squadra`, `squadra_breve`) VALUES ('ZVINCOLATI', 'SVI')";
			
			$result=$conn->query($query);	
		}
		catch(Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
		finally{
			$conn->close();
		}	
    } else {
        echo "Errore, il file non e'stato caricato per un problema di scrittura.";
    }
}
?>
