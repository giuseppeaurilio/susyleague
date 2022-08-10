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
	public $idGiornatagara1;
	public $dataIniziogara1;
	public $dataFinegara1;
	public $golCasagara1;
	public $puntiCasagara1;
	public $golTrasfertagara1;
	public $puntiTrasfertagara1;
	public $idGiornatagara2;
	public $dataIniziogara2;
	public $dataFinegara2;
	public $golCasagara2;
	public $puntiCasagara2;
	public $golTrasfertagara2;
	public $puntiTrasfertagara2;
	public $idGiornatagara3;
	public $dataIniziogara3;
	public $dataFinegara3;
	public $golCasagara3;
	public $puntiCasagara3;
	public $golTrasfertagara3;
	public $puntiTrasfertagara3;
	public $commentogara1;
	public $commentogara2;
	public $commentogara3;

	public $idSquadraVincente;
	
}
?>

<?php

$query= "SELECT g.id_giornata, ga.inizio, ga.fine, g.commento,
c.id_sq_casa, sq1.squadra as squadracasa,
c.id_sq_ospite,  sq2.squadra as squadraospite ,
c.gol_casa,
c.gol_ospiti,
c.punti_casa,
c.punti_ospiti


FROM `giornate` as g
LEFT JOIN giornate_serie_a as ga on g.giornata_serie_a_id = ga.id
left join `calendario` as c on g.`id_giornata` =  c.`id_giornata` 
left join `sq_fantacalcio` as sq1 on c.`id_sq_casa` =  `sq1`.`id`
left join `sq_fantacalcio` as sq2 on c.`id_sq_ospite` =  `sq2`.`id`
WHERE id_girone = 7 order by id_giornata ASC";
$result=$conn->query($query);

