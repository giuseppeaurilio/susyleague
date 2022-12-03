<?php

function update_giocatori($filename) {
	
	if (($handle = fopen($filename, "r")) !== FALSE) {
		// $data = fgetcsv($handle, 1000, ",");
		$countersquadre = 0;
		$countergiocatori = 0;
		// include_once ("../dbinfo_susyleague.inc.php");
		// if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
		
		// // Check connection
		// if ($conn->connect_error) {
		// 	die("Connection failed: " . $conn->connect_error);
		// }
		include_once("../dbinfo_susyleague.inc.php");
    	$conn = getConnection();
		$queryfindsquadra = "SELECT * FROM `squadre_serie_a` WHERE squadra_breve='SVI'";
		$resultfindsquadra  = $conn->query($queryfindsquadra) or die($conn->error);
		if($resultfindsquadra->num_rows == 0)
		{
			throw exception($resultfindsquadra);
		}
		else{
			while ($row = $resultfindsquadra->fetch_assoc()) {
				$idsquadra = $row["id"];
			}
		}

		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {			
			try{
				if(is_numeric($data[0])){
					
					
					//cerco il giocatore
					$queryfindgiocatore = "SELECT * FROM `giocatori` WHERE `id`=$data[0]";
					$resultfindgiocaotre  = $conn->query($queryfindgiocatore);
					//se non ho trovato il gicatore, faccio l'insert
					if($resultfindgiocaotre->num_rows == 0)
					{
						$nome = preg_replace("/[^A-Za-z0-9 -]/", '', $data[3]);
						$queryinsertgiocatore="INSERT INTO `giocatori`(`id`, `ruolo`,`nome`,`id_squadra`, `quotazione`,  `ruolo_mantra` ) values ($data[0],'$data[1]', '$nome', $idsquadra, $data[5], '$data[2]' )";
						echo $queryinsertgiocatore ."<br>";
						$result=$conn->query($queryinsertgiocatore); 
						if ($result==1) $countergiocatori++; else 
						{
							echo " ERROR insert";
							echo $queryinsertgiocatore . "<br/>";
						}
						// echo "<br>";
					}
					//se ho trovato il giocatore faccio l'update della squadra_serie_a
					else{
						$queryupdategiocatore="UPDATE `giocatori` SET `id_squadra`=$idsquadra , `quotazione` = $data[5] WHERE `id`=$data[0]";
						echo $queryupdategiocatore ."<br>";
						$result=$conn->query($queryupdategiocatore); 
						if ($result==1) $countergiocatori++; 
							else 
							{echo " ERROR 1". $conn->error;
							 echo $queryupdategiocatore. "<br/>";
							}
					}
				}
				// else
				// {
				// 	echo "not numeric: " . $data[0]. "<br>";
				// }
			}
			catch(Exception $e) {
				echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
			// finally{
			// 	$conn->close();
			// }
			
		}
		fclose($handle);

		echo " Procedura completata. Update di " .$countergiocatori." giorcatori.";
	}

// inserisci squadre nel database
// inserisci giocatori nel database dove squadra nome viene sostituito da squadra id
}
	
$target_file =  "giocatori_sere_A_svincolati.csv";
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
		// include_once ("../dbinfo_susyleague.inc.php");
		// if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
		// // Check connection
		// if ($conn->connect_error) {
		// 	die("Connection failed: " . $conn->connect_error);
		// }
		include_once("../dbinfo_susyleague.inc.php");
    	$conn = getConnection();
		try{
			echo "Il file ". basename( $_FILES["fileToUpload"]["name"]). " e' stato caricato.";
			echo'<br>';
				
			update_giocatori($target_file);
			
			echo'<br>';
				
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
