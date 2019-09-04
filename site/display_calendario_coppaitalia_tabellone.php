<?php
include("menu.php");
?>
<h2>Calendario FINALI</h2>
<?php

include("dbinfo_susyleague.inc.php");

// Create connection
$conn = new mysqli($localhost, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";

$query= "SELECT giornate.*, 
calendario.id_sq_casa, sq1.squadra as squadracasa,
calendario.id_sq_ospite,  sq2.squadra as squadraospite ,
calendario.gol_casa,
calendario.gol_ospiti,
calendario.punti_casa,
calendario.punti_ospiti


FROM `giornate` 
left join `calendario` on `giornate`.`id_giornata` =  `calendario`.`id_giornata` 
left join `sq_fantacalcio` sq1 on `calendario`.`id_sq_casa` =  `sq1`.`id`
left join `sq_fantacalcio` sq2 on `calendario`.`id_sq_ospite` =  `sq2`.`id`
WHERE id_girone = 5 order by id_giornata ASC";
$result=$conn->query($query);

$num=$result->num_rows; 

$giornate = array();
while ($row=$result->fetch_assoc()) {
	echo '<div>';
		// echo '<h1>Finale Coppa Italia</h1>';
		echo '<div>'.$row["inizio"].'-'.$row["fine"].'</div>';
		echo '<div>StadioOlimpico di Roma</div>';
		echo '<div>'.$row["squadracasa"].'</div>';
		echo '<div>'.$row["squadraospite"].'</div>';
		if(!is_null($row["gol_casa"]) && !is_null($row["gol_casa"]) )
		{
			echo '<div>'.$row["gol_casa"].'</div>';
			echo '<div>'.$row["gol_ospiti"].'</div>';
			echo '<div>'.$row["punti_casa"].'</div>';
			echo '<div>'.$row["punti_ospiti"].'</div>';

		}
		$link="display_giornata.php?&id_giornata=".$row["id_giornata"];
		echo '<a href='. $link.'>Dettaglio</a>';
	echo '</div>';
}

?>

<?php
include("footer.html");

?>

</body>
</html>