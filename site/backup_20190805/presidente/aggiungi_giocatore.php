<?php 
include("../dbinfo_susyleague.inc.php");
//echo $username;
$link = mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$nome=mysql_real_escape_string($_GET["nome"]);
$id=$_GET["id"];
$sq_sa=$_GET["squadra_serie_a"];
$ruolo=$_GET["Ruolo"];

//echo "nome=" . $nome ."<br>";
//echo "id=" . $id ."<br>";
//echo "sq_sa=" . $sq_sa ."<br>";
//echo "ruolo=" . $ruolo ."<br>";
//$sommario_a=explode( '_', $sommario );

//$id_giocatore=$sommario_a[0];
//$id_sq_fc=$sommario_a[1];
$query="INSERT INTO `giocatori` (`id`, `ruolo`, `nome`, `id_squadra`) VALUES ('$id', '$ruolo', '$nome', '$sq_sa')";

//echo $query;
$result=mysql_query($query) or die(mysql_error($link)); 

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
