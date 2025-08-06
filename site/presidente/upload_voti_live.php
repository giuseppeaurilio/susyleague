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
?>
<?php


$url = "https://www.fantacalcio.it/voti-fantacalcio-serie-a";
$useragent= "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36";
$options = array(
	CURLOPT_RETURNTRANSFER => true,   // return web page
	CURLOPT_HEADER         => false,  // don't return headers
	CURLOPT_FOLLOWLOCATION => true,   // follow redirects
	CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
	CURLOPT_ENCODING       => "gzip, deflate",     // handle compressed
	CURLOPT_USERAGENT      => $useragent , // name of client
	CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
	CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
	CURLOPT_TIMEOUT        => 120,    // time-out on response

); 
$curl = curl_init($url);
curl_setopt_array($curl, $options);
$html = curl_exec($curl);
curl_close($curl);
$DOM = new DOMDocument;
libxml_use_internal_errors(true);
$DOM->loadHTML($html);
libxml_clear_errors();

// print_r($_SERVER['HTTP_USER_AGENT']);
$giornate = $DOM->getElementById('matchweek')->getElementsByTagName("option");
$idgiornata = 0;
foreach($giornate as $item)
{
	// echo $item->getAttribute("selected")."<br>";
	if($item->getAttribute("selected")!= "" 
	// AND $item->getAttribute("selected")!= "0"
	)
		// print_r($item->getAttribute("value"))."<br>";
		$idgiornata =  $item->getAttribute("value");
}

$queryresetVoti = 'DELETE FROM `giocatori_voti` WHERE `giornata_serie_a_id` = '.$idgiornata;
$result=$conn->query($queryresetVoti);// or die($conn->error);

$items = $DOM->getElementsByTagName('tr');
$arrayGiocatori = array();
foreach($items as $item)
{
	if(count($item->getElementsByTagName('td'))>0
	AND count($item->getElementsByTagName("td")[0]->getElementsByTagName("div")) > 0
	AND count($item->getElementsByTagName("td")[0]->getElementsByTagName("div")[0]->getElementsByTagName("a")) > 0 
	AND count(explode("/", $item->getElementsByTagName("td")[0]->getElementsByTagName("div")[0]->getElementsByTagName("a")[0]->getAttribute("href")))> 0
	AND $item->getElementsByTagName("td")[1]->getElementsByTagName("div")[3]->getElementsByTagName("span")[0]->getAttribute("data-value") != "55" //sei grigetto
	)
	{
		$ar = explode("/", $item->getElementsByTagName("td")[0]->getElementsByTagName("div")[0]->getElementsByTagName("a")[0]->getAttribute("href"));
		
		array_push($arrayGiocatori, array(
			"id"=> $ar[7],
			"nome"=> $ar[6],
			"voto"=> $item->getElementsByTagName("td")[1]->getElementsByTagName("div")[3]->getElementsByTagName("span")[0]->getAttribute("data-value"),//voti italia
			"golf"=>  $item->getElementsByTagName("td")[2]->getElementsByTagName("span")[0]->getAttribute("data-value"),
			"gols"=>  $item->getElementsByTagName("td")[2]->getElementsByTagName("span")[1]->getAttribute("data-value"),
			"rigp"=>  $item->getElementsByTagName("td")[2]->getElementsByTagName("span")[5]->getAttribute("data-value"),
			"rigs"=>  $item->getElementsByTagName("td")[2]->getElementsByTagName("span")[4]->getAttribute("data-value"),
			"golr"=>  $item->getElementsByTagName("td")[2]->getElementsByTagName("span")[3]->getAttribute("data-value"),
			"aut"=>  $item->getElementsByTagName("td")[2]->getElementsByTagName("span")[2]->getAttribute("data-value"),
			"ass"=>  $item->getElementsByTagName("td")[2]->getElementsByTagName("span")[6]->getAttribute("data-value"),
			
			"amm"=>  strpos($item->getElementsByTagName("td")[1]->getElementsByTagName("span")[0]->getAttribute('class'), "yellow-card")>0 ?  1 :0,
			"esp"=>  strpos($item->getElementsByTagName("td")[1]->getElementsByTagName("span")[0]->getAttribute('class'), "red-card")>0  ?  1 :0,
			
			)
		);
	}
}
// echo "giornata: " . print_r($giornata). "<br>";
// foreach($arrayGiocatori as $item)
// 	echo print_r($item). "<br>";

$countervoti =0;
// echo count($arrayGiocatori). "<br>";
foreach($arrayGiocatori as $item)
{
		// echo print_r($item). "<br>";
		$id = $item["id"];
		$voto = str_replace(',', '.',$item["voto"]);
		// + (3*$data[4]) //gol fatti
		// 	- (1*$data[5]) //gol subiti
		// 	+ (3*$data[6]) //rigori parati
		// 	- (3*$data[7]) //rigori sbagliati
		// 	+ (3*$data[8]) //gol su rigore
		// 	- (3*$data[9]) //autogol
		// 	- (0.5*$data[10])//ammonizioni
		// 	- (0.5*$data[11])//espulsioni
		// 	+ (1*$data[12]) //assist
		$votof = $voto 
				+ (3 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $item["golf"])) )
				- (1 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $item["gols"])) )
				+ (3 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $item["rigp"])) )
				- (3 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $item["rigs"])) )
				+ (3 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $item["golr"])) )
				- (2 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $item["aut"]))  )
				- (0.5 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $item["amm"]))) 
				- (1 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '', $item["esp"])) )
				+ (1 *  str_replace(',', '.', preg_replace("/[^0-9,.]/", '',  $item["ass"])) );
		if( $voto != 0 && $votof != '' ){
			$query = "INSERT INTO `giocatori_voti`(`giocatore_id`, `giornata_serie_a_id`, `voto`, `voto_md`) 
				VALUES ($id,$idgiornata,$votof,$voto)";
		// print_r ($query);
		// echo '<br/> '; 
		$result=$conn->query(cleanQuery($query)) ;//or die($conn->error);
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
}
echo("Inseriti $countervoti  voti.<br>");
?>
<?php 
if(isset($conn))
{$conn->close();}
?>