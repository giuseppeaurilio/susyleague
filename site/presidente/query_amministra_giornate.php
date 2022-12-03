<?php


// include_once ("../dbinfo_susyleague.inc.php");

// // Create connection
// if(!isset($conn)) {$conn = new mysqli($localhost, $username, $password,$database);}

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
// // echo "Connected successfully";
include_once("../dbinfo_susyleague.inc.php");
    $conn = getConnection();


$id_giornata=$conn->real_escape_string($_POST['giornata']);
$g_inizio=$conn->real_escape_string($_POST['g_inizio']);
$m_inizio=$conn->real_escape_String($_POST['m_inizio']);
$a_inizio=$conn->real_escape_String($_POST['a_inizio']);
$h_inizio=$conn->real_escape_String($_POST['h_inizio']);
$min_inizio=$conn->real_escape_String($_POST['min_inizio']);

$g_fine=$conn->real_escape_String($_POST['g_fine']);
$m_fine=$conn->real_escape_String($_POST['m_fine']);
$a_fine=$conn->real_escape_String($_POST['a_fine']);
$h_fine=$conn->real_escape_String($_POST['h_fine']);
$min_fine=$conn->real_escape_String($_POST['min_fine']);



$query="UPDATE `giornate` SET `inizio`='" . $a_inizio . "-" . $m_inizio . "-" . $g_inizio . " " . $h_inizio . ":" . $min_inizio ."',`fine`='" . $a_fine . "-" . $m_fine . "-" . $g_fine . " " . $h_fine . ":" . $min_fine ."' WHERE `id_giornata`='" .$id_giornata  ."'";


#$query="replace into giornate (`id_giornata`, `inizio`, `fine`) values(" . $id_giornata . ",'" . $a_inizio . "-" . $m_inizio . "-" . $g_inizio . " " . $h_inizio . ":" . $min_inizio ."', '" . $a_fine . "-" . $m_fine . "-" . $g_fine . " " . $h_fine . ":" . $min_fine ."')";
//echo $query;
$conn->query($query);


header("Location: {$_SERVER["HTTP_REFERER"]}");
?>
