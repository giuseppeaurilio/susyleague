
<?php
include("../dbinfo_susyleague.inc.php");
mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


function parse_giocatori($filename) {


$row = 1;
if (($handle = fopen($filename, "r")) !== FALSE) {
	$data = fgetcsv($handle, 1000, ",");
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
#        $num = count($data);
#        echo "<p> $num fields in line $row: <br /></p>\n";
#        $row++;
#        for ($c=0; $c < $num; $c++) {
#            echo $data[$c] . "<br />\n";
#        }
        $squadra=strtoupper($data[3]);
        $squadra_breve=substr($squadra,0,3);
        echo "Squadra = " . $squadra . " " . $squadra_breve;
		$query="INSERT INTO `squadre_serie_a`(`squadra`, `squadra_breve`) VALUES ('$squadra','$squadra_breve')";
		$result=mysql_query($query); 
		if ($result==1) echo " OK"; else echo " ERROR";
#		echo $query ."<br>";
		echo "<br>";
		$query="INSERT INTO `giocatori`(`id`, `ruolo`,`nome`,`id_squadra` ) SELECT $data[0],'$data[1]','$data[2]',id from squadre_serie_a where `squadra_breve`='$squadra_breve'";
		$result=mysql_query($query);
		echo $data[2] ;
		if ($result==1) echo " OK"; else echo " ERROR";
		echo "<br>";
    }
    fclose($handle);
}

// inserisci squadre nel database
// inserisci giocatori nel database dove squadra nome viene sostituito da squadra id
}
	
$target_file =  "giocatori_sere_A.csv";
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
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "Il file ". basename( $_FILES["fileToUpload"]["name"]). " e' stato caricato.";
        $query="Truncate `giocatori`";
		echo $query;
		$result=mysql_query($query);

		$query="Truncate `squadre_serie_a`";
		echo $query;
		$result=mysql_query($query);

		parse_giocatori($target_file);
    } else {
        echo "Errore, il file non e'stato caricato per un problema di scrittura.";
    }
}
?>
