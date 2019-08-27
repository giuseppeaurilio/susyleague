<?php

function parse_giocatori($filename) {
	$row = 1;
	if (($handle = fopen($filename, "r")) !== FALSE) {
		$data = fgetcsv($handle, 1000, ",");
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
				$queryinsertsquadra="INSERT INTO `squadre_serie_a`(`squadra`, `squadra_breve`) VALUES ('$squadra','$squadra_breve')";

				// echo "Squadra = " . $squadra . " " . $squadra_breve;
				$resultfindsquadra  = $conn->query($queryfindsquadra);
				if($resultfindsquadra->num_rows == 0)
				{
					$result=$conn->query($queryinsertsquadra); 
					echo $squadra;
					if ($result==1) echo " OK"; else echo " ERROR";
				}
				echo "<br>";
				
				$queryfindgiocatore = "SELECT * FROM `giocatori` WHERE nome='$data[2]'";
				$queryinsertgiocatore="INSERT INTO `giocatori`(`id`, `ruolo`,`nome`,`id_squadra` ) SELECT $data[0],'$data[1]','$data[2]',id from squadre_serie_a where `squadra_breve`='$squadra_breve'";

				$resultfindgiocaotre  = $conn->query($queryfindgiocatore);
				if($resultfindgiocaotre->num_rows == 0)
				{
					$result=$conn->query($queryinsertgiocatore); 
					echo $data[2];
					if ($result==1) echo " OK"; else echo " ERROR";
				}

				echo "<br>";
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
			$query="Truncate `giocatori`";
			echo $query;
			$result=$conn->query($query);

			$query="Truncate `squadre_serie_a`";
			echo $query;
			$result=$conn->query($query);

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
