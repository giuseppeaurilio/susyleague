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
include("menu.php");

?>


<h2>Calendario</h2>


<?
include("../dbinfo_susyleague.inc.php");
mysql_connect($localhost,$username,$password);
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
$result_giornata=mysql_query($query2);
$num_giornata=mysql_numrows($result_giornata);
#echo $num_giocatori;
#echo $i;
?>

<h2><?php echo "Giornata " .$id;?></h2>

<p>Data Inizio: <input type="text" id="datepicker.<?php echo $id ?>" value="<?echo $inizio ;?>">
 
Ora inizio: <input type="text" id="timepicker.<?php echo $id ?>"></p>

<h3><?php echo $inizio ."  -->  " .$fine ;?></h3>


<table border="0" cellspacing="2" cellpadding="2">
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
$punti_casa=mysql_result($result_giornata,$j,"punti_casa");
$gol_casa=mysql_result($result_giornata,$j,"gol_casa");
$sq_casa=mysql_result($result_giornata,$j,"sq_casa");
$sq_ospite=mysql_result($result_giornata,$j,"sq_ospite");

$gol_ospite=mysql_result($result_giornata,$j,"gol_ospiti");

$punti_ospite=mysql_result($result_giornata,$j,"punti_ospiti");
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
echo "</table>";
++$i;
} 

mysql_close();

?>
<?php
include("footer.html");

?>

</body>
</html>
