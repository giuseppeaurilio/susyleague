<?php 
$action ="";
include_once ("../dbinfo_susyleague.inc.php");

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
				
				$ammcontrollata=preg_replace("/[^0-9]/", '', $_POST['ammcontrollata']);

				date_default_timezone_set('Europe/Rome');
				$adesso = date('Y-m-d H:i:s');
				$query="select fine from giornate where id_giornata=" . $id_giornata  . " and fine > '" . $adesso ."'";
				$result=$conn->query($query);
				// if ($result->num_rows == 0){
				// 	throw new Exception("E' troppo tardi per inviare la formazione");
				// }
				if ($allenatore != "Presidente"){ 
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
				
				//se salvo la formazione 
				$query = "";
				$query="SELECT * FROM sq_fantacalcio where id=$id_squadra";
				
				$result2=$conn->query($query);
				
				$row=$result2->fetch_assoc();
				$allenatore_nome = $row["allenatore"];
				$squadrafc_nome = $row["squadra"];
				
				$index =0;
				
				$query = "";

				foreach ($giocatoriformazione as $value) 
				{	
					
					$index++;
					// print_r($value);
					if($index == 22)
					{						
						$query_ini = "REPLACE INTO `formazioni`(`dasdsa`, `id_squadra`, `id_posizione`, `id_giocatore`, `id_squadra_sa`) 
						VALUES (" . $id_giornata .",". $id_squadra . "," . $index . ",'" .$value["id"] . "','" .$value["id_squadra"]. "');" ;
					}
					else
					{
						$query_ini = "REPLACE INTO `formazioni`(`id_giornata`, `id_squadra`, `id_posizione`, `id_giocatore`, `id_squadra_sa`) 
						VALUES (" . $id_giornata .",". $id_squadra . "," . $index . ",'" .$value["id"] . "','" .$value["id_squadra"]. "');" ;						
					}
					// $query .=$query_ini;
					if(!$conn->query($query_ini))
					{
							// $message .="passako" .$index++."<br>";
							// $message .=$result;
							// $message .=$conn->error;
							throw new Exception($conn->error);
					}
				}
				$queryformazioneinviatacasa="UPDATE `calendario` SET `formazione_casa_inviata`=2 WHERE id_giornata = $id_giornata and id_sq_casa =$id_squadra ;";
				if(!$conn->query($queryformazioneinviatacasa))
				{
						throw new Exception($conn->error);
				}
				$queryformazioneinviataospite="UPDATE `calendario` SET `formazione_ospite_inviata`=2 WHERE id_giornata = $id_giornata and id_sq_ospite =$id_squadra ;";
				if(!$conn->query($queryformazioneinviataospite))
				{
						throw new Exception($conn->error);
				}
				$queryselect =  "SELECT * FROM `sq_fantacalcio` WHERE id =".$id_squadra;
				$resultfindsquadra  = $conn->query($queryselect) or die($conn->error);
				//devo aggiornare i contatori dell'amministrazione controllata
				if($resultfindsquadra->num_rows != 0)
				{
					while ($row = $resultfindsquadra->fetch_assoc()) {
						// print_r ($row);
						$queryupdate='UPDATE `sq_fantacalcio` SET `ammcontrollata`= '.($row["ammcontrollata"] + 1).', `ammcontrollata_anno`= '.($row["ammcontrollata_anno"] + 1).'  WHERE id=' . $id_squadra;
					}
				}
		
				$resultac  = $conn->query($queryupdate) ;
				$message .= "Formazione inviata\n";
				
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