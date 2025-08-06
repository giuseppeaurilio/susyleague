
<?php
function update_giornate_seriea_date() {
	include_once("../dbinfo_susyleague.inc.php");
	$conn = getConnection();
	// $html = file_get_contents("https://www.fantacalcio.it/voti-fantacalcio-serie-a");
	$id_giornata_sa = 1;
	do
	{

		$url = "https://www.fantacalcio.it/serie-a/calendario/$id_giornata_sa";
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

		$xpath = new DOMXpath($DOM);
		$classname ="match-date";
		$nodes = $xpath->query('//div [@class="' . $classname . '"]');
		
		$inizio = explode("      ", trim($nodes[0]->nodeValue));
		$inizio_data = explode("/",trim($inizio[0]));
		$fine = explode("      ", trim($nodes[9]->nodeValue));
		$fine_data = explode("/",trim($fine[0]));
		
		$anni = explode("/",getAnno());
		$inizio_anno = $anni[0];
		$fine_anno = $anni[0];
		if($inizio_data[1] <8)
			$inizio_anno = $anni[1];
		if($fine_data[1] <8)
			$fine_anno = $anni[1];

		$data_inizio= $inizio_anno."-".$inizio_data[1]."-".$inizio_data[0]." ".$inizio[1];
		// echo $data_inizio;
		$data_fine= $fine_anno."-".$fine_data[1]."-".$fine_data[0]." ". date("H:i", strtotime( $fine[1])+ (4*1800));
		// echo $data_inizio." ".date('y-m-d H:i')."<br>";
		if ($data_inizio > date('y-m-d H:i') )
		{
			// echo $data_fine;
			$query= "UPDATE `giornate_serie_a` SET `inizio`='".$data_inizio."',`fine`='".$data_fine."' WHERE id=".$id_giornata_sa ;
			// echo $query."<br>";
			if ($conn->query($query) === FALSE) {
				//throw exception
				echo $query;
			}
		}
		echo("Giornata  $id_giornata_sa  inserita.<br>");
		$id_giornata_sa++;
	}
	while ($id_giornata_sa < 39);
	if(isset($conn))
		{$conn->close();}
}
?>