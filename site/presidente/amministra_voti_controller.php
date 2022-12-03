<?php 
header('Content-Type: text/html; charset=ISO-8859-1');
$action ="";
// include_once ("../dbinfo_susyleague.inc.php");
// // Create connection
// if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
include_once("../dbinfo_susyleague.inc.php");
$conn = getConnection();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $action = $_POST['action'];
    switch($action)
    {
        // case("upload"):
        //     $target_file =  "voti_giornata.csv";
        //     $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        //     $idgiornatasa = $_POST['idgiornatasa']  = '' ? null :$_POST['idgiornatasa'];
        //     //inserire controlli sugli input
        //     $retmessage= "";
        //     if($imageFileType != "csv" ) {
                
        //         // $uploadOk = 0;
        //         echo json_encode(array(
        //             'error' => array(
        //                 'msg' => "Errore, solo file .csv sono possibili",
        //                 // 'code' => $e->getCode(),
        //             ),
        //         ));
        //         break;
        //     }
        //     if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
        //     {
        //         $ret = parse_voti($target_file, $idgiornata);
        //     }
        //     if ($conn->query($query) === FALSE) {
        //         //throw exception
        //         echo $query;
        //     }
        //     echo json_encode(array(
        //         'result' => "true",
        //         'message' => $action." eseguito. " . $retmessage,
        //     ));
        //     break;
        case("getAll"):

            $idgiornatasa = $_POST['idgiornatasa']  = '' ? null :$_POST['idgiornatasa'];
            //inserire controlli sugli input
            $query= "SELECT gv.id as id,  g.id as g_id, g.nome,g.ruolo, sqa.squadra_breve, gv.voto, gv.voto_md, gv.giornata_serie_a_id
                    FROM `giocatori_voti` as gv
                    right join  `giocatori` as g on gv.giocatore_id = g.id
                    left join  `squadre_serie_a` as sqa  on sqa.id = g.id_squadra
                    WHERE `giornata_serie_a_id` = $idgiornatasa 
                    order by g.Nome asc ";
            // echo $query;
        
            $result=$conn->query($query);
            $voti = array();
            while ($row=$result->fetch_assoc()) {
                array_push($voti, array(
                    "id"=>$row["id"],
                    "g_id"=>$row["g_id"],
                    "nome"=>$row["nome"],
                    "ruolo"=>$row["ruolo"],
                    "squadra"=>$row["squadra_breve"],
                    "voto"=>$row["voto"],
                    "voto_md"=>$row["voto_md"],
                    "giornata_serie_a_id"=>$row["giornata_serie_a_id"],
                    )
                );
            }
            echo json_encode(array(
                'result' => "true",
                'message' => $action." eseguito",
                'voti' => $voti
            ));

           
            
            break;
        case("update"):
            $id = $_POST['id']  = '' ? null :$_POST['id'];
            $voto = $_POST['voto']  = '' ? null :$_POST['voto'];
            $fantavoto = $_POST['fantavoto']  = '' ? null :$_POST['fantavoto'];
            //inserire controlli sugli input
            $query= "UPDATE `giocatori_voti` 
            SET `voto`=$fantavoto,`voto_md`=$voto, `voto_ufficio`=true
            WHERE `id`=$id";
 
            if ($conn->query($query) === FALSE) {
                //throw exception
                echo $query;
            }
            echo json_encode(array(
                'result' => "true",
                'message' => $action." eseguito",
            ));
            
            break;
        case("delete"):
            $idgiornatasa = $_POST['idgiornatasa']  = '' ? null :$_POST['idgiornatasa'];
            //inserire controlli sugli input
            $query = 'DELETE FROM `giocatori_voti` WHERE `giornata_serie_a_id` = '.$idgiornatasa;

            if ($conn->query($query) === FALSE) {
                    //throw exception
                    echo $query;
                }
                echo json_encode(array(
                    'result' => "true",
                    'message' => $action." eseguito",
                ));
            break;
        case("inserisciVotoUfficio"):
            $idgiornatasa = $_POST['idgiornatasa']  = '' ? null :$_POST['idgiornatasa'];
            $idsquadra = $_POST['idsquadra']  = '' ? null :$_POST['idsquadra'];
            //inserire controlli sugli input
            $querydelete = 'DELETE FROM `giocatori_voti` 
            WHERE `giornata_serie_a_id` = '.$idgiornatasa.'
            and giocatore_id in (select id from giocatori where id_squadra = '.$idsquadra.')';
            if ($conn->query($querydelete) === FALSE) {
                //throw exception
                echo $querydelete;
            }

            $queryselect = 'SELECT id from giocatori where giocatori.id_squadra = '.$idsquadra;
            $result=$conn->query($queryselect);
            $giocatori = array();
            while ($row=$result->fetch_assoc()) {
                array_push($giocatori, array(
                    "id"=>$row["id"],
                    )
                );
            }

            foreach($giocatori as $giocatore)
            {
                $queryinsert= "INSERT INTO `giocatori_voti`(`giocatore_id`, `giornata_serie_a_id`, `voto`, `voto_md`, `voto_ufficio`) 
                VALUES (".$giocatore["id"].",".$idgiornatasa.",6,6, true)";
            
                if ($conn->query($queryinsert) === FALSE) {
                    //throw exception
                    echo $queryinsert;
                }
            }
            echo json_encode(array(
                'result' => "true",
                'message' => $action." eseguito",
            ));
            break;
        default:
            echo json_encode(array(
                'error' => array(
                    'msg' => "Method not allowed",
                    // 'code' => $e->getCode(),
                ),
            ));
        break;
    }


}
else{
    echo json_encode(array(
        'error' => array(
            'msg' => "Method not allowed",
            // 'code' => $e->getCode(),
        ),
    ));
}

