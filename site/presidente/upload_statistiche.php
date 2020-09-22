<?php
 if(isset($_POST['submitStats'])){
	// echo 'is set <br>';
		if(!empty($_POST['AnnoStats'])) {
			$anno = $_POST['AnnoStats'];	
		} 
	}
// echo 'anno: ' .$anno  . '<br>';
// $anno=$_POST['AnnoStats'];
// echo 'Giornata ' .$idgiornata .'<br/>';

function parse_stats($filename, $anno) {
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

			
			while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
				$int_value = ctype_digit($data[0]) ? intval($data[0]) : null;
				if ($int_value !== null){

					$queryresetVoti = "DELETE FROM `giocatori_statistiche` 
					where `giocatore_id`=$data[0] AND `anno`='$anno'";
					$result=$conn->query($queryresetVoti);// or die($conn->error);
					if(!$result)
					{
						echo 'Reset stats fallito: `giocatore_id`='.$data[0] .'AND `anno`='.$anno.'; <br>';
					}
					$queryInsertStats = "INSERT INTO `giocatori_statistiche`(
						`giocatore_id`, 
						`anno`, 
						`pg`, 
						`mv`, 
						`mf`, 
						`gf`, 
						`gs`, 
						`rp`, 
						`rc`, 
						`r+`, 
						`r-`, 
						`ass`, 
						`asf`, 
						`amm`, 
						`esp`, 
						`au`) 
						VALUES (
						$data[0],
						'$anno',
						$data[4],
						".str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $data[5])).",
						".str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $data[6])).",
						$data[7],
						$data[8],
						$data[9],
						$data[10],
						$data[11],
						$data[12],
						$data[13],
						$data[14],
						$data[15],
						$data[16],
						$data[17])";
					$result=$conn->query($queryInsertStats); //or die($conn->error);
					if($result) {
						$countervoti++; 
					}
					else {
						echo " ERROR ". $data[0] . '-'.$data[2]  . ($conn->error) .'<br>';
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

}
	
$target_file =  "giocatori_stats.csv";

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
    if (move_uploaded_file($_FILES["fileToUploadStats"]["tmp_name"], $target_file)) {
		include("../dbinfo_susyleague.inc.php");
		$conn = new mysqli($localhost, $username, $password,$database);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		try{
			parse_stats($target_file, $anno);	
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
