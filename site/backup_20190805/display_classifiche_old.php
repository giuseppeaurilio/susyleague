<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}

</style>

<?
include("menu.html");

?>


<h1>Classifiche</h1>

<h2>Classifica Punti</h2>
<table border="0" cellspacing="2" cellpadding="2">
<tr> 

<th><font face="Arial, Helvetica, sans-serif">Squadra</font></th>
<th><font face="Arial, Helvetica, sans-serif">Punti</font></th>
<th><font face="Arial, Helvetica, sans-serif">Voto</font></th>
<th><font face="Arial, Helvetica, sans-serif">Gol fatti</font></th>
<th><font face="Arial, Helvetica, sans-serif">Gol subiti</font></th>
</tr>


<?php 
include("dbinfo_susyleague.inc.php");
#echo $username;
mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


$query="SELECT id_squadra, b.squadra, sum(voto) as voto, sum(gol_fatti) as gol_fatti, sum(gol_subiti) as gol_subiti, sum(punti) as punti from ((SELECT id_casa as id_squadra, voto_casa as voto, gol_casa as gol_fatti, gol_ospite as gol_subiti, punti_casa as punti FROM `punteggio_finale`) UNION ALL (SELECT id_ospite as id_squadra, voto_ospite as voto, gol_ospite as gol_fatti, gol_casa as gol_subiti, punti_ospite as punti FROM `punteggio_finale`)) derived_table join sq_fantacalcio as b where b.id=id_squadra GROUP by id_squadra ORDER BY punti DESC,voto DESC, squadra";
 
$result=mysql_query($query);

$num=mysql_numrows($result); 
#echo $num;
$i=0;
while ($i < $num) {

$id_squadra=mysql_result($result,$i,"id_squadra");
$squadra=mysql_result($result,$i,"squadra");
$punti=mysql_result($result,$i,"punti");
$voto=mysql_result($result,$i,"voto");
$gol_fatti=mysql_result($result,$i,"gol_fatti");
$gol_subiti=mysql_result($result,$i,"gol_subiti");




?>
<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$squadra"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$punti"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$voto"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$gol_fatti"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$gol_subiti"; ?></font></td>
</tr>

<?php

++$i;

};

?>
</table>



<h2>Classifica Marcatori</h2>
<table border="0" cellspacing="2" cellpadding="2">
<tr> 

<th><font face="Arial, Helvetica, sans-serif">Squadra</font></th>
<th><font face="Arial, Helvetica, sans-serif">Voto</font></th>
<th><font face="Arial, Helvetica, sans-serif">Punti</font></th>

<th><font face="Arial, Helvetica, sans-serif">Gol fatti</font></th>
<th><font face="Arial, Helvetica, sans-serif">Gol subiti</font></th>
</tr>


<?php 
include("dbinfo_susyleague.inc.php");
#echo $username;
mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


$query="SELECT id_squadra, b.squadra, sum(voto) as voto, sum(gol_fatti) as gol_fatti, sum(gol_subiti) as gol_subiti, sum(punti) as punti from ((SELECT id_casa as id_squadra, voto_casa as voto, gol_casa as gol_fatti, gol_ospite as gol_subiti, punti_casa as punti FROM `punteggio_finale`) UNION ALL (SELECT id_ospite as id_squadra, voto_ospite as voto, gol_ospite as gol_fatti, gol_casa as gol_subiti, punti_ospite as punti FROM `punteggio_finale`)) derived_table join sq_fantacalcio as b where b.id=id_squadra GROUP by id_squadra ORDER BY voto DESC,punti DESC,squadra";
 
$result=mysql_query($query);

$num=mysql_numrows($result); 
#echo $num;
$i=0;
while ($i < $num) {

$id_squadra=mysql_result($result,$i,"id_squadra");
$squadra=mysql_result($result,$i,"squadra");
$voto=mysql_result($result,$i,"voto");
$punti=mysql_result($result,$i,"punti");
$gol_fatti=mysql_result($result,$i,"gol_fatti");
$gol_subiti=mysql_result($result,$i,"gol_subiti");




?>
<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$squadra"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$voto"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$punti"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$gol_fatti"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$gol_subiti"; ?></font></td>
</tr>

<?php

++$i;

};

?>
</table>




</body>
</html>