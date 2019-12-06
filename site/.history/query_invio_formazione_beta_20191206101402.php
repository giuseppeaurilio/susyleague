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

				date_default_timezone_set('Europe/Rome');
				$adesso = date('Y-m-d H:i:s');
				$query="select fine from giornate where id_giornata=" . $id_giornata  . " and fine > '" . $adesso ."'";
				$result=$conn->query($query);
				if ($result->num_rows == 0){
					throw new Exception("E' troppo tardi per inviare la formazione");
				}
				if ($id_squadra!=$id_squadra_logged){ 
					throw new Exception("Non si è autenticati per inviare la formazione");
				}
				if (count($titolari)!=11 || count($panchina)!=8){
					throw new Exception("La formazione deve includere necessariamente 11 titolari e 8 riserve");
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
				$queryformazioneinviatacasa="UPDATE `calendario` SET `formazione_ casa_inviata`=1 WHERE id_giornata = $id_giornata and id_sq_casa =$id_squadra ;";
				$query.=$queryformazioneinviatacasa;
				$queryformazioneinviataospite="UPDATE `calendario` SET `formazione_ospite_inviata`=1 WHERE id_giornata = $id_giornata and id_sq_ospite =$id_squadra ;";
				$query.=$queryformazioneinviataospite;
				foreach ($giocatoriformazione as $value) 
				{	
					
					$index++;
					// print_r($value);
					$query_ini = "REPLACE INTO `formazioni`(`id giornata`, `id_squadra`, `id_posizione`, `id_giocatore`, `id_squadra_sa`) 
					VALUES (" . $id_giornata .",". $id_squadra . "," . $index . ",'" .$value["id"] . "','" .$value["id_squadra"]. "');" ;
					$query .=$query_ini;
				}

				
				
				// //  echo $query;
				// $resultmq=$conn->multi_query($query);
				
				// // $resultmq->close();
				// while(mysqli_next_result($conn)){;}

				if ($conn->multi_query($query)) {
					do {
						/* store first result set */
						if ($result = $conn->store_result()) {
							while ($row = $result->fetch_row()) {
								// printf("%s\n", $row[0]);
							}
							$result->free();
						}
						else
						{
							$message .=$conn->error;
						}
					} while ($conn->next_result());
					$message .= "Formazione inviata\n";
				}
				else
				{
					$message .=$conn->error;	
				}
				// print_r($result);
				
				// echo $message;	
				
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

// $id_squadra=preg_replace("/[^A-Za-z0-9,]/", '', $_POST['id_squadra']);//mysql_escape_String($_POST['id_squadra']);
// $id_giornata=preg_replace("/[^A-Za-z0-9,]/", '', $_POST['id_giornata']);//mysql_escape_String($_POST['id_giornata']);
// $titolari=preg_replace("/[^A-Za-z0-9,]/", '', $_POST['titolari']);//mysql_escape_String($_POST['titolari']);
// $panchina=preg_replace("/[^A-Za-z0-9,]/", '', $_POST['panchina']);//mysql_escape_String($_POST['panchina']);
// $password_all=preg_replace("/[^A-Za-z0-9,]/", '', $_POST['password_all']);//mysql_escape_String($_POST['password_all']);

// $ammcontrollata=preg_replace("/[^0-9]/", '', $_POST['ammcontrollata']);
//     session_start();
// 	if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
// 	$allenatore="";
// 	}
// 	else { 
// 	$allenatore= $_SESSION['allenatore'];
// 	$id_squadra_logged= $_SESSION['login'];
// 	}
	
// #echo "tutto ok!";
// #echo $id_squadra;
// #echo $id_giornata;
// #echo $titolari;
// #echo $password_all;






// function readback($id_giornata,$id_squadra)
// {
// 	include("dbinfo_susyleague.inc.php");
// 		// Create connection
// 	$conn = new mysqli($localhost, $username, $password,$database);

// 	// Check connection
// 	if ($conn->connect_error) {
// 	    die("Connection failed: " . $conn->connect_error);
// 	}
// 	// echo "Connected successfully";
	
// 	$query="SELECT id_posizione, id_giocatore FROM formazioni where id_giornata=$id_giornata and id_squadra=$id_squadra order by id_posizione";
// 	$result=$conn->query($query);
// 	$num=$result->num_rows;
// 	$i=0;
// 	$a=array();
// 	while ($row= $result->fetch_assoc()) 
// 	{
// 		array_push($a,$row["id_giocatore"]);

// 	}


// 	//$a[3]="5";
// 	//print_r($a);

// 	return $a;
// }

// date_default_timezone_set('Europe/Rome');

// $adesso = date('Y-m-d H:i:s');
// $nl="%0D%0";
// $nl="\n";

// $queryupdate='UPDATE `sq_fantacalcio` SET `ammcontrollata`='.$ammcontrollata .' WHERE id=' . $id_squadra;

// $result  = $conn->query($queryupdate) or die($conn->error);	

// $query="select fine from giornate where id_giornata=" . $id_giornata  . " and fine > '" . $adesso ."'";
// #echo "<br>query_data=" . $query;
// $result=$conn->query($query);
// $num=$result->num_rows; 


// if ($num>0){
// 	if ($id_squadra==$id_squadra_logged){ 
		
// 		$query="SELECT * FROM sq_fantacalcio where id=$id_squadra";
// 		$result=$conn->query($query);

// 		$num=$result->num_rows;
// 		$row=$result->fetch_assoc();
// 		$allenatore_nome = $row["allenatore"];
// 		$squadrafc_nome = $row["squadra"];

// 		$titolari_array=explode("," , $titolari);
// 		$panchina_array=explode("," , $panchina);
// 		$num_titolari=count($titolari_array);
// 		$num_panchina=count($panchina_array);
		
		
// 		#echo "<br> num titolari= " .$num_titolari;
// 		#echo "<br> num panchina= " . $num_panchina;
// 		if (($num_titolari==11) and ($num_panchina==8)){
// 			$giocatori=array_merge ($titolari_array, $panchina_array);
// 			$prova_nr=0;
// 			do  
// 			{
// 				++$prova_nr;
// 				#print_r($giocatori);
// 				$i=1;
// 				$query_ini = "REPLACE INTO `formazioni`(`id_giornata`, `id_squadra`, `id_posizione`, `id_giocatore`, `id_squadra_sa`) VALUES (" . $id_giornata .",". $id_squadra . "," ;
// 				$text="$squadrafc_nome ha appena inviato la formazione per la giornata $id_giornata \n\n". "TITOLARI \n\n";
// 				$ruolo_old="P";
// 				foreach ($giocatori as $value) 
// 				{
// 					$query_squadra="SELECT a.*, b.squadra_breve from giocatori as a inner join squadre_serie_a as b where a.id_squadra=b.id and a.id=" .$value ;
// 					#echo $query_nome;
// 					$result=$conn->query($query_squadra);
// 					$row=$result->fetch_assoc();
// 					$id_squadra_sa=$row["id_squadra"];
// 					$nome=$row["nome"];
// 					$ruolo=$row["ruolo"];
// 					$squadra_breve=$row["squadra_breve"];
	
// 					$query=$query_ini . $i . ",'" .$value . "','" . $id_squadra_sa . "')" ;
// 					$result=$conn->query($query);
// 					$text .= "$nome($squadra_breve) ";
// 					if ($i<11){
// 						$text .= "\n";
// 						}
	
// 					if ($i==11) {
	
// 						$text .= "\n\n" ."A DISPOSIZIONE \n\n";
// 					}
	
// 					$i=$i+1;
// 					#echo $query;
// 				}# end foreach
// 			//echo $text;
// 		} while ((readback($id_giornata,$id_squadra) <> $giocatori) and ($prova_nr<10)); // end prove immissione
// 		//echo "prova numero = $prova_nr";
// 		if ($prova_nr<10)
// 		{
// 			echo "Formazione inviata \n";
// 			echo "Messaggio telegram inviato \n";
// 			echo  $adesso ;
			
// 			$a=send_message_post($text);
// 		}
// 		else
// 		{
// 			echo "ATTENZIONE!!!!! \n\nSi e' verificato un problema con l'invio della formazione. Si prega di riprovare";
// 		}
// 		} #end if numero giocatori
// 		else echo "La formazione deve includere necessariamente 11 titolari e 8 riserve";
// 	}# end if password corretta
// 	else echo "Non si e' autenticati per iviare la formazione";
// }# end if data corretta
// else echo "E' troppo tardi per inviare la formazione";
?> 
