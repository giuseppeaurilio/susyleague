<?php
include_once ("menu.php");
$id_girone=$_GET['id_girone'];
$strCampionato = "";
if($id_girone == 1) $strCampionato = "Apertura";
if($id_girone == 2) $strCampionato = "Chiusura";
if($id_girone == 6) $strCampionato = "Coppa delle coppe";
?>

<h2>Calendario <?php echo  $strCampionato ?></h2>


<?php

$time_start=microtime(true);

$query="SELECT g.id_giornata, ga.inizio, ga.fine, g.commento
FROM giornate as g
LEFT JOIN giornate_serie_a as ga on g.giornata_serie_a_id = ga.id
where id_girone=". $id_girone . " order by id_giornata ASC";
$result=$conn->query($query);

$num=$result->num_rows; 

$time_end=microtime(true);
$time = $time_end - $time_start;

#echo "first query" . $time . "<br>";

#echo "<b><left>Squadre</center></b><br><br>";


$i=0;
while ($row=$result->fetch_assoc()) {


	$time_start=microtime(true);
	$id=$row["id_giornata"];
	$inizio=$row["inizio"];
	$fine=$row["fine"];
	$commento=$row["commento"];

	$time_end=microtime(true);
	$time = $time_end - $time_start;

	#echo "query" . $time . "<br>";


	$time_start=microtime(true);
	#$query2="SELECT b.squadra as sq_casa, c.squadra as sq_ospite, a.gol_casa, a.gol_ospiti, a.punti_casa, a.punti_ospiti FROM calendario as a inner join sq_fantacalcio as b on a.id_sq_casa=b.id inner join sq_fantacalcio as c on a.id_sq_ospite=c.id where a.id_giornata=".$id ." order by a.id_partita" ;
	$query2="SELECT b.squadra as sq_casa, c.squadra as sq_ospite, 
	a.gol_casa, a.gol_ospiti as gol_ospite, a.punti_casa as voto_casa, a.punti_ospiti as voto_ospite
	FROM calendario as a 
	inner join sq_fantacalcio as b on a.id_sq_casa=b.id 
	inner join sq_fantacalcio as c on a.id_sq_ospite=c.id 
	where a.id_giornata=". $id ." 
	order by a.id_partita";
	// echo $query2;
	#echo $query2;
	$result_giornata=$conn->query($query2);
	$num_giornata=$result_giornata->num_rows;
	#echo "partite nuemro = " . $num_giornata;

	$time_end=microtime(true);
	$time = $time_end - $time_start;

	#echo "query 2 " . $time . "<br>";

	$link="display_giornata.php?&id_giornata=";
	?>



<div class="calendario_giornata">
	<h3>Giornata <?php  echo $id> 76? $id-76: $id; ?>
	
	<?php echo "(". (($inizio!= "") ? date('d/m H:i', strtotime($inizio)) : "") ."  -  " .(($fine!= "") ? date('d/m H:i', strtotime($fine)) : ""). ")" ;?>
	
	</h3>
	<h4><a href="<?php  echo $link.$id; ?>"> Formazioni <i class="fas fa-list-ol"></i></a></h4>
	<table>
	<tr> 

	<th>Casa</th>
	<th>Ospite</th>

	<th>gol</th>

	<th>gol</th>
	<th>punti</th>
	<th>punti</th>
	</tr>
	<?php

	$j=0;
	while ($row=$result_giornata->fetch_assoc()) {


		$punti_casa="";
		$gol_casa="";
		$gol_ospite="";
		$punti_ospite="";

		$sq_casa=$row["sq_casa"];
		$sq_ospite=$row["sq_ospite"];
		$punti_casa=$row["voto_casa"];
		$gol_casa=$row["gol_casa"];
		$gol_ospite=$row["gol_ospite"];
		$punti_ospite=$row["voto_ospite"];

		?>


		<tr> 

		<td><?php echo "$sq_casa"; ?></td>
		<td><?php echo "$sq_ospite"; ?></td>

		<td><?php echo "$gol_casa"; ?></td>
		<td><?php echo "$gol_ospite"; ?></td>
		<td><?php echo "$punti_casa"; ?></td>
		<td><?php echo "$punti_ospite"; ?></td>
		</tr>

		<?php
		++$j;

	} 

	?>
	</table>

	<!--  -->
	<textarea readonly rows="10" style='<?php echo( $commento=="" ?  "display:none;" : "") ?> ' >Il punto del presidente:
	<?php echo $commento; ?>
	</textarea> 
	</div>

	<?php





	++$i;
} 

// mysql_close();
?>

<?php 
include_once ("footer.php");
?>
