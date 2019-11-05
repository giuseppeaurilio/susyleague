<?php
$idgiornata=$_GET['idgiornata'];
// echo 'Giornata ' .$idgiornata .'<br/>';

function parse_voti($filename, $idgiornata) {
	// echo $filename;
	if (($handle = fopen($filename, "r")) !== FALSE) {
		// $data = fgetcsv($handle, 1000, ",");
		$countervoti = 0;
		$errormessage = "";
		try{
			include("../dbinfo_susyleague.inc.php");
			$conn = new mysqli($localhost, $username, $password,$database);
			
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}

			$queryresetVoti = 'UPDATE formazioni set voto = null, voto_md = null
			where id_giornata = '.$idgiornata;
			$result=$conn->query($queryresetVoti);// or die($conn->error);
			if(!$result)
			{
				echo 'Reset voti fallito: <br>';
				throw new Exception($conn->error);
			}
			else
				echo 'Reset voti ok.<br/>';

			$queryresetrisultati = 'UPDATE calendario 
			set gol_casa = null, gol_ospiti = null,
			punti_casa = null, punti_ospiti = null,
			md_casa = 0, md_ospite = 0,
			numero_giocanti_casa = 0, numero_giocanti_ospite = 0,
			fattorecasa = null
			where id_giornata = '.$idgiornata;
			$result=$conn->query($queryresetrisultati); //or die($conn->error);
			if(!$result)
			{
				// echo 'Reset risultati fallito: ' .$conn->error .'<br/>';
				echo 'Reset risultati fallito: <br>';
				throw new Exception($conn->error);
			}
			else
				echo 'Reset risultati ok. <br/>';

			$cod = 0;
			$voto = 0;
			$votof = 0;
			
			while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
				$int_value = ctype_digit($data[0]) ? intval($data[0]) : null;
				if ($int_value !== null && is_numeric($data[3]))
				{
					//[0]>Cod.	[1]>Ruolo	[2]>Nome	[3]>Voto	[4]>Gf	
					//[5]>Gs	[6]>Rp	[7]>Rs	[8]>Rf	[9]>Au	[10]>Amm	
					//[11]>Esp	[12]>Ass	[13]>Asf	[14]>Gdv	[15]>Gdp
					$cod = $data[0];
					// $voto = str_replace(',', '.', preg_replace("/[^0-9,]/", '',  $data[3]));
					$voto = str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $data[3]));
					// echo $data[3] ." ".$voto;
					// echo "<br>";
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
						// 	+ (1*$data[12]) //assist
						// 	+ (1*$data[13]) //assist da fermo
						case "P":
						case "D":
						case "C":
						case "A":
						$votof = $voto 
						+ (3 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $data[4])) )
						- (1 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $data[5])) )
						+ (3 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $data[6])) )
						- (3 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $data[7])) )
						+ (3 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $data[8])) )
						- (2 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $data[9]))  )
						- (0.5 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $data[10]))) 
						- (1 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $data[11])) )
						+ (1 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $data[12])) )
						+ (0.5 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $data[13])) )
							;
							break;
					}
					// echo print_r($data) .'<br>'; 
					if( $voto != 0 && $votof != '' ){
						$query = 'UPDATE `formazioni` 
						SET `voto`="'.$votof.'",`voto_md`="'.$voto.'"
						WHERE id_giornata= '.$idgiornata.' and id_giocatore = '.$cod.' '; 
								//  print_r ($query);
								//  echo '<br/> '; 
						$result=$conn->query($query) ;//or die($conn->error);
						if($result) {
							$countervoti++; 
							// echo $query .'<br>';
							// echo $result .'<br>';
							// echo $cod . '-'.$data[2] . '; voto: ' . $voto. ' fantavoto:  ' .$votof . '<br/> '; 
						}
						else {
							echo " ERROR ". $cod . '-'.$data[2]  . ($conn->error) .'<br>';
						}
					}
					else{
						echo "ERRORE: ". $cod . '-'.$data[2] .' . Il voto non è stato importato.<br>';
					}
				}
				else 
				{
					echo "Row skipped:";
					print_r($data);
					echo '<br>';
				}
			}
			echo " Procedura completata.<br/>";
			// echo " Si sono verificati i seguenti errori: " .$errormessage ."<br/>";
			echo " Inseriti " .$countervoti. " voti.";
		}
		catch(Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
		finally{
			$conn->close();
		}
		fclose($handle);
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
