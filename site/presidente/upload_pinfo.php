<?php
//  if(isset($_POST['submitPInfo'])){
// 	// echo 'is set <br>';
// 		if(!empty($_POST['AnnoStats'])) {
// 			$anno = $_POST['AnnoStats'];	
// 		} 
// 	}
// echo 'anno: ' .$anno  . '<br>';
// $anno=$_POST['AnnoStats'];
// echo 'Giornata ' .$idgiornata .'<br/>';

function parse_pinfo($filename) {
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

					$queryresetVoti = "DELETE FROM `giocatori_pinfo` 
					where `giocatore_id`=$data[0] ";
					$result=$conn->query($queryresetVoti);// or die($conn->error);
					if(!$result)
					{
						echo 'Reset stats fallito: `giocatore_id`='.$data[0] .'; <br>';
					}
					$ia = "NULL";
					if(!empty($data[7]))
					{$ia = $data[7];}

					$tit = "NULL";
					if(!empty($data[8]))
					{$tit = $data[8];}

					$cr = "NULL";
					if(!empty($data[9]))
					{$cr = $data[9];}

					$cp = "NULL";
					if(!empty($data[10]))
					{$cp = $data[10];}
					
					$ca = "NULL";
					if(!empty($data[11]))
					{$ca = $data[11];}

					$is = "NULL";
					if(!empty($data[12]))
					{$is = $data[12];}

					$f = "NULL";
					if(!empty($data[13]))
					{$f = $data[13];}

					$queryInsertStats = "INSERT INTO `giocatori_pinfo`(
						`giocatore_id`, 
						`ia`,
						`titolarita`,
						`cr`,
						`cp`,
						`ca`,
						`is`,
						`f`,
						`note`
						) 
						VALUES (
						$data[0],
						$ia,
						$tit,
						$cr,
						$cp,
						$ca,
						$is,
						$f,
						'$data[14]')";

					// echo $queryInsertStats. '<br>';
					$result=$conn->query($queryInsertStats); //or die($conn->error);
					if($result) {
						$countervoti++; 
					}
					else {
						echo " ERROR ". $data[0] . '-'.$data[2]  . ($conn->error) .'<br>';
						echo $queryInsertStats;
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
    if (move_uploaded_file($_FILES["fileToUploadPInfo"]["tmp_name"], $target_file)) {
		include("../dbinfo_susyleague.inc.php");
		$conn = new mysqli($localhost, $username, $password,$database);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		try{
			parse_pinfo($target_file);	
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
