<?php
include("menu.php");

?>
<link href="style.css" rel="stylesheet" type="text/css">
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}

</style>



<?php
include("dbinfo_susyleague.inc.php");
#echo $username;
mysql_connect($localhost,$username,$password);
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

$query="SELECT id_squadra,squadra,sum(voti) as voti ,sum(punti) as punti, sum(gol_fatti) as gol_fatti, sum(gol_subiti) as gol_subiti, sum(vittorie) as vittorie, sum(pareggi) as pareggi, sum(sconfitte) as sconfitte from classifiche where (id_girone=1) or (id_girone=2) group by id_squadra ORDER BY punti DESC,voti DESC,squadra";

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

<h1>Girone Finale</h1>


<?php
include("dbinfo_susyleague.inc.php");
#echo $username;
mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$partite=array();
for ($i = 34; $i <= 37; $i++) {
$query2="SELECT b.squadra as sq_casa, c.squadra as sq_ospite FROM calendario as a left join sq_fantacalcio as b on a.id_sq_casa=b.id  left join sq_fantacalcio as c on a.id_sq_ospite=c.id where a.id_giornata=" . $i. " order by a.id_partita" ;
#echo $query2;
#echo $query2;
$result_giornata=mysql_query($query2);
$num_giornata=mysql_numrows($result_giornata);

$query_winner="SELECT * from vincitori as a inner join sq_fantacalcio as b on a.id_vincitore=b.id";
$result_winner=mysql_query($query_winner);
$num_winner=mysql_numrows($result_winner);


$j=0;
while ($j < $num_winner) {
  $competizione=mysql_result($result_winner,$j,"competizione");
  $vincitore=mysql_result($result_winner,$j,"squadra");
  $vincitori[$competizione]=$vincitore;
  $j=$j+1;
}



$j=0;
while ($j < $num_giornata) {

$query="select d.gol_casa, d.gol_ospite, d.voto_casa, d.voto_ospite from punteggio_finale as d  where id_giornata=".$i ." and id_partita=" . ($j+1) ;
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

$partita=array("sq_casa" => $sq_casa,"gol_casa" => $gol_casa,"sq_ospite" => $sq_ospite,"gol_ospite" => $gol_ospite);
++$j;
array_push($partite,$partita);
} 

}
//echo("PArtite");
//print_r($partite);
//echo $partite[0][0];


?>

<h2>Play OFF</h2>
<main id="Play_off">



	<ul class="round round-1">
		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top"><?php echo $partite[0]["sq_casa"] ."  -  ". $partite[0]["gol_casa"];?></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "><?php echo $partite[0]["sq_ospite"] ."  -  ". $partite[0]["gol_ospite"];?></li>

		<li class="spacer">&nbsp;</li>
		<li class="spacer">&nbsp;</li>		
		
		<li class="spacer">&nbsp;</li>
		<li class="spacer">&nbsp;</li>

		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top "><?php echo $partite[1]["sq_casa"] ."  -  ". $partite[1]["gol_casa"];?></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom"><?php echo $partite[1]["sq_ospite"] ."  -  ". $partite[1]["gol_ospite"];?></li>

		<li class="spacer">&nbsp;</li>
		
		<li class="spacer">&nbsp;</li>
		<li class="spacer">&nbsp;</li>
		<li class="spacer">&nbsp;</li>

		<li class="spacer">&nbsp;</li>
	</ul>
	<ul class="round round-2">
		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top"><?php echo $partite[4]["sq_casa"]."  -  ".  $partite[4]["gol_casa"];?></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "><?php echo $partite[4]["sq_ospite"]."  -  ".  $partite[4]["gol_ospite"];?></li>

		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top"><?php echo $partite[5]["sq_casa"] ."  -  ".  $partite[5]["gol_casa"];?></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "><?php echo $partite[5]["sq_ospite"] ."  -  ".  $partite[5]["gol_ospite"];?></li>

		<li class="spacer">&nbsp;</li>
	</ul>
	<ul class="round round-3">
		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top"><?php echo $partite[8]["sq_casa"] ."  -  ".  $partite[8]["gol_casa"];?></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "><?php echo $partite[8]["sq_ospite"] ."  -  ".  $partite[8]["gol_ospite"];?></li>

		<li class="spacer">&nbsp;</li>	
	</ul>
	<ul class="round round-4">
		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top"><?php echo $vincitori["play_off"]; ?></li>
			<li class="spacer">&nbsp;</li>
	</ul>
</main>

<h2>Play OUT</h2>
<main id="Play_out">



	<ul class="round round-1">
		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top"><?php echo $partite[2]["sq_casa"] ."  -  ".   $partite[2]["gol_casa"];?></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "><?php echo $partite[2]["sq_ospite"] ."  -  ".   $partite[2]["gol_ospite"];?></li>

		<li class="spacer">&nbsp;</li>
		<li class="spacer">&nbsp;</li>		
		
		<li class="spacer">&nbsp;</li>
		<li class="spacer">&nbsp;</li>

		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top "><?php echo $partite[3]["sq_casa"] ."  -  ".   $partite[3]["gol_casa"];?></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom"><?php echo $partite[3]["sq_ospite"] ."  -  ".   $partite[3]["gol_ospite"];?></li>

		<li class="spacer">&nbsp;</li>
		
		<li class="spacer">&nbsp;</li>
		<li class="spacer">&nbsp;</li>
		<li class="spacer">&nbsp;</li>

		<li class="spacer">&nbsp;</li>
	</ul>
	<ul class="round round-2">
		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top"><?php echo $partite[6]["sq_casa"] ."  -  ".   $partite[6]["gol_casa"];?></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "><?php echo $partite[6]["sq_ospite"] ."  -  ".   $partite[6]["gol_ospite"];?></li>

		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top"><?php echo $partite[7]["sq_casa"] ."  -  ".   $partite[7]["gol_casa"];?></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "><?php echo $partite[7]["sq_ospite"] ."  -  ".   $partite[7]["gol_ospite"];?></li>

		<li class="spacer">&nbsp;</li>
	</ul>
	<ul class="round round-3">
		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top"><?php echo $partite[9]["sq_casa"] ."  -  ".   $partite[9]["gol_casa"];?></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "><?php echo $partite[9]["sq_ospite"] ."  -  ".   $partite[9]["gol_ospite"];?></li>

		<li class="spacer">&nbsp;</li>	
	</ul>
	<ul class="round round-4">
		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top"><?php echo $vincitori["play_out"]; ?></li>
			<li class="spacer">&nbsp;</li>
	</ul>

</main>

<h2>Coppa delle Coppe</h2>
<main id="Coppa">



	<ul class="round round-1">
		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top"><?php echo $partite[11]["sq_casa"] ."  -  ".   $partite[11]["gol_casa"];?></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "><?php echo $partite[11]["sq_ospite"] ."  -  ".   $partite[11]["gol_ospite"];?></li>

		<li class="spacer">&nbsp;</li>
	</ul>
	<ul class="round round-2">
		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top"><?php echo $vincitori["coppa_delle_coppe"]; ?></li>
		<li class="spacer">&nbsp;</li>
	
	</ul>
</main>

</body>
</html>
