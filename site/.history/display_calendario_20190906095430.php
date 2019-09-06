<?php
include("menu.php");
$id_girone=$_GET['id_girone'];
?>
<h2>Calendario</h2>


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

$time_start=microtime(true);

$query="SELECT * FROM giornate where id_girone=". $id_girone . " order by id_giornata ASC";
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




	<h2>Giornata <?php  echo $id; ?>
	 <a href="<?php  echo $link.$id; ?>">(dettaglio giornata)</a></h2>

	<h3><?php echo $inizio ."  -->  " .$fine ;?></h3>


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


	<textarea readonly rows="10" style="width:100%;">Il punto del presidente:
	<?php echo $commento; ?>
	</textarea> 


	<?php





	++$i;
} 

// mysql_close();
$conn->close();

?>
<?php
include("footer.html");

?>

</body>
</html>
