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
	public $commentoAndata;
	public $commentoRitorno;

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
$index = 0;
$id_giornata_andata = "";
$inizio_a_andata= "";
$fine_a_andata= "";
$gol_casa_andata= "";
$gol_ospiti_andata= "";
$punti_casa_andata= "";
$punti_ospiti_andata= "";
$id_giornata_ritorno= "";
$inizio_a_ritorno= "";
$fine_a_ritorno= "";
$gol_casa_ritorno= "";
$gol_ospiti_ritorno= "";
$punti_casa_ritorno= "";
$punti_ospiti_ritorno= "";
$commentoAndata= "";
$commentoRitorno= "";
$giornate = array();
while ($row=$result->fetch_assoc()) {
    
	if($index == 0)
	{
		$id_sq1=$row["id_sq_casa"];
		$sq1=$row["squadracasa"];
		$id_sq2=$row["id_sq_ospite"];
		$sq2=$row["squadraospite"];
		$id_giornata_andata=$row["id_giornata"];
		$inizio_andata=$row["inizio"];
		$fine_andata=$row["fine"];
		$inizio_a_andata=$row["inizio"];//date_parse($inizio_andata);
		$fine_a_andata=$row["fine"];//date_parse($fine_andata);
		if(!is_null($row["gol_casa"]) && !is_null($row["gol_casa"]) )
		{
			$gol_casa_andata=$row["gol_casa"];
			$gol_ospiti_andata=$row["gol_ospiti"];
			$punti_casa_andata=$row["punti_casa"];
			$punti_ospiti_andata=$row["punti_ospiti"];
			$commentoAndata = $row["commento"];
		}
		$index =1;
	}
	else
	{
		$id_giornata_ritorno=$row["id_giornata"];
		// $inizio_ritorno=$row["inizio"];
		// $fine_ritorno=$row["fine"];
		$inizio_a_ritorno=$row["inizio"];//date_parse($inizio_ritorno);
		$fine_a_ritorno=$row["fine"];//date_parse($fine_ritorno);
		if(!is_null($row["gol_casa"]) && !is_null($row["gol_casa"]) )
		{
			$gol_casa_ritorno=$row["gol_casa"];
			$gol_ospiti_ritorno=$row["gol_ospiti"];
			$punti_casa_ritorno=$row["punti_casa"];
			$punti_ospiti_ritorno=$row["punti_ospiti"];
			$commentoRitorno = $row["commento"];
		}
		$index =2;
	}
	if($index == 2)
	{
		$incontroCoppa = new IncontroCoppa;
		$incontroCoppa->idSquadraA  = $id_sq1;
		$incontroCoppa->squadraA  = $sq1;
		$incontroCoppa->idSquadraB  = $id_sq2;
		$incontroCoppa->squadraB  = $sq2;

		$incontroCoppa->idGiornataAndata = $id_giornata_andata;
		$incontroCoppa->dataInizioAndata = $inizio_a_andata;
		$incontroCoppa->dataFineAndata = $fine_a_andata;
		$incontroCoppa->golCasaAndata = $gol_casa_andata;
		$incontroCoppa->puntiCasaAndata = $gol_ospiti_andata;
		$incontroCoppa->golTrasfertaAndata = $punti_casa_andata;
		$incontroCoppa->puntiTrasfertaAndata = $punti_ospiti_andata;

		$incontroCoppa->idGiornataRitorno = $id_giornata_ritorno;
		$incontroCoppa->dataInizioRitorno = $inizio_a_ritorno;
		$incontroCoppa->dataFineRitorno = $fine_a_ritorno;
		$incontroCoppa->golCasaRitorno = $gol_casa_ritorno;
		$incontroCoppa->puntiCasaRitorno = $gol_ospiti_ritorno;
		$incontroCoppa->golTrasfertaRitorno = $punti_casa_ritorno;
		$incontroCoppa->puntiTrasfertaRitorno = $punti_ospiti_ritorno;

		$incontroCoppa->commentoAndata = $commentoAndata;
		$incontroCoppa->commentoRitorno = $commentoRitorno;

		
		array_push($giornate,$incontroCoppa);
		$index =0;
	}
  
}
foreach ($giornate as $partita) {
	echo '<div class="finale">'; 
		echo '<h1>Finale SusyLeague</h1>';
		// (($incontro->dataInizioAndata != "") ? date('d/m H:i', strtotime($incontro->dataInizioAndata)) : "")
		echo '<div class="data">'
		.(($partita->dataInizioAndata != "") ? date('d/m H:i', strtotime($partita->dataInizioAndata)) : "").
		'-'
		.(($partita->dataFineAndata != "") ? date('d/m H:i', strtotime($partita->dataFineAndata)) : "").
		'</div>';
		
		echo '<div class="location">Allianz Stadium di Torino</div>';
		echo '<div class="squadre">';
		echo '<div class=" squadra1">'.$partita->squadraA.'</div>';
		echo '<div> - </div>';
		echo '<div class=" squadra2">'.$partita->squadraB.'</div>';
		echo '</div>';
		if(!empty($partita->golCasaAndata))
		{
			echo $partita->golCasaAndata;
			echo '<div class="score">';
			echo '<div class="punti">('.$partita->puntiCasaAndata.')</div>';
			echo '<div class="gol">'.$partita->golCasaAndata.'</div>';
			echo '<div> - </div>';
			echo '<div class="gol">'.$partita->golTrasfertaAndata.'</div>';
			echo '<div class="punti">('.$partita->puntiTrasfertaAndata.')</div>';
			echo '</div>';
		}
		echo '<div class="formazioni">';
		$link="display_giornata.php?&id_giornata=".$partita->idGiornataAndata;
		echo '<a href='. $link.'>Formazioni Andata <i class="fas fa-list-ol"></i></a>';
		echo '</div>';
		echo '<div class="commento" style="'.( $partita->commentoAndata == "" ?  "display:none;" : "").'" >';
		echo '<textarea readonly rows="10" >Il punto del presidente:'
		.$partita->commentoAndata.'</textarea> ';
		echo '</div>';
		
		if(!empty($partita->golCasaRitorno))
		{
			echo $partita->golCasaRitorno;
			echo '<div class="score">';
			echo '<div class="punti">('.$partita->puntiCasaRitorno.')</div>';
			echo '<div class="gol">'.$partita->golCasaRitorno.'</div>';
			echo '<div> - </div>';
			echo '<div class="gol">'.$partita->golTrasfertaRitorno.'</div>';
			echo '<div class="punti">('.$partita->puntiTrasfertaRitorno.')</div>';
			echo '</div>';
		}
		echo '<div class="formazioni">';
		$link="display_giornata.php?&id_giornata=".$partita->idGiornataRitorno;
		echo '<a href='. $link.'>Formazioni Ritorno <i class="fas fa-list-ol"></i></a>';
		echo '</div>';
		echo '<div class="commento" style="'.( $partita->commentoRitorno == "" ?  "display:none;" : "").'">';
		echo '<textarea readonly rows="10"  >Il punto del presidente:'
		.$partita->commentoRitorno.'</textarea> ';
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