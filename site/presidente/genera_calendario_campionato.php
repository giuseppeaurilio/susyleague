<?php
include("menu.php");

?>
<script>
GeneraCalendarioCampionato = function(id)
{
    var action ="generaanno";
    $.ajax({
        type:'POST',
            url:'genera_calendario_campionato_controller.php',
            data: {
                "action": action,
            },
            success:function(data){
				modalPopupResult(data);0
            }
    }); 
}

$(document).ready(function(){
	$("#btnGeneraCalendarioCampionato").click(GeneraCalendarioCampionato);
})
</script>

<h1>Campionato Susy League</h1>
<div style="text-align:center;">
Clicca <input type="button" style="width: 100px; padding: 5px; background-color: red;" value="GENERA" id="btnGeneraCalendarioCampionato"/> per generare i calendari di apertura e chiusura.
</div>
<h2>Apertura</h1>
<?php
$id_girone = 1;
$query="SELECT id_giornata
FROM giornate  
where id_girone=$id_girone
order by id_giornata ASC";
$result=$conn->query($query);

$num=$result->num_rows; 
if($num >0){
	$idgiornate = array();
	while ($row=$result->fetch_assoc()) {
		array_push($idgiornate, $row["id_giornata"]);
	}
	foreach($idgiornate as $id){
		$query2="SELECT c.id_partita, sq1.squadra as sqcasa, sq2.squadra as sqospite
		FROM calendario as c
        left join sq_fantacalcio as sq1 on sq1.id = c.id_sq_casa
        left join sq_fantacalcio as sq2 on sq2.id = c.id_sq_ospite
		where c.id_giornata=".$id." 
		order by c.id_partita";

		$result_giornata=$conn->query($query2);
		echo "<h3>Giornata ".$id."</h3>";
		echo "<table>
				<tr> 
					<th style='width: 50%;text-align:center;'>Casa</th>
					<th style='width: 50%;text-align:center;'>Ospite</th>
				</tr>";
		while ($row=$result_giornata->fetch_assoc()) {
			echo "<tr>";
				echo "<td style='text-align:center;'> ". $row["sqcasa"] ."</td>";
				echo "<td style='text-align:center;'> " . $row["sqospite"] ."</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
}
else
{
	echo "Calendario non generato";
}
?>
<h2>Chiusura</h1>
<?php
$id_girone = 2;
$query="SELECT id_giornata
FROM giornate  
where id_girone=$id_girone
order by id_giornata ASC";
$result=$conn->query($query);

$num=$result->num_rows; 
if($num >0){
	$idgiornate = array();
	while ($row=$result->fetch_assoc()) {
		array_push($idgiornate, $row["id_giornata"]);
	}
	foreach($idgiornate as $id){
		$query2="SELECT c.id_partita, sq1.squadra as sqcasa, sq2.squadra as sqospite
		FROM calendario as c
        left join sq_fantacalcio as sq1 on sq1.id = c.id_sq_casa
        left join sq_fantacalcio as sq2 on sq2.id = c.id_sq_ospite
		where c.id_giornata=".$id." 
		order by c.id_partita";

		include_once("..\DB/calendario.php");
		$result_giornata=$conn->query($query2);
		echo "<h3>Giornata ".getDescrizioneGiornata($id)."</h3>";
		echo "<table>
				<tr> 
					<th style='width: 50%;text-align:center;'>Casa</th>
					<th style='width: 50%;text-align:center;'>Ospite</th>
				</tr>";
		while ($row=$result_giornata->fetch_assoc()) {
			echo "<tr>";
				echo "<td style='text-align:center;'> ". $row["sqcasa"] ."</td>";
				echo "<td style='text-align:center;'> " . $row["sqospite"] ."</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
}
else
{
	echo "Calendario non generato";
}
?>

<?php 
include("../footer.php");
?>