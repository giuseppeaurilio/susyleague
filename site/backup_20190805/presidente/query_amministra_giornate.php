<?php


include("../dbinfo_susyleague.inc.php");
mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


$id_giornata=mysql_real_escape_string($_POST['giornata']);
$g_inizio=mysql_real_escape_string($_POST['g_inizio']);
$m_inizio=mysql_real_escape_String($_POST['m_inizio']);
$a_inizio=mysql_real_escape_String($_POST['a_inizio']);
$h_inizio=mysql_real_escape_String($_POST['h_inizio']);
$min_inizio=mysql_real_escape_String($_POST['min_inizio']);

$g_fine=mysql_real_escape_String($_POST['g_fine']);
$m_fine=mysql_real_escape_String($_POST['m_fine']);
$a_fine=mysql_real_escape_String($_POST['a_fine']);
$h_fine=mysql_real_escape_String($_POST['h_fine']);
$min_fine=mysql_real_escape_String($_POST['min_fine']);



$query="UPDATE `giornate` SET `inizio`='" . $a_inizio . "-" . $m_inizio . "-" . $g_inizio . " " . $h_inizio . ":" . $min_inizio ."',`fine`='" . $a_fine . "-" . $m_fine . "-" . $g_fine . " " . $h_fine . ":" . $min_fine ."' WHERE `id_giornata`='" .$id_giornata  ."'";


#$query="replace into giornate (`id_giornata`, `inizio`, `fine`) values(" . $id_giornata . ",'" . $a_inizio . "-" . $m_inizio . "-" . $g_inizio . " " . $h_inizio . ":" . $min_inizio ."', '" . $a_fine . "-" . $m_fine . "-" . $g_fine . " " . $h_fine . ":" . $min_fine ."')";
//echo $query;
mysql_query($query);
mysql_close();

header("Location: {$_SERVER["HTTP_REFERER"]}");
?>
