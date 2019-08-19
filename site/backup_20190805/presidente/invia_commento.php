<?php
$commento=$_GET['commento'];
$id_giornata=$_GET['id_giornata'];
//echo "commento=".$commento . "<br>";
//echo "giornata=" . $id_giornata. "<br>";

include("../dbinfo_susyleague.inc.php");
$db = mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
mysql_set_charset('utf8', $db); 

$commento_esc=mysql_real_escape_string($commento);
$query="UPDATE `giornate` SET `commento`='" . $commento_esc."' WHERE `id_giornata`='" .$id_giornata  ."'";
echo $query . "<br>";
mysql_query($query);
mysql_close();
header("Location: {$_SERVER["HTTP_REFERER"]}");
?>
