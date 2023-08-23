<?php
//called by https://console.cron-job.org/dashboard
// include_once ("../dbinfo_susyleague.inc.php");
// // Create connection
// if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}
// // $conn->set_charset("ISO-8859-1");
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
// $conn=mysqli_connect($localhost,$username,$password,$database) or die( "Unable to select database");
include_once("../dbinfo_susyleague.inc.php");
$conn = getConnection();
include_once ("../DB/parametri.php");
?>
<?php


// $html = file_get_contents("https://www.fantacalcio.it/voti-fantacalcio-serie-a");
$url = "https://www.fantacalcio.it/statistiche-serie-a/20". getStrAnno(). "/italia/riepilogo";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
$html = curl_exec($curl);
curl_close($curl);

$DOM = new DOMDocument;
libxml_use_internal_errors(true);
$DOM->loadHTML($html);
libxml_clear_errors();

// $giornate = $DOM->getElementById('matchweek')->getElementsByTagName("option");
// $idgiornata = 0;
// foreach($giornate as $item)
// {
// 	// echo $item->getAttribute("selected")."<br>";
// 	if($item->getAttribute("selected")!= "" 
// 	// AND $item->getAttribute("selected")!= "0"
// 	)
// 		// print_r($item->getAttribute("value"))."<br>";
// 		$idgiornata =  $item->getAttribute("value");
// }

// $queryresetVoti = 'DELETE FROM "giocatori_voti" WHERE "giornata_serie_a_id" = '.$idgiornata;
// $result=$conn->query($queryresetVoti);// or die($conn->error);

$items = $DOM->getElementsByTagName('tr');
$arrayGiocatori = array();
foreach($items as $item)
{
	if(count($item->getElementsByTagName('th'))>=3
	AND count($item->getElementsByTagName("th")[3]->getElementsByTagName("a")) > 0
	AND count(explode("/", $item->getElementsByTagName("th")[3]->getElementsByTagName("a")[0]->getAttribute("href")))> 0
	)
	{
		
		$ar = explode("/", $item->getElementsByTagName("th")[3]->getElementsByTagName("a")[0]->getAttribute("href"));
		$rig = explode("/",$DOM->saveHTML($item->getElementsByTagName("td")[6]->childNodes[0]));
		// echo print_r($item->getElementsByTagName("td")[5]->childNodes[0]);
		array_push($arrayGiocatori, array(
			"id"=> $ar[7],
			"nome"=> $ar[6],
			"pg"=> $DOM->saveHTML($item->getElementsByTagName("td")[1]->childNodes[0]),
			"mv"=> $DOM->saveHTML($item->getElementsByTagName("td")[2]->childNodes[0]),
			"mf"=> $DOM->saveHTML($item->getElementsByTagName("td")[3]->childNodes[0]),
			"gf"=> $DOM->saveHTML($item->getElementsByTagName("td")[4]->childNodes[0]),
			"gs"=> $DOM->saveHTML($item->getElementsByTagName("td")[5]->childNodes[0]),
			"rp"=>$DOM->saveHTML($item->getElementsByTagName("td")[7]->childNodes[0]), 
			"rc"=>$rig[1], 
			"r+"=>$rig[0],
			"r-"=> (int)$rig[1]- (int)$rig[0], 
			"ass"=> $DOM->saveHTML($item->getElementsByTagName("td")[8]->childNodes[0]), 
			"asf" => "0", 
			"amm"=> $DOM->saveHTML($item->getElementsByTagName("td")[9]->childNodes[0]),  
			"esp"=> $DOM->saveHTML($item->getElementsByTagName("td")[10]->childNodes[0]),  
			"au" => "0", //attualmente manca sulla pagina di fantacalcio.it
			) 
		);
	}
}
// echo "giornata: " . print_r($giornata). "<br>";
// foreach($arrayGiocatori as $item)
// 	echo print_r($item). "<br>";

// 
// echo count($arrayGiocatori). "<br>";
$anno = getAnno();
foreach($arrayGiocatori as $item)
{
	$queryresetVoti = "DELETE FROM `giocatori_statistiche` 
					where `giocatore_id`=". $item["id"] ." AND `anno`='$anno'";
	$result=$conn->query($queryresetVoti);// or die($conn->error);
	if(!$result)
	{
		echo 'Reset stats fallito: '.$queryresetVoti;
	}
	$queryInsertStats = "INSERT INTO giocatori_statistiche (
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
		values(
			". $item["id"] .",
			'". $anno ."',
			". $item["pg"] .",
			". str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $item["mv"])) .",
			". str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $item["mf"])) .",
			". $item["gf"] .",
			". $item["gs"] .",
			". $item["rp"] .",
			". $item["rc"] .",
			". $item["r+"] .",
			". $item["r-"] .",
			". $item["ass"] .",
			". $item["asf"] .",
			". $item["amm"] .",
			". $item["esp"] .",
			". $item["au"] ."
		)";
	print_r ($queryInsertStats);
	echo '<br/> '; 	
	$result=$conn->query(cleanQuery($queryInsertStats)); //or die($conn->error);
	if($result) {
		// echo cleanQuery($queryInsertStats) .'<br>';
	}
	else {
		echo " ERROR ". $item["id"] . ($conn->error) .'<br>';
		echo $queryInsertStats .'<br>';
		
	}
}
		
?>
<?php 
if(isset($conn))
{$conn->close();}
?>