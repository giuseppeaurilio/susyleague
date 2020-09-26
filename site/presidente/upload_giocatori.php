<?php

function parse_giocatori($filename) {
	
	if (($handle = fopen($filename, "r")) !== FALSE) {
		// $data = fgetcsv($handle, 1000, ",");
		$countersquadre = 0;
		$countergiocatori = 0;
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			// print_r($data);
			include("../dbinfo_susyleague.inc.php");
			$conn = new mysqli($localhost, $username, $password,$database);
			
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			try{
				
				if(is_numeric($data[0])){
					$squadra=strtoupper($data[3]);
					$squadra_breve=substr($squadra,0,3);

					$queryfindsquadra = "SELECT * FROM `squadre_serie_a` WHERE squadra_breve='$squadra_breve'";
					// $idsquadra = 0;
					// echo "Squadra = " . $squadra . " " . $squadra_breve;
					$resultfindsquadra  = $conn->query($queryfindsquadra) or die($conn->error);
					if($resultfindsquadra->num_rows == 0)
					{
						// $queryinsertsquadra="INSERT INTO `squadre_serie_a`(`squadra`, `squadra_breve`, `id`) VALUES ('$squadra','$squadra_breve', $counter)";
						$queryinsertsquadra="INSERT INTO `squadre_serie_a`(`squadra`, `squadra_breve`) VALUES ('$squadra','$squadra_breve')";
						$result=$conn->query($queryinsertsquadra) or die($conn->error);; 
						$idsquadra = $conn->insert_id;
						// echo $idsquadra." ".$squadra;
						
						if ($result==1) $countersquadre++; else echo " ERROR" . mysqli_error($conn) ;
						// echo "<br>";
						// $idsquadra = $counter;
						// $counter++;
					}
					else{
						// echo $queryfindsquadra;
						// print_r($resultfindsquadra) ;
						// echo "<br>";
						while ($row = $resultfindsquadra->fetch_assoc()) {
							$idsquadra = $row["id"];
						}
					}
					
					$nome = preg_replace("/[^A-Za-z0-9 -]/", '', $data[2]);
					$queryfindgiocatore = "SELECT * FROM `giocatori` WHERE nome='$nome'";

					$resultfindgiocaotre  = $conn->query($queryfindgiocatore);
					if($resultfindgiocaotre->num_rows == 0)
					{
						$queryinsertgiocatore="INSERT INTO `giocatori`(`id`, `ruolo`,`nome`,`id_squadra`, `quotazione` ) SELECT $data[0],'$data[1]','$nome',$idsquadra, $data[4]
						from squadre_serie_a where `squadra_breve`='$squadra_breve'";

						$result=$conn->query($queryinsertgiocatore); 
						// echo '<br/>' . $queryinsertgiocatore;
						if ($result==1) $countergiocatori++; else echo " ERROR";
						// echo "<br>";
					}
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

		echo " Procedura completata. Inserite " .$countersquadre. "squadre e ".$countergiocatori." giorcatori.";
	}

// inserisci squadre nel database
// inserisci giocatori nel database dove squadra nome viene sostituito da squadra id
}

function update_giocatori($filename) {
	
	if (($handle = fopen($filename, "r")) !== FALSE) {
		// $data = fgetcsv($handle, 1000, ",");
		$countersquadre = 0;
		$countergiocatori = 0;
		
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			// print_r($data);
			include("../dbinfo_susyleague.inc.php");
			$conn = new mysqli($localhost, $username, $password,$database);
			
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			try{
				if(is_numeric($data[0])){
					//cerco la squadra di destinazione
					$squadra=strtoupper($data[3]);
					$squadra_breve=substr($squadra,0,3);

					$queryfindsquadra = "SELECT * FROM `squadre_serie_a` WHERE squadra_breve='$squadra_breve'";
					// $idsquadra = 0;
					// echo "Squadra = " . $squadra . " " . $squadra_breve;
					$resultfindsquadra  = $conn->query($queryfindsquadra) or die($conn->error);
					if($resultfindsquadra->num_rows == 0)
					{
						//la squadra del giocatore non è di seria a
						$queryfindsquadra = "SELECT * FROM `squadre_serie_a` WHERE squadra_breve='SVI'";
						$resultfindsquadra  = $conn->query($queryfindsquadra) or die($conn->error);
					}
					//se non trovo la squadra di destinazione ho un problema.
					if($resultfindsquadra->num_rows == 0)
					{
						throw exception($resultfindsquadra);
					}
					else{
						while ($row = $resultfindsquadra->fetch_assoc()) {
							$idsquadra = $row["id"];
						}
					}
					
					//cerco il giocatore
					$queryfindgiocatore = "SELECT * FROM `giocatori` WHERE `id`=$data[0]";
					$resultfindgiocaotre  = $conn->query($queryfindgiocatore);
					//se non ho trovato il gicatore, faccio l'insert
					if($resultfindgiocaotre->num_rows == 0)
					{
						$nome = preg_replace("/[^A-Za-z0-9 -]/", '', $data[2]);
						$queryinsertgiocatore="INSERT INTO `giocatori`(`id`, `ruolo`,`nome`,`id_squadra`, `quotazione` ) values ($data[0],'$data[1]', '$nome', $idsquadra, $data[4] ";

						$result=$conn->query($queryinsertgiocatore); 
						if ($result==1) $countergiocatori++; else echo " ERROR";
						// echo $queryinsertgiocatore . "<br/>";
						// echo "<br>";
					}
					//se ho trovato il giocatore faccio l'update della squadra_serie_a
					else{
						$queryupdategiocatore="UPDATE `giocatori` SET `id_squadra`=$idsquadra WHERE `id`=$data[0]";
						$result=$conn->query($queryupdategiocatore); 
						if ($result==1) $countergiocatori++; else echo " ERROR";
						// echo $queryupdategiocatore. "<br/>";
					}
					
					$squadra=strtoupper($data[3]);
					$squadra_breve=substr($squadra,0,3);

					$queryfindsquadra = "SELECT * FROM `squadre_serie_a` WHERE squadra_breve='$squadra_breve'";
					// $idsquadra = 0;
					// echo "Squadra = " . $squadra . " " . $squadra_breve;
					$resultfindsquadra  = $conn->query($queryfindsquadra) or die($conn->error);
					if($resultfindsquadra->num_rows == 0)
					{
						//la squadra del giocatore non è di seria a
						$queryfindsquadra = "SELECT * FROM `squadre_serie_a` WHERE squadra_breve='SVI'";
						$resultfindsquadra  = $conn->query($queryfindsquadra) or die($conn->error);
					}
					//la squadra del giocatore è di seria a
					while ($row = $resultfindsquadra->fetch_assoc()) {
						$idsquadra = $row["id"];
					}
					
					
					$nome = preg_replace("/[^A-Za-z0-9 -]/", '', $data[2]);
					$queryfindgiocatore = "SELECT * FROM `giocatori` WHERE nome='$nome'";

					$resultfindgiocaotre  = $conn->query($queryfindgiocatore);
					if($resultfindgiocaotre->num_rows == 0)
					{
						$queryinsertgiocatore="INSERT INTO `giocatori`(`id`, `ruolo`,`nome`,`id_squadra`, `quotazione` ) SELECT $data[0],'$data[1]','$nome',$idsquadra, $data[4]
						from squadre_serie_a where `squadra_breve`='$squadra_breve'";

						$result=$conn->query($queryinsertgiocatore); 
						// echo $nome;
						if ($result==1) $countergiocatori++; else echo " ERROR";
						// echo "<br>";
					}
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

		echo " Procedura completata. Inserite " .$countersquadre. " squadre e ".$countergiocatori." giorcatori.";
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
			if(isset($_POST['cbCancella']) && $_POST['contratto'] = "si" )
			{
				//inserimento squadre e rose ex novo
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
			else
			{
				//update rose
				update_giocatori($target_file);
			}
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
