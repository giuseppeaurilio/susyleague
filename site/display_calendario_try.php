<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}

</style>

<?php
include("menu.html");

?>


<h2>Calendario</h2>


<?php
include("dbinfo_susyleague.inc.php");
mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


$query="SELECT * FROM giornate";
$result=mysql_query($query);

$num=mysql_numrows($result); 



#echo "<b><left>Squadre</center></b><br><br>";


$i=0;
while ($i < $num) {



$id=mysql_result($result,$i,"id_giornata");
$inizio=mysql_result($result,$i,"inizio");
$fine=mysql_result($result,$i,"fine");


$query2="SELECT b.squadra as sq_casa, c.squadra as sq_ospite, a.gol_casa, a.gol_ospiti, a.punti_casa, a.punti_ospiti FROM calendario as a inner join sq_fantacalcio as b on a.id_sq_casa=b.id inner join sq_fantacalcio as c on a.id_sq_ospite=c.id where a.id_giornata=".$id ." order by a.id_partita" ;

#echo $query2;
#echo $query2;
$result_giornata=mysql_query($query2);
$num_giornata=mysql_numrows($result_giornata);
#echo "partite nuemro = " . $num_giornata;
#echo $i;
$link="display_giornata.php?&id_giornata=";
?>




<h2>Giornata <?php  echo $id; ?>
 <a href="<?php  echo $link.$id; ?>">(dettaglio giornata)</a></h2>

<h3><?php echo $inizio ."  -->  " .$fine ;?></h3>


<table border="0" cellspacing="2" cellpadding="2" style="display: inline-block;">
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

$query="select d.gol_casa, d.gol_ospite, d.voto_casa, d.voto_ospite from punteggio_finale as d  where id_giornata=".$id ." and id_partita=" . ($j+1) ;
#echo "query_risultati= " . $query;
$risultati=mysql_query($query);
$num_risultati=mysql_numrows($risultati);
$punti_casa="";
$gol_casa="";
$gol_ospite="";
$punti_ospite="";

if ($num_risultati>0){
$punti_casa=mysql_result($risultati,0,"voto_casa");
$gol_casa=mysql_result($risultati,0,"gol_casa");
$gol_ospite=mysql_result($risultati,0,"gol_ospite");
$punti_ospite=mysql_result($risultati,0,"voto_ospite");
}

$sq_casa=mysql_result($result_giornata,$j,"sq_casa");
$sq_ospite=mysql_result($result_giornata,$j,"sq_ospite");


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

$query_commento="SELECT * FROM commenti where id_giornata=". $id;
$result_commento=mysql_query($query_commento);

$num_commento=mysql_numrows($result_commento); 
if ($num_commento>0) {
$commento=mysql_result($result_commento,0,"commento");
} else {
    $commento="";
} 

?>
</table>
<textarea rows="10" cols="60">
Il punto del presidente:
<?php
echo $commento
?>

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