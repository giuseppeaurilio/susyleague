<?php


include_once ("../dbinfo_susyleague.inc.php");
// mysql_connect($localhost,$username,$password);
// @mysql_select_db($database) or die( "Unable to select database");


// $id_sondaggio=$_POST["id_sondaggio"];

$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";


$testo=$conn->real_escape_string($_POST["testo"]);

// $opzioni=$_POST["mytext"];
// $risp_multipla=$_POST["risp_multipla"];

$g_fine=$conn->real_escape_string($_POST['g_fine']);
$m_fine=$conn->real_escape_string($_POST['m_fine']);
$a_fine=$conn->real_escape_string($_POST['a_fine']);
$h_fine=$conn->real_escape_string($_POST['h_fine']);
$min_fine=$conn->real_escape_string($_POST['min_fine']);


#echo $id_sondaggio;
#echo $testo;

#print_r($id_sondaggio);
#echo "risp_mult=". $risp_multipla;

// $query="REPLACE INTO `sondaggi` (`id`, `testo`, `scadenza`, `risposta_multipla`) VALUES ('$id_sondaggio', '$testo', '" .$a_fine . "-" . $m_fine . "-" . $g_fine . " " . $h_fine . ":" . $min_fine ."', '" .($risp_multipla!="") . "')";
#echo $query;

// mysql_query($query);
$query = 'INSERT INTO `sondaggi`(, `testo`, `scadenza`) VALUES ('.$testo.','.$a_fine . '-' . $m_fine . '-' . $g_fine . ' ' . $h_fine . ':' . $min_fine .')';
$result=$conn->query($query);

// $query="DELETE FROM `sondaggi_opzioni` WHERE `id_sondaggio`='$id_sondaggio'";
#echo $query;
// mysql_query($query);

// $j=1;	
// foreach ($opzioni as $value) {

		
// 	$opzione=mysql_real_escape_string($value);
// 	$query="INSERT INTO `sondaggi_opzioni` (`id`, `id_sondaggio`, `opzione`) VALUES ('$j', '$id_sondaggio', '$opzione')";
// 	mysql_query($query);
// 	#echo $query;
// 	++$j;
// }


// mysql_close();
$conn->close();
echo $result;
// header('Location: ' . $_SERVER['HTTP_REFERER']);



?>
