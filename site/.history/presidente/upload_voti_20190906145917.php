<?php
$idgiornata=$_GET['idgiornata'];
// echo 'Giornata ' .$idgiornata .'<br/>';

function parse_voti($filename, $idgiornata) {
	// echo $filename;
	if (($handle = fopen($filename, "r")) !== FALSE) {
		// $data = fgetcsv($handle, 1000, ",");
		$countervoti = 0;
		
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			include("../dbinfo_susyleague.inc.php");
			$conn = new mysqli($localhost, $username, $password,$database);
			
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			try{
				// print_r($data[0]);
				// echo '<br/>'; 
				$int_value = ctype_digit($data[0]) ? intval($data[0]) : null;
				if ($int_value !== null)
					{
						$cod = 0;
						$voto = 0;
						$votof = 0;
						// print_r($data);
						// echo '<br/>'; 
						//[0]>Cod.	[1]>Ruolo	[2]>Nome	[3]>Voto	[4]>Gf	
						//[5]>Gs	[6]>Rp	[7]>Rs	[8]>Rf	[9]>Au	[10]>Amm	
						//[11]>Esp	[12]>Ass	[13]>Asf	[14]>Gdv	[15]>Gdp
						$cod = $data[0];
						$voto = str_replace(',', '.', preg_replace("/[^0-9,]/", '',  $data[3]));

						// echo 3*$data[4];
						switch($data[1])
						{
							// + (3*$data[4]) //gol fatti
							// 	- (1*$data[5]) //gol subiti
							// 	+ (3*$data[6]) //rigori parati
							// 	- (3*$data[7]) //rigori sbagliati
							// 	+ (3*$data[8]) //gol su rigore
							// 	- (3*$data[9]) //autogol
							// 	- (0.5*$data[10])//ammonizioni
							// 	- (0.5*$data[11])//espulsioni
							// 	+ (1*$data[12]) //assisst
							case "P":
							case "D":
							case "C":
							case "A":
							$votof = $voto 
							+ (3*$data[4]) 
							- (1*$data[5]) 
							+ (3*$data[6]) 
							- (3*$data[7])  
							+ (3*$data[8])
							- (2*$data[9]) 
							- (0.5*$data[10]) 
							- (1*$data[11]) 
							+ (1*$data[12]) 
								;
								break;
						}
						// echo $data[2] . ' ' .$cod . ' ' . $voto. ' ' .$votof . '<br/> '; 
						$query = 'UPDATE `formazioni` 
						SET `voto`='.$votof.',`voto_md`='.$voto.'
						WHERE id_giornata= '.$idgiornata.' and id_giocatore = '.$cod.' '; 
						//  print_r ($query);
						//  echo '<br/> '; 
						$result=$conn->query($query) or die($conn->error);
						if ($result==1) $countervoti++; else echo " ERROR" . mysqli_error($conn) ;
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

		echo " Procedura completata. Inserite " .$countervoti. "voti.";
	}

// inserisci squadre nel database
// inserisci giocatori nel database dove squadra nome viene sostituito da squadra id
}
	
// $target_file =  "giocatori_sere_A.csv";
$target_file =  "voti_giornata.csv";
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
			parse_voti($target_file, $idgiornata);	
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
