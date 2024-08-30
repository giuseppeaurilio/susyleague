<?php
include("menu.php");
?>
<!-- <h2>Calendario FINALI</h2> -->
<?php
class IncontroCoppa{
	
	public $idSquadraA;
	public $squadraA;
	public $idSquadraB;
	public $squadraB;
	public $idGiornataAndata;
	public $dataInizioAndata;
	public $dataFineAndata;
	public $golCasaAndata;
	public $puntiCasaAndata;
	public $golTrasfertaAndata;
	public $puntiTrasfertaAndata;
	public $idGiornataRitorno;
	public $dataInizioRitorno;
	public $dataFineRitorno;
	public $golCasaRitorno;
	public $puntiCasaRitorno;
	public $golTrasfertaRitorno;
	public $puntiTrasfertaRitorno;

	public $idSquadraVincente;
	
}
?>

<?php

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
WHERE id_girone = 7 order by id_giornata ASC";
$result=$conn->query($query);

// $num=$result->num_rows; 

$giornate = array();
while ($row=$result->fetch_assoc()) {
	echo '<div class="finale">'; 
		echo '<h1>Finale SusyLeague</h1>';
		// (($incontro->dataInizioAndata != "") ? date('d/m H:i', strtotime($incontro->dataInizioAndata)) : "")
		echo '<div class="data">'
		.(($row["inizio"] != "") ? date('d/m H:i', strtotime($row["inizio"])) : "").
		'-'
		.(($row["fine"] != "") ? date('d/m H:i', strtotime($row["fine"])) : "").
		'</div>';
		
		echo '<div class="location">Allianz Stadium di Torino</div>';
		echo '<div class="squadre">';
		echo '<div class=" squadra1">'.$row["squadracasa"].'</div>';
		echo '<div> - </div>';
		echo '<div class=" squadra2">'.$row["squadraospite"].'</div>';
		echo '</div>';
		if(!is_null($row["gol_casa"]) && !is_null($row["gol_casa"]) )
		{
			echo '<div class="score">';
			echo '<div class="punti">('.$row["punti_casa"].')</div>';
			echo '<div class="gol">'.$row["gol_casa"].'</div>';
			echo '<div> - </div>';
			echo '<div class="gol">'.$row["gol_ospiti"].'</div>';
			echo '<div class="punti">('.$row["punti_ospiti"].')</div>';
			echo '</div>';
		}
		echo '<div class="formazioni">';
		$link="display_giornata.php?&id_giornata=".$row["id_giornata"];
		echo '<a href='. $link.'>Formazioni <i class="fas fa-list-ol"></i></a>';
		echo '</div>';
		echo '<div class="commento">';
		echo '<textarea readonly rows="10" style="'.( $row["commento"]=="" ?  "display:none;" : "").'" >Il punto del presidente:'
		.$row["commento"].'</textarea> ';
		echo '</div>';
	echo '</div>';
}

// $query= "SELECT giornate.*, 
// calendario.id_sq_casa, sq1.squadra as squadracasa,
// calendario.id_sq_ospite,  sq2.squadra as squadraospite ,
// calendario.gol_casa,
// calendario.gol_ospiti,
// calendario.punti_casa,
// calendario.punti_ospiti


// FROM `giornate` 
// left join `calendario` on `giornate`.`id_giornata` =  `calendario`.`id_giornata` 
// left join `sq_fantacalcio` sq1 on `calendario`.`id_sq_casa` =  `sq1`.`id`
// left join `sq_fantacalcio` sq2 on `calendario`.`id_sq_ospite` =  `sq2`.`id`
// WHERE id_girone = 8 order by id_giornata ASC";
// $result=$conn->query($query);

// $num=$result->num_rows; 

// $giornate = array();
// while ($row=$result->fetch_assoc()) {
// 	echo '<div>';
// 		echo '<h1>Supercoppa</h1>';
// 		echo '<div>'.$row["inizio"].'-'.$row["fine"].'</div>';
// 		echo '<div>StadioOlimpico di Roma</div>';
// 		echo '<div>'.$row["squadracasa"].'</div>';
// 		echo '<div>'.$row["squadraospite"].'</div>';
// 		if(!is_null($row["gol_casa"]) && !is_null($row["gol_casa"]) )
// 		{
// 			echo '<div>'.$row["gol_casa"].'</div>';
// 			echo '<div>'.$row["gol_ospiti"].'</div>';
// 			echo '<div>'.$row["punti_casa"].'</div>';
// 			echo '<div>'.$row["punti_ospiti"].'</div>';

// 		}
// 		$link="display_giornata.php?&id_giornata=".$row["id_giornata"];
// 		echo '<a href='. $link.'>Dettaglio</a>';
// 	echo '</div>';
// }



?>
<?php 
include("footer.php");
?>