<?php 

include("menu.php");
include("../dbinfo_susyleague.inc.php");
mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$id_giocatore=$_GET['id_giocatore'];
//echo "pippo";
//echo $id_giocatore;

$query="SELECT a.*, b.squadra FROM giocatori as a inner join squadre_serie_a as b where a.id=$id_giocatore and a.id_squadra=b.id;";
//echo $query;
$result=mysql_query($query);

$num=mysql_numrows($result); 
if ($num=1) {
$provenienza=mysql_result($result,0,"squadra");
$nome=mysql_result($result,0,"nome");
$ruolo=mysql_result($result,0,"ruolo");
echo $nome;



?>
<form action="query_cambia_squadra.php">
  id: <input type="text" name="id_giocatore" value= <?php echo $id_giocatore; ?> readonly><br>
  nome: <input type="text" name="nome" value= "<?php echo $nome; ?>" readonly><br>
  ruolo: <input type="text" name="ruolo" value= <?php echo $ruolo; ?> readonly><br>
provenienza:	<input type="text" name="provenienza" value= <?php echo $provenienza; ?> readonly><br>


<p>Passa alla squadra</p>

<select name="squadra_serie_a" id="sq_sa">


<?php
$query_sa="SELECT * FROM squadre_serie_a order by squadra";
$result_sa=mysql_query($query_sa);

$num_sa=mysql_numrows($result_sa); 
$i=0;

while ($i < $num_sa) {
	$id=mysql_result($result_sa,$i,"id");
    $squadra=mysql_result($result_sa,$i,"squadra");
	  echo '<option value=' . $id . '>'. $squadra . '</option>';
++$i;
}




}
?>

<input type="submit" id="submit" value="Cambia">
</form> 