// $num=$result->num_rows; 
$index = 0;
$id_giornata_gara1 = "";
$inizio_a_gara1= "";
$fine_a_gara1= "";
$gol_casa_gara1= "";
$gol_ospiti_gara1= "";
$punti_casa_gara1= "";
$punti_ospiti_gara1= "";
$id_giornata_gara2= "";
$inizio_a_gara2= "";
$fine_a_gara2= "";
$gol_casa_gara2= "";
$gol_ospiti_gara2= "";
$punti_casa_gara2= "";
$punti_ospiti_gara2= "";
$id_giornata_gara3= "";
$inizio_a_gara3= "";
$fine_a_gara3= "";
$gol_casa_gara3= "";
$gol_ospiti_gara3= "";
$punti_casa_gara3= "";
$punti_ospiti_gara3= "";
$commentogara1= "";
$commentogara2= "";
$commentogara3= "";
$giornate = array();
while ($row=$result->fetch_assoc()) {
    
	if($index == 0)
	{
		$id_sq1=$row["id_sq_casa"];
		$sq1=$row["squadracasa"];
		$id_sq2=$row["id_sq_ospite"];
		$sq2=$row["squadraospite"];
		$id_gara1=$row["id_giornata"];
		$inizio_gara1=$row["inizio"];
		$fine_gara1=$row["fine"];
		$inizio_a_gara1=$row["inizio"];//date_parse($inizio_andata);
		$fine_a_gara1=$row["fine"];//date_parse($fine_andata);
		if(!is_null($row["gol_casa"]) && !is_null($row["gol_casa"]) )
		{
			$gol_casa_gara1=$row["gol_casa"];
			$gol_ospiti_gara1=$row["gol_ospiti"];
			$punti_casa_gara1=$row["punti_casa"];
			$punti_ospiti_gara1=$row["punti_ospiti"];
			$commentogara1 = $row["commento"];
		}
		$index =1;
	}
	else if($index == 1)
	{
		$id_giornata_gara2=$row["id_giornata"];
		// $inizio_gara2=$row["inizio"];
		// $fine_gara2=$row["fine"];
		$inizio_a_gara2=$row["inizio"];//date_parse($inizio_gara2);
		$fine_a_gara2=$row["fine"];//date_parse($fine_gara2);
		if(!is_null($row["gol_casa"]) && !is_null($row["gol_casa"]) )
		{
			$gol_casa_gara2=$row["gol_casa"];
			$gol_ospiti_gara2=$row["gol_ospiti"];
			$punti_casa_gara2=$row["punti_casa"];
			$punti_ospiti_gara2=$row["punti_ospiti"];
			$commentogara2 = $row["commento"];
		}
		$index =2;
	}
	else if($index == 2)
	{
		$id_giornata_gara3=$row["id_giornata"];
		// $inizio_gara2=$row["inizio"];
		// $fine_gara2=$row["fine"];
		$inizio_a_gara3=$row["inizio"];//date_parse($inizio_gara2);
		$fine_a_gara3=$row["fine"];//date_parse($fine_gara2);
		if(!is_null($row["gol_casa"]) && !is_null($row["gol_casa"]) )
		{
			$gol_casa_gara3=$row["gol_casa"];
			$gol_ospiti_gara3=$row["gol_ospiti"];
			$punti_casa_gara3=$row["punti_casa"];
			$punti_ospiti_gara3=$row["punti_ospiti"];
			$commentogara3 = $row["commento"];
		}
		$index =3;
	}

	if($index == 3)
	{
		$incontroCoppa = new IncontroCoppa;
		$incontroCoppa->idSquadraA  = $id_sq1;
		$incontroCoppa->squadraA  = $sq1;
		$incontroCoppa->idSquadraB  = $id_sq2;
		$incontroCoppa->squadraB  = $sq2;

		$incontroCoppa->idGiornatagara1 = $id_giornata_gara1;
		$incontroCoppa->dataIniziogara1 = $inizio_a_gara1;
		$incontroCoppa->dataFinegara1 = $fine_a_gara1;
		$incontroCoppa->golCasagara1 = $gol_casa_gara1;
		$incontroCoppa->puntiCasagara1 = $punti_casa_gara1;
		$incontroCoppa->golTrasfertagara1 = $gol_ospiti_gara1;
		$incontroCoppa->puntiTrasfertagara1 = $punti_ospiti_gara1;

		$incontroCoppa->idGiornatagara2 = $id_giornata_gara2;
		$incontroCoppa->dataIniziogara2 = $inizio_a_gara2;
		$incontroCoppa->dataFinegara2 = $fine_a_gara2;
		$incontroCoppa->golCasagara2 = $gol_casa_gara2;
		$incontroCoppa->puntiCasagara2 = $punti_casa_gara2;
		$incontroCoppa->golTrasfertagara2 = $gol_ospiti_gara2;
		$incontroCoppa->puntiTrasfertagara2 = $punti_ospiti_gara2;

		$incontroCoppa->idGiornatagara3 = $id_giornata_gara3;
		$incontroCoppa->dataIniziogara3 = $inizio_a_gara3;
		$incontroCoppa->dataFinegara3 = $fine_a_gara3;
		$incontroCoppa->golCasagara3 = $gol_casa_gara3;
		$incontroCoppa->puntiCasagara3 = $punti_casa_gara3;
		$incontroCoppa->golTrasfertagara3 = $gol_ospiti_gara3;
		$incontroCoppa->puntiTrasfertagara3 = $punti_ospiti_gara3;

		$incontroCoppa->commentogara1 = $commentogara1;
		$incontroCoppa->commentogara2 = $commentogara2;
		$incontroCoppa->commentogara3 = $commentogara3;

		
		array_push($giornate,$incontroCoppa);
		$index =0;
	}
  
}

