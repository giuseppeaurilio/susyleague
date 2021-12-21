<?php 
$action ="";
include_once ("dbinfo_susyleague.inc.php");
include_once 	("send_message_post.php");

session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	$allenatore="";
}
else { 
	$allenatore= $_SESSION['allenatore'];
	$id_squadra_logged= $_SESSION['login'];
}

$conn = new mysqli($localhost, $username, $password,$database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$action = $_POST['action'];

    switch($action)
    {
		case("inviaformazione"):
			
			try{
				
				$id_squadra=preg_replace("/[^A-Za-z0-9,]/", '', $_POST['id_squadra']);//mysql_escape_String($_POST['id_squadra']);
				$id_giornata=preg_replace("/[^A-Za-z0-9,]/", '', $_POST['id_giornata']);//mysql_escape_String($_POST['id_giornata']);
				$titolari=(!empty($_POST['titolari']))? $_POST['titolari'] : array();
				$panchina=(!empty($_POST['panchina']))? $_POST['panchina'] : array();
				$default=(!empty($_POST['default']))? $_POST['default'] : 'false';
				$all=(!empty($_POST['all']))? $_POST['all'] : '';

				date_default_timezone_set('Europe/Rome');
				$adesso = date('Y-m-d H:i:s');
				$query="SELECT inizio 
				from giornate as g
				left join giornate_serie_a as ga on g.giornata_serie_a_id = ga.id 
				where id_giornata=" . $id_giornata  . " and inizio < '" . $adesso ."'";
				// echo $query;
				$result=$conn->query($query);
				if ($result->num_rows > 0){
					throw new Exception("E' troppo tardi per inviare la formazione");
				}
				if ($id_squadra!=$id_squadra_logged){ 
					throw new Exception("Non si è autenticati per inviare la formazione");
				}
				if (count($titolari)!=11 || count($panchina)!=10){
					throw new Exception("La formazione deve includere necessariamente 11 titolari e 10 riserve");
				}
				
				$formazione=array_merge ($titolari, $panchina);		
				
				$message = "";

				
				$giocatoriformazione = array();
				foreach ($formazione as $value) 
				{
					$queryformazione = "SELECT a.*, b.squadra_breve 
										from giocatori as a 
										inner join squadre_serie_a as b on  a.id_squadra=b.id 
										where  a.id = " .$value["id"] ;
					// echo $queryformazione;
					$result_giocatoriformazione=$conn->query($queryformazione);
					$row=$result_giocatoriformazione->fetch_assoc();
					// print_r($row);
					array_push($giocatoriformazione, array(
							"id"=>$row["id"],
							"id_squadra"=>$row["id_squadra"],
							"nome"=>$row["nome"],
							"ruolo"=>$row["ruolo"],
							"squadra_breve"=>$row["squadra_breve"]
						)
					);
				}
				// print_r($giocatoriformazione);
				
				//se salvo la formazione 
				
				$query = "";
				$query="SELECT * FROM sq_fantacalcio where id=$id_squadra";
				
				$result2=$conn->query($query);
				
				$row=$result2->fetch_assoc();
				$allenatore_nome = $row["allenatore"];
				$squadrafc_nome = $row["squadra"];
				
				$index =0;
				
				$query = "";
				//cancello precedente
				$query_del = "DELETE FROM `formazioni` where id_giornata=".$id_giornata." AND id_squadra=". $id_squadra;

				if(!$conn->query($query_del))
				{
						throw new Exception($conn->error);
				}
				if($default == "true"){
					//cancello precedente
					$query_del = "DELETE FROM `formazione_standard` where id_squadra=". $id_squadra;
					if(!$conn->query($query_del))
					{
							throw new Exception($conn->error);
					}
				}
				include_once "DB/fantacalcio.php";
				$altrepartite;
				if($all == "true"){
					$altrepartite = fantacalcio_getAltrePartite($id_giornata , $id_squadra);
				}
				foreach ($giocatoriformazione as $value) 
				{	
					$index++;
					

					//inserisco ultima
					$query_ini = "REPLACE INTO `formazioni`(`id_giornata`, `id_squadra`, `id_posizione`, `id_giocatore`) 
					VALUES (" . $id_giornata .",". $id_squadra . "," . $index . ",'" .$value["id"] . "');" ;						
					
					// $query .=$query_ini;
					if(!$conn->query($query_ini))
					{
						echo $query_ini;
						throw new Exception($conn->error);
					}

					//salvo come formazione di default
					if($default == "true")
					{
						//inserisco ultima	
						$query_default = "REPLACE INTO `formazione_standard`( `id_squadra`, `id_posizione`, `id_giocatore`, `id_squadra_sa`,  `id_tipo_formazione`) 
						VALUES (" . $id_squadra . "," . $index . ",'" .$value["id"] . "','" .$value["id_squadra"]. "', 1);" ;
						// $query .=$query_ini;
						if(!$conn->query($query_default))
						{
							echo $query_default;
							throw new Exception($conn->error);
						}
					}

					//salvo per tutte le partite in corso.
					if($all == "true")
					{
						foreach($altrepartite as $altrapartita)
						{
							$query_ini = "REPLACE INTO `formazioni`(`id_giornata`, `id_squadra`, `id_posizione`, `id_giocatore`) 
							VALUES (" . $altrapartita["id_giornata"] .",". $id_squadra . "," . $index . ",'" .$value["id"] . "');" ;						
							
							// $query .=$query_ini;
							if(!$conn->query($query_ini))
							{
								echo $query_ini;
								throw new Exception($conn->error);
							}
						}
						
					}
				}
				$queryformazioneinviatacasa="UPDATE `calendario` SET `formazione_casa_inviata`=1 WHERE id_giornata = ". $id_giornata ." and id_sq_casa =$id_squadra ;";
				if(!$conn->query($queryformazioneinviatacasa))
				{
						throw new Exception($conn->error);
				}
				$queryformazioneinviataospite="UPDATE `calendario` SET `formazione_ospite_inviata`=1 WHERE id_giornata = ". $id_giornata ." and id_sq_ospite =$id_squadra ;";
				if(!$conn->query($queryformazioneinviataospite))
				{
						throw new Exception($conn->error);
				}
				if($all == "true"){
					foreach($altrepartite as $altrapartita){
						$queryformazioneinviatacasa="UPDATE `calendario` SET `formazione_casa_inviata`=1 WHERE id_giornata = " . $altrapartita["id_giornata"] ." and id_sq_casa =$id_squadra ;";
						// $message .= $queryformazioneinviatacasa;
						if(!$conn->query($queryformazioneinviatacasa))
						{
								throw new Exception($conn->error);
						}
						$queryformazioneinviataospite="UPDATE `calendario` SET `formazione_ospite_inviata`=1 WHERE id_giornata = " . $altrapartita["id_giornata"] ." and id_sq_ospite =$id_squadra ;";
						// $message .= $queryformazioneinviataospite;
						if(!$conn->query($queryformazioneinviataospite))
						{
								throw new Exception($conn->error);
						}
					}
				}
				$message .= "Formazione inviata\n";
				
				
				//se invio il messaggio telegram 
				$index =0;
				// echo "secondo";
				// print_r($giocatoriformazione);

				include_once "DB/calendario.php";
				$descrizioneGiornata = getDescrizioneGiornata($id_giornata);
				$text="$squadrafc_nome ha appena inviato la formazione per $descrizioneGiornata \n\n";
				// $text="$squadrafc_nome ha appena inviato la formazione per la giornata $id_giornata \n\n";

				$textformazione = "";
				$textmodulo = "";
				$textformazionepanchina = "";
				$textmodulopanchina = "";

				$diftit= 0;
				$centit= 0;
				$atttit= 0;
				$porris= 0;
				$difris= 0;
				$cenris= 0;
				$attris= 0;
				foreach ($giocatoriformazione as $value) 
				{
					$index++;
					$txtgiocatore = $index . '.'. $value["nome"].'('.$value["squadra_breve"].')' ."\n" ;
					if ($index<=11){
						$textformazione .=$txtgiocatore;
						switch($value["ruolo"])
						{
							case("P"): break;
							case("D"): $diftit++; break;
							case("C"): $centit++; break;
							case("A"): $atttit++; break;
						}
					}
					else {
						$textformazionepanchina .=$txtgiocatore;
						switch($value["ruolo"])
						{
							case("P"): $porris++; break;
							case("D"): $difris++; break;
							case("C"): $cenris++; break;
							case("A"): $attris++; break;
						}
					}
				}
				$textmodulo = $diftit . "-" . $centit . "-" . $atttit;
				$textmodulopanchina = $porris . "-" . $difris . "-" . $cenris . "-" . $attris;
				$text .= "TITOLARI (" . $textmodulo .")\n". $textformazione . "\n" ."A DISPOSIZIONE (" . $textmodulopanchina . ")\n". $textformazionepanchina;
				// echo $text;
				// print_r($text);
				$a=send_message_post($text);

				$message .= "Messaggio telegram inviato \n";

				$queryupdate='UPDATE `sq_fantacalcio` SET `ammcontrollata`=0 WHERE id=' . $id_squadra;
				$resultac  = $conn->query($queryupdate) ;
				
				// $result->close();
				// $conn->next_result();
				$message .= date('d/m H:i:s', strtotime($adesso))  ;
				echo json_encode(array(
					'result' => "true",
					'message' => $message
				));
			}
			catch (Exception $e) {
				echo json_encode(array(
					'error' => array(
						'message' => $e->getMessage(),
						// 'code' => $e->getCode(),
					),
				));
			}
			finally {
				if(isset($conn))
					{$conn->close();}
			}
		
		// else{
		// 	echo json_encode(array(
		// 		'error' => array(
		// 			'msg' => "Non si è autenticati per iviare la formazione",
		// 			// 'code' => $e->getCode(),
		// 		),
		// 	));
		// }
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
?> 
