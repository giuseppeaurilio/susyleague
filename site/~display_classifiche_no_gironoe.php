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

<?php
include("dbinfo_susyleague.inc.php");
#echo $username;
mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query="SELECT * from gironi";
$result_girone=mysql_query($query);
$num_gironi=mysql_numrows($result_girone); 

$num_gironi=2;
$j=0;


while ($j < $num_gironi) {
$id_girone=mysql_result($result_girone,$j,"id_girone");
$nome_girone=mysql_result($result_girone,$j,"nome");

?>

<h1 style="color:red;">Classifiche Girone <?php echo $nome_girone ?> </h1>

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



$query="SELECT * from classifiche where id_girone=" .$id_girone . " order BY punti DESC,voti DESC, squadra ";

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

$query=" SELECT * from classifiche where id_girone=" . $id_girone ." ORDER BY voti DESC,punti DESC,squadra";

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

<?php
++$j;

}; 

?>

<!--   CLASSIFICA SOMMA  -->
<h1 style="color:blue;">Classifiche Aggregate </h1>
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

$query="SELECT id_squadra,squadra,sum(voti) as voti ,sum(punti) as punti, sum(gol_fatti) as gol_fatti, sum(gol_subiti) as gol_subiti, sum(vittorie) as vittorie, sum(pareggi) as pareggi, sum(sconfitte) as sconfitte from classifiche group by id_squadra ORDER BY punti DESC,voti DESC,squadra";

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





</body>
</html>