$query='SELECT v.`id` as id, v.`competizione_id` as idc, v.`desc_competizione` as descc, 
v.`posizione` as pos, v.`sq_id` as ids, sqf.squadra, sqf.allenatore 
FROM `vincitori` as v
left join sq_fantacalcio as sqf on sqf.id = v.sq_id
where v.`competizione_id` = 7
order by posizione';
$result=$conn->query($query) or die($conn->error);
$vincitori = array();
while($row = $result->fetch_assoc()){
	array_push($vincitori, array(
		"Competizione"=>$row["descc"],
		"Squadra"=>$row["squadra"],
		"Allenatore"=>$row["allenatore"],
		"Posizione"=>$row["pos"],
		)
	);
}
$result->close();
$conn->next_result();
foreach ($giornate as $partita) {
	echo '<div class="finale">'; 
		echo '<h1 class="titolo" >Finale SusyLeague</h1>';
		if(count($vincitori) > 0){
			echo '<h1 class="vincitore">'.$vincitori[0]["Squadra"].' è il Vincitore!</h1>';
		}
		// (($incontro->dataIniziogara1 != "") ? date('d/m H:i', strtotime($incontro->dataIniziogara1)) : "")
		echo '<div class="data">'
		.(($partita->dataIniziogara1 != "") ? date('d/m H:i', strtotime($partita->dataIniziogara1)) : "").
		'-'
		.(($partita->dataFinegara1 != "") ? date('d/m H:i', strtotime($partita->dataFinegara1)) : "").
		'</div>';
		
		echo '<div class="location">Allianz Stadium di Torino</div>';
		echo '<div class="squadre">';
		echo '<div class=" squadra1">'.$partita->squadraA.'</div>';
		echo '<div> - </div>';
		echo '<div class=" squadra2">'.$partita->squadraB.'</div>';
		echo '</div>';
		if(!is_null($partita->golCasagara1))
		{
			// echo $partita->golCasagara1;
			echo '<div class="score">';
			echo '<div class="punti">('.$partita->puntiCasagara1.')</div>';
			echo '<div class="gol">'.$partita->golCasagara1.'</div>';
			echo '<div> - </div>';
			echo '<div class="gol">'.$partita->golTrasfertagara1.'</div>';
			echo '<div class="punti">('.$partita->puntiTrasfertagara1.')</div>';
			echo '</div>';
		}
		echo '<div class="formazioni">';
		$link="display_giornata.php?&id_giornata=".$partita->idGiornatagara1;
		echo '<a href='. $link.'>Formazioni gara1 <i class="fas fa-list-ol"></i></a>';
		echo '</div>';
		echo '<div class="commento" style="'.( $partita->commentogara1 == "" ?  "display:none;" : "").'" >';
		echo '<textarea readonly rows="10" >Il punto del presidente:'
		.$partita->commentogara1.'</textarea> ';
		echo '</div>';
		
		if(!is_null($partita->golCasagara2))
		{
			// echo print_r($partita);
			// echo $partita->golCasagara2;
			
			echo '<div class="score">';
			echo '<div class="punti">('.$partita->puntiTrasfertagara2.')</div>';
			echo '<div class="gol">'.$partita->golTrasfertagara2.'</div>';
			echo '<div> - </div>';
			echo '<div class="gol">'.$partita->golCasagara2.'</div>';
			echo '<div class="punti">('.$partita->puntiCasagara2.')</div>';
			echo '</div>';
		}
		echo '<div class="formazioni">';
		$link="display_giornata.php?&id_giornata=".$partita->idGiornatagara2;
		echo '<a href='. $link.'>Formazioni gara2 <i class="fas fa-list-ol"></i></a>';
		echo '</div>';
		echo '<div class="commento" style="'.( $partita->commentogara2 == "" ?  "display:none;" : "").'">';
		echo '<textarea readonly rows="10"  >Il punto del presidente:'
		.$partita->commentogara2.'</textarea> ';
		echo '</div>';

		if(!is_null($partita->golCasagara3))
		{
			// echo print_r($partita);
			// echo $partita->golCasagara3;
			
			echo '<div class="score">';
			echo '<div class="punti">('.$partita->puntiTrasfertagara3.')</div>';
			echo '<div class="gol">'.$partita->golTrasfertagara3.'</div>';
			echo '<div> - </div>';
			echo '<div class="gol">'.$partita->golCasagara3.'</div>';
			echo '<div class="punti">('.$partita->puntiCasagara3.')</div>';
			echo '</div>';
		}
		echo '<div class="formazioni">';
		$link="display_giornata.php?&id_giornata=".$partita->idGiornatagara3;
		echo '<a href='. $link.'>Formazioni gara3 <i class="fas fa-list-ol"></i></a>';
		echo '</div>';
		echo '<div class="commento" style="'.( $partita->commentogara3 == "" ?  "display:none;" : "").'">';
		echo '<textarea readonly rows="10"  >Il punto del presidente:'
		.$partita->commentogara3.'</textarea> ';
		echo '</div>';
		echo '<h1>&nbsp;</h1>';
		
	echo '</div>';
}




?>
<?php 
include("footer.php");
?>