// function parse_voti($filename, $idgiornata) {
// 	$message ="";
// 	if (($handle = fopen($filename, "r")) !== FALSE) {
// 		// $data = fgetcsv($handle, 1000, ",");
// 		$countervoti = 0;
// 		$errormessage = "";
// 		try{
// 			include_once ("../dbinfo_susyleague.inc.php");
// 			$conn = new mysqli($localhost, $username, $password,$database);
			
// 			// Check connection
// 			if ($conn->connect_error) {
// 				die("Connection failed: " . $conn->connect_error);
// 			}

// 			$queryresetVoti = 'DELETE FROM `giocatori_voti` WHERE `giornata_serie_a_id` = '.$idgiornata;
// 			$result=$conn->query($queryresetVoti);// or die($conn->error);
// 			if(!$result)
// 			{
// 				$message .= 'Reset voti fallito: <br>';
// 				throw new Exception($conn->error);
// 			}
// 			// else
//             //     $message .= 'Reset voti ok.<br/>';

// 			// $queryresetrisultati = 'UPDATE calendario 
// 			// set gol_casa = null, gol_ospiti = null,
// 			// punti_casa = null, punti_ospiti = null,
// 			// md_casa = 0, md_ospite = 0,
// 			// numero_giocanti_casa = 0, numero_giocanti_ospite = 0,
// 			// fattorecasa = null
// 			// where id_giornata = '.$idgiornata;
// 			// $result=$conn->query($queryresetrisultati); //or die($conn->error);
// 			// if(!$result)
// 			// {
// 			// 	// echo 'Reset risultati fallito: ' .$conn->error .'<br/>';
// 			// 	$message .=  'Reset risultati fallito: <br>';
// 			// 	throw new Exception($conn->error);
// 			// }
// 			// else
//             // $message .=  'Reset risultati ok. <br/>';

// 			$cod = 0;
// 			$voto = 0;
// 			$votof = 0;
			
// 			while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
// 				$int_value = ctype_digit($data[0]) ? intval($data[0]) : null;
// 				if ($int_value !== null && is_numeric($data[3]))
// 				{
// 					//[0]>Cod.	[1]>Ruolo	[2]>Nome	[3]>Voto	[4]>Gf	
// 					//[5]>Gs	[6]>Rp	[7]>Rs	[8]>Rf	[9]>Au	[10]>Amm	
// 					//[11]>Esp	[12]>Ass	[13]>Asf	[14]>Gdv	[15]>Gdp
// 					$cod = $data[0];
// 					// $voto = str_replace(',', '.', preg_replace("/[^0-9,]/", '',  $data[3]));
// 					$voto = str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $data[3]));
// 					// echo $data[3] ." ".$voto;
// 					// echo "<br>";
// 					switch($data[1])
// 					{
// 						// + (3*$data[4]) //gol fatti
// 						// 	- (1*$data[5]) //gol subiti
// 						// 	+ (3*$data[6]) //rigori parati
// 						// 	- (3*$data[7]) //rigori sbagliati
// 						// 	+ (3*$data[8]) //gol su rigore
// 						// 	- (3*$data[9]) //autogol
// 						// 	- (0.5*$data[10])//ammonizioni
// 						// 	- (0.5*$data[11])//espulsioni
// 						// 	+ (1*$data[12]) //assist
// 						// 	+ (1*$data[13]) //assist da fermo
// 						case "P":
// 						case "D":
// 						case "C":
// 						case "A":
// 						$votof = $voto 
// 						+ (3 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $data[4])) )
// 						- (1 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $data[5])) )
// 						+ (3 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $data[6])) )
// 						- (3 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $data[7])) )
// 						+ (3 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $data[8])) )
// 						- (2 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $data[9]))  )
// 						- (0.5 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $data[10]))) 
// 						- (1 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $data[11])) )
// 						+ (1 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $data[12])) )
// 						+ (0.5 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $data[13])) )
// 							;
// 							break;
// 					}
// 					// echo print_r($data) .'<br>'; 
// 					if( $voto != 0 && $votof != '' ){
// 						$query = "INSERT INTO `giocatori_voti`(`giocatore_id`, `giornata_serie_a_id`, `voto`, `voto_md`) 
//                         VALUES ($cod,$idgiornata,$votof,$voto)";
// 						$result=$conn->query($query) ;//or die($conn->error);
// 						if($result) {
// 							$countervoti++; 
// 							// echo $query .'<br>';
// 							// echo $result .'<br>';
// 							// echo $cod . '-'.$data[2] . '; voto: ' . $voto. ' fantavoto:  ' .$votof . '<br/> '; 
// 						}
// 						else {
// 							$message .=  " ERROR ". $cod . '-'.$data[2]  . ($conn->error) .'<br>';
// 						}
// 					}
// 					else{
// 						$message .=  "ERRORE: ". $cod . '-'.$data[2] .' . Il voto non è stato importato.<br>';
// 					}
// 				}
// 				else 
// 				{
// 					$message .=  "Row skipped:";
// 					$message .= print_r($data);
// 				}
// 			}
// 			// echo " Procedura completata.<br/>";
// 			// echo " Si sono verificati i seguenti errori: " .$errormessage ."<br/>";
// 			$message .=  " Inseriti " .$countervoti. " voti.";
// 		}
// 		catch(Exception $e) {
// 			$message .=  'Caught exception: '.  $e->getMessage(). "\n";
// 		}
// 		finally{
// 			$conn->close();
// 		}
// 		fclose($handle);
// 	}
//     return message;
// }
?>
