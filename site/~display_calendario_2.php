<?php
//include("menu.php");
$id_girone=$_GET['id_girone'];
$id_girone=1;
?>

<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}

</style>




<h2>Calendario</h2>


<?php
include("dbinfo_susyleague.inc.php");
mysql_connect($localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$time_start=microtime(true);

$query="SELECT * FROM giornate where id_girone=". $id_girone . " order by id_giornata ASC";
$result=mysql_query($query);

$num=mysql_numrows($result); 

$time_end=microtime(true);
$time = $time_end - $time_start;

#echo "first query" . $time . "<br>";

#echo "<b><left>Squadre</center></b><br><br>";


$i=0;
while ($i < $num) {


$time_start=microtime(true);
$id=mysql_result($result,$i,"id_giornata");
$inizio=mysql_result($result,$i,"inizio");
$fine=mysql_result($result,$i,"fine");
$commento=mysql_result($result,$i,"commento");

$time_end=microtime(true);
$time = $time_end - $time_start;

#echo "query" . $time . "<br>";


$time_start=microtime(true);
#$query2="SELECT b.squadra as sq_casa, c.squadra as sq_ospite, a.gol_casa, a.gol_ospiti, a.punti_casa, a.punti_ospiti FROM calendario as a inner join sq_fantacalcio as b on a.id_sq_casa=b.id inner join sq_fantacalcio as c on a.id_sq_ospite=c.id where a.id_giornata=".$id ." order by a.id_partita" ;
$query2="SELECT b.squadra as sq_casa, c.squadra as sq_ospite, d.gol_casa, d.gol_ospite, d.voto_casa, d.voto_ospite  FROM calendario as a inner join sq_fantacalcio as b on a.id_sq_casa=b.id inner join sq_fantacalcio as c on a.id_sq_ospite=c.id left join punteggio_finale as d on a.id_giornata=d.id_giornata and a.id_partita=d.id_partita where a.id_giornata=". $id ." order by a.id_partita";
#echo $query2;
#echo $query2;
$result_giornata=mysql_query($query2);
$num_giornata=mysql_numrows($result_giornata);
#echo "partite nuemro = " . $num_giornata;

$time_end=microtime(true);
$time = $time_end - $time_start;

#echo "query 2 " . $time . "<br>";

$link="display_giornata.php?&id_giornata=";
?>




<h2>Giornata <?php  echo $id; ?>
 <a href="<?php  echo $link.$id; ?>">(dettaglio giornata)</a></h2>

<h3><?php echo $inizio ."  -->  " .$fine ;?></h3>


<table border="0" cellspacing="2" cellpadding="2" style="display: inline-block">
<tr> 

<th><font face="Arial, Helvetica, sans-serif">Casa</font></th>
<th><font face="Arial, Helvetica, sans-serif">Ospite</font></th>

<th><font face="Arial, Helvetica, sans-serif">gol</font></th>

<th><font face="Arial, Helvetica, sans-serif">gol</font></th>
<th><font face="Arial, Helvetica, sans-serif">punti</font></th>
<th><font face="Arial, Helvetica, sans-serif">punti</font></th>
</tr>
<?php

$j=0;
while ($j < $num_giornata) {


$punti_casa="";
$gol_casa="";
$gol_ospite="";
$punti_ospite="";

$sq_casa=mysql_result($result_giornata,$j,"sq_casa");
$sq_ospite=mysql_result($result_giornata,$j,"sq_ospite");
$punti_casa=mysql_result($result_giornata,$j,"voto_casa");
$gol_casa=mysql_result($result_giornata,$j,"gol_casa");
$gol_ospite=mysql_result($result_giornata,$j,"gol_ospite");
$punti_ospite=mysql_result($result_giornata,$j,"voto_ospite");

?>


<tr> 

<td><font face="Arial, Helvetica, sans-serif"><?php echo "$sq_casa"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo "$sq_ospite"; ?></font></td>

<td><font face="Arial, Helvetica, sans-serif"><?php echo "$gol_casa"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo "$gol_ospite"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo "$punti_casa"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo "$punti_ospite"; ?></font></td>
</tr>

<?php
++$j;

} 

?>
</table>


<textarea readonly rows="10" cols="60">Il punto del presidente:
<?php echo $commento; ?>
</textarea> 


<?php





++$i;
} 

mysql_close();

?>
<?php
include("footer.html");

?>

</body>
</html>