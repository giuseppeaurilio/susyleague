<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}

</style>



<h1>Classifiche</h1>

<h2>Classifica Punti</h2>
<table border="0" cellspacing="2" cellpadding="2">
<tr> 

<th><font face="Arial, Helvetica, sans-serif">Squadra</font></th>
<th><font face="Arial, Helvetica, sans-serif">Punti</font></th>
<th><font face="Arial, Helvetica, sans-serif">Voti</font></th>
<th><font face="Arial, Helvetica, sans-serif">V</font></th>
<th><font face="Arial, Helvetica, sans-serif">N</font></th>
<th><font face="Arial, Helvetica, sans-serif">P</font></th>
<th><font face="Arial, Helvetica, sans-serif">GF</font></th>
<th><font face="Arial, Helvetica, sans-serif">GS</font></th>

</tr>


<?php 
include("dbinfo_susyleague.inc.php");
#echo $username;
mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


$query="SELECT * from classifiche order BY punti DESC,voti DESC, squadra";
 
$result=mysql_query($query);

$num=mysql_numrows($result); 
#echo $num;
$i=0;
while ($i < $num) {

$id_squadra=mysql_result($result,$i,"id_squadra");
$squadra=mysql_result($result,$i,"squadra");
$punti=mysql_result($result,$i,"punti");
$voto=mysql_result($result,$i,"voti");
$gol_fatti=mysql_result($result,$i,"gol_fatti");
$gol_subiti=mysql_result($result,$i,"gol_subiti");
$vittorie=mysql_result($result,$i,"vittorie");
$pareggi=mysql_result($result,$i,"pareggi");
$sconfitte=mysql_result($result,$i,"sconfitte");

?>
<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$squadra"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$punti"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$voto"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$vittorie"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$pareggi"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$sconfitte"; ?></font></td>
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
<th><font face="Arial, Helvetica, sans-serif">Voti</font></th>
<th><font face="Arial, Helvetica, sans-serif">Punti</font></th>
<th><font face="Arial, Helvetica, sans-serif">V</font></th>
<th><font face="Arial, Helvetica, sans-serif">N</font></th>
<th><font face="Arial, Helvetica, sans-serif">P</font></th>
<th><font face="Arial, Helvetica, sans-serif">GF</font></th>
<th><font face="Arial, Helvetica, sans-serif">GS</font></th>

</tr>


<?php 
include("dbinfo_susyleague.inc.php");
#echo $username;
mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


$query=" SELECT * from classifiche ORDER BY voti DESC,punti DESC,squadra";
 
$result=mysql_query($query);

$num=mysql_numrows($result); 
#echo $num;
$i=0;
while ($i < $num) {

$id_squadra=mysql_result($result,$i,"id_squadra");
$squadra=mysql_result($result,$i,"squadra");
$voto=mysql_result($result,$i,"voti");
$punti=mysql_result($result,$i,"punti");
$gol_fatti=mysql_result($result,$i,"gol_fatti");
$gol_subiti=mysql_result($result,$i,"gol_subiti");
$vittorie=mysql_result($result,$i,"vittorie");
$pareggi=mysql_result($result,$i,"pareggi");
$sconfitte=mysql_result($result,$i,"sconfitte");




?>
<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$squadra"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$voto"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$punti"; ?></font></td>

<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$vittorie"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$pareggi"; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php  echo "$sconfitte"; ?></font></td>
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