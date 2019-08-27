<?php
include("menu.php");

?>
<!-- <link href="style.css" rel="stylesheet" type="text/css">

<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}

</style> -->
<div id="maincontent">


<?php
include("dbinfo_susyleague.inc.php");
#echo $username;
// Create connection
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";



$query="SELECT * from gironi";



$result_girone = $conn->query($query);
$num_gironi=$result_girone->num_rows; 
//echo $num_gironi;
$num_gironi=2;
$j=0;
//echo "prova";
//print_r( $result_girone); 
//echo "prova1";
while ($row = $result_girone->fetch_assoc() and $j<$num_gironi) {
	$id_girone=$row["id_girone"];
	$nome_girone=$row["nome"];

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
//	echo $query;

	$result=$conn->query($query);

	$num=$result->num_rows; 

	$i=0;
	while ($row = $result->fetch_assoc()) {

		$id_squadra=$row["id_squadra"];
		$squadra=$row["squadra"];
		$punti=$row["punti"];
		$voto=$row["voti"];
		$gol_fatti=$row["gol_fatti"];
		$gol_subiti=$row["gol_subiti"];
		$vittorie=$row["vittorie"];
		$pareggi=$row["pareggi"];
		$sconfitte=$row["sconfitte"];

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

	$result=$conn->query($query);

	$num=$result->num_rows; 

	$i=0;
	while ($row = $result->fetch_assoc()) {


		$id_squadra=$row["id_squadra"];
		$squadra=$row["squadra"];
		$voto=$row["voti"];
		$punti=$row["punti"];
		$gol_fatti=$row["gol_fatti"];
		$gol_subiti=$row["gol_subiti"];
		$vittorie=$row["vittorie"];
		$pareggi=$row["pareggi"];
		$sconfitte=$row["sconfitte"];


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

$result=$conn->query($query);

$num=$result->num_rows; 
#echo $num;
$i=0;

	while ($row = $result->fetch_assoc()) {

		$id_squadra=$row["id_squadra"];
		$squadra=$row["squadra"];
		$voto=$row["voti"];
		$punti=$row["punti"];
		$gol_fatti=$row["gol_fatti"];
		$gol_subiti=$row["gol_subiti"];
		$vittorie=$row["vittorie"];
		$pareggi=$row["pareggi"];
		$sconfitte=$row["sconfitte"];


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

$partite=array();


$query_winner="SELECT * from vincitori as a left join sq_fantacalcio as b on a.id_vincitore=b.id";

$result_winner=$conn->query($query_winner);
$num_winner=$result_winner->num_rows;


$j=0;
while ($row=$result_winner->fetch_assoc()) {
  $competizione=$row["competizione"];
  $vincitore=$row["squadra"];
  $vincitori[$competizione]=$vincitore;
  $j=$j+1;
}


for ($i = 34; $i <= 37; $i++) {
	
	$query2="SELECT b.squadra as sq_casa, c.squadra as sq_ospite ,a.id_partita,a.id_giornata FROM calendario as a left join sq_fantacalcio as b on a.id_sq_casa=b.id  left join sq_fantacalcio as c on a.id_sq_ospite=c.id where a.id_giornata=" . $i. " order by a.id_partita" ;
//	echo $query2;
	
#echo $query2;
	$result_giornata=$conn->query($query2);
	$num_giornata=$result_giornata->num_rows;
	$j=0;
//	echo "<br>result giornata";
//	print_r($result_giornata);
	$partite_giornata=array();
	if ($num_giornata > 0) {
		while ($row = $result_giornata->fetch_assoc()) {

			$query="select d.gol_casa, d.gol_ospite, d.voto_casa, d.voto_ospite from punteggio_finale as d  where id_giornata=".$i ." and id_partita=" . $row["id_partita"] ;
//			print_r($row);
//			echo "<br>query_risultati= " . $query;
			$risultati=$conn->query($query);
			$num_risultati=$risultati->num_rows;
//			echo "<br>risultati= ";
//			print_r($risultati);
			$punti_casa="";
			$gol_casa="";
			$gol_ospite="";
			$punti_ospite="";


				
			$results_temp=$risultati->fetch_assoc();
//			echo "<br> results_temp=";
//			print_r($results_temp);
			$punti_casa=$results_temp["voto_casa"];
			$gol_casa=$results_temp["gol_casa"];
			$gol_ospite=$results_temp["gol_ospite"];
			$punti_ospite=$results_temp["voto_ospite"];


			$sq_casa=$row["sq_casa"];
			$sq_ospite=$row["sq_ospite"];

			$partita=array("sq_casa" => $sq_casa,"gol_casa" => $gol_casa,"sq_ospite" => $sq_ospite,"gol_ospite" => $gol_ospite);
//			echo"<br> PARTITA=";
//			print_r($partita);
			$partite_giornata[$j]=$partita;

			++$j;
		} 
//		echo "<br> PArtite_giornata <br>";
//		print_r ($partite_giornata);
		$partite[$i-34]=$partite_giornata;
	} // some information about 
}
//echo("<br><br>Partite");
//print_r($partite);
//echo $partite[0][0];


?>

<h2>Play OFF</h2>
<main id="Play_off">



	<ul class="round round-1">
		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top"><?php echo $partite[0][0]["sq_casa"] ."  -  ". $partite[0][0]["gol_casa"];?></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "><?php echo $partite[0][0]["sq_ospite"] ."  -  ". $partite[0][0]["gol_ospite"];?></li>

		<li class="spacer">&nbsp;</li>
		<li class="spacer">&nbsp;</li>		
		
		<li class="spacer">&nbsp;</li>
		<li class="spacer">&nbsp;</li>

		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top "><?php echo $partite[0][1]["sq_casa"] ."  -  ". $partite[0][1]["gol_casa"];?></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom"><?php echo $partite[0][1]["sq_ospite"] ."  -  ". $partite[0][1]["gol_ospite"];?></li>

		<li class="spacer">&nbsp;</li>
		
		<li class="spacer">&nbsp;</li>
		<li class="spacer">&nbsp;</li>
		<li class="spacer">&nbsp;</li>

		<li class="spacer">&nbsp;</li>
	</ul>
	<ul class="round round-2">
		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top"><?php echo $partite[1][0]["sq_casa"]."  -  ".  $partite[1][0]["gol_casa"];?></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "><?php echo $partite[1][0]["sq_ospite"]."  -  ".  $partite[1][0]["gol_ospite"];?></li>

		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top"><?php echo $partite[1][1]["sq_casa"] ."  -  ".  $partite[1][1]["gol_casa"];?></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "><?php echo $partite[1][1]["sq_ospite"] ."  -  ".  $partite[1][1]["gol_ospite"];?></li>

		<li class="spacer">&nbsp;</li>
	</ul>
	<ul class="round round-3">
		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top"><?php echo $partite[2][0]["sq_casa"] ."  -  ".  $partite[2][0]["gol_casa"];?></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "><?php echo $partite[2][0]["sq_ospite"] ."  -  ".  $partite[2][0]["gol_ospite"];?></li>

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
		
		<li class="game game-top"><?php echo $partite[0][2]["sq_casa"] ."  -  ".   $partite[0][2]["gol_casa"];?></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "><?php echo $partite[0][2]["sq_ospite"] ."  -  ".   $partite[0][2]["gol_ospite"];?></li>

		<li class="spacer">&nbsp;</li>
		<li class="spacer">&nbsp;</li>		
		
		<li class="spacer">&nbsp;</li>
		<li class="spacer">&nbsp;</li>

		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top "><?php echo $partite[0][3]["sq_casa"] ."  -  ".   $partite[0][3]["gol_casa"];?></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom"><?php echo $partite[0][3]["sq_ospite"] ."  -  ".   $partite[0][3]["gol_ospite"];?></li>

		<li class="spacer">&nbsp;</li>
		
		<li class="spacer">&nbsp;</li>
		<li class="spacer">&nbsp;</li>
		<li class="spacer">&nbsp;</li>

		<li class="spacer">&nbsp;</li>
	</ul>
	<ul class="round round-2">
		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top"><?php echo $partite[1][2]["sq_casa"] ."  -  ".   $partite[1][2]["gol_casa"];?></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "><?php echo $partite[1][2]["sq_ospite"] ."  -  ".   $partite[1][2]["gol_ospite"];?></li>

		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top"><?php echo $partite[1][3]["sq_casa"] ."  -  ".   $partite[1][3]["gol_casa"];?></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "><?php echo $partite[1][3]["sq_ospite"] ."  -  ".   $partite[1][3]["gol_ospite"];?></li>

		<li class="spacer">&nbsp;</li>
	</ul>
	<ul class="round round-3">
		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top"><?php echo $partite[2][1]["sq_casa"] ."  -  ".   $partite[2][1]["gol_casa"];?></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "><?php echo $partite[2][1]["sq_ospite"] ."  -  ".   $partite[2][1]["gol_ospite"];?></li>

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
		
		<li class="game game-top"><?php echo $partite[3][0]["sq_casa"] ."  -  ".   $partite[3][0]["gol_casa"];?></li>
		<li class="game game-spacer">&nbsp;</li>
		<li class="game game-bottom "><?php echo $partite[3][0]["sq_ospite"] ."  -  ".   $partite[3][0]["gol_ospite"];?></li>

		<li class="spacer">&nbsp;</li>
	</ul>
	<ul class="round round-2">
		<li class="spacer">&nbsp;</li>
		
		<li class="game game-top"><?php echo $vincitori["coppa_delle_coppe"]; ?></li>
		<li class="spacer">&nbsp;</li>
	
	</ul>
</main>
</div>
</body>
</html>
