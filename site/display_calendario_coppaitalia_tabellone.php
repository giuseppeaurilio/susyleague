<?php
include("menu.php");
?>
<h2>Coppa Italia - tabellone</h2>
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
WHERE id_girone = 5 order by id_giornata ASC";
$result=$conn->query($query);

$num=$result->num_rows; 

$giornate = array();
$index=0;
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
		if(!is_null($row["gol_casa"]))
		{
			$gol_casa_andata=$row["gol_casa"];
			$gol_ospiti_andata=$row["gol_ospiti"];
			$punti_casa_andata=$row["punti_casa"];
			$punti_ospiti_andata=$row["punti_ospiti"];
			$commentoAndata = $row["commento"];
		}
		else
		{
			$gol_casa_andata='';
			$gol_ospiti_andata='';
			$punti_casa_andata='';
			$punti_ospiti_andata='';
			$commentoAndata = "";
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
		if(!is_null($row["gol_casa"]))
		{
			$gol_casa_ritorno=$row["gol_casa"];
			$gol_ospiti_ritorno=$row["gol_ospiti"];
			$punti_casa_ritorno=$row["punti_casa"];
			$punti_ospiti_ritorno=$row["punti_ospiti"];
			$commentoRitorno = $row["commento"];
		}
		else
		{
			$gol_casa_ritorno='';
			$gol_ospiti_ritorno='';
			$punti_casa_ritorno='';
			$punti_ospiti_ritorno='';
			$commentoRitorno = "";
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
		$incontroCoppa->puntiCasaAndata = $punti_casa_andata;
		$incontroCoppa->golTrasfertaAndata = $gol_ospiti_andata;
		$incontroCoppa->puntiTrasfertaAndata = $punti_ospiti_andata;

		$incontroCoppa->idGiornataRitorno = $id_giornata_ritorno;
		$incontroCoppa->dataInizioRitorno = $inizio_a_ritorno;
		$incontroCoppa->dataFineRitorno = $fine_a_ritorno;
		$incontroCoppa->golCasaRitorno = $gol_casa_ritorno;
		$incontroCoppa->puntiCasaRitorno = $punti_casa_ritorno;
		$incontroCoppa->golTrasfertaRitorno = $gol_ospiti_ritorno;
		$incontroCoppa->puntiTrasfertaRitorno = $punti_ospiti_ritorno;

		$incontroCoppa->commentoAndata = $commentoAndata;
		$incontroCoppa->commentoRitorno = $commentoRitorno;
		
		array_push($giornate,$incontroCoppa);
		$index =0;
	}
  
}
$result->close();
$conn->next_result();

$queryfinale= "SELECT g.id_giornata, ga.inizio, ga.fine, g.commento,
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
WHERE id_girone = 9 order by id_giornata ASC";
$resultfinale=$conn->query($queryfinale);

while ($row=$resultfinale->fetch_assoc()) {
    
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
	}
	else
	{
		$gol_casa_andata='';
		$gol_ospiti_andata='';
		$punti_casa_andata='';
		$punti_ospiti_andata='';
	}
	$inizio_a_ritorno='';//date_parse($inizio_ritorno);
	$fine_a_ritorno='';//date_parse($fine_ritorno);
	$gol_casa_ritorno='';
	$gol_ospiti_ritorno='';
	$punti_casa_ritorno='';
	$punti_ospiti_ritorno='';
	$commentoRitorno = "";
		 
}
$resultfinale->close();
$conn->next_result();

$incontroCoppa = new IncontroCoppa;
$incontroCoppa->idSquadraA  = $id_sq1;
$incontroCoppa->squadraA  = $sq1;
$incontroCoppa->idSquadraB  = $id_sq2;
$incontroCoppa->squadraB  = $sq2;

$incontroCoppa->idGiornataAndata = $id_giornata_andata;
$incontroCoppa->dataInizioAndata = $inizio_a_andata;
$incontroCoppa->dataFineAndata = $fine_a_andata;
$incontroCoppa->golCasaAndata = $gol_casa_andata;
$incontroCoppa->puntiCasaAndata = $punti_casa_andata;
$incontroCoppa->golTrasfertaAndata = $gol_ospiti_andata;
$incontroCoppa->puntiTrasfertaAndata = $punti_ospiti_andata;

$incontroCoppa->idGiornataRitorno = $id_giornata_ritorno;
$incontroCoppa->dataInizioRitorno = $inizio_a_ritorno;
$incontroCoppa->dataFineRitorno = $fine_a_ritorno;
$incontroCoppa->golCasaRitorno = $gol_casa_ritorno;
$incontroCoppa->puntiCasaRitorno = $punti_casa_ritorno;
$incontroCoppa->golTrasfertaRitorno = $gol_ospiti_ritorno;
$incontroCoppa->puntiTrasfertaRitorno = $punti_ospiti_ritorno;

array_push($giornate,$incontroCoppa);





// print_r($giornate);
foreach($giornate as $incontro)
{
	// print_r($incontro);
	$descrizione ="";
	if($incontro->idGiornataAndata == 64)
	$descrizione ="Quarto 1";
	if($incontro->idGiornataAndata == 66)
	$descrizione ="Quarto 2";
	if($incontro->idGiornataAndata == 68)
	$descrizione ="Quarto 3";
	if($incontro->idGiornataAndata == 70)
	$descrizione ="Quarto 4";
	if($incontro->idGiornataAndata == 72)
	$descrizione ="Semifinale 1";
	if($incontro->idGiornataAndata == 74)
	$descrizione ="Semifinale 2";

	// echo '<fieldset>';
	echo '<div id="element' .$incontro->idGiornataAndata .'">';
	// echo '<h4>' .$descrizione .'</h4>' ;
	echo '<table class="ci_tabellone">';
	// echo '<thead>';
	// echo '<tr>';
	// 	echo '<th></th>';
	// echo '</tr>';
	// echo '</thead>';
	echo '<tbody>';
	echo '<tr>'; 
	echo '<th ></th><th  >
	'.$incontro->squadraA.'</th><th> - </th><th>'.$incontro->squadraB.'</th>';
	echo '<th ></th>';
	echo '</tr>';
	echo '<tr>';
	echo 	'<td >'
	.(($incontro->dataInizioAndata != "") ? date('d/m H:i', strtotime($incontro->dataInizioAndata)) : "").
	' <br> '
	.(($incontro->dataFineAndata != "") ? date('d/m H:i', strtotime($incontro->dataFineAndata)) : "").
	'</td>';
	echo 	'<td >'
	.(($incontro->puntiCasaAndata != "") ? '('.$incontro->puntiCasaAndata.')<span class="gol">'.$incontro->golCasaAndata .'</span>': "").
	'</td>';
	echo 	'<td>-</td>';
	echo 	'<td>'
	.(($incontro->puntiTrasfertaAndata != "") ? '<span class="gol">'.$incontro->golTrasfertaAndata.'</span>('.$incontro->puntiTrasfertaAndata.')' : "").
	'</td>';
	echo '<td><a href="display_giornata.php?&id_giornata='. $incontro->idGiornataAndata  .'" ><i class="fas fa-list-ol"></i></a></td>';
	echo '</tr>';
	if($incontro->idGiornataAndata != 76)
	{
		echo '<tr>';
		echo 	'<td >'
		.(($incontro->dataInizioRitorno != "") ? date('d/m H:i', strtotime($incontro->dataInizioRitorno)) : "").
		
		' <br> '
		.(($incontro->dataFineRitorno != "") ? date('d/m H:i', strtotime($incontro->dataFineRitorno)) : "").
		
		'</td>';
		echo 	'<td>'
		.(($incontro->puntiTrasfertaRitorno != "") ? '('.$incontro->puntiTrasfertaRitorno.')<span class="gol">' . $incontro->golTrasfertaRitorno .'</span>' : "").
		// . print_r($incontro->idGiornataAndata) . "<br>". 
		'</td>';
		echo 	'<td>-</td>';
		echo 	'<td >'
		.(($incontro->puntiCasaRitorno != "") ? '<span class="gol">'. $incontro->golCasaRitorno . '</span>('.$incontro->puntiCasaRitorno.')': "").
		// . print_r($incontro->idGiornataAndata) . "<br>".
		'</td>';
		echo '<td><a href="display_giornata.php?&id_giornata='. $incontro->idGiornataRitorno  .'" ><i class="fas fa-list-ol"></i></a></td>';
		echo '</tr>';
	}
	echo '</tbody>';
	echo '</table>';
	// echo '</fieldset>';
	echo '</div>';
	
}
?>
<script>
	$(document).ready(function(){

		$("#element64").appendTo(".quarto1");
		$("#element66").appendTo(".quarto2");
		$("#element68").appendTo(".quarto3");
		$("#element70").appendTo(".quarto4");

		$("#element72").appendTo(".semifinale1");
		$("#element74").appendTo(".semifinale2");

		$("#element76").appendTo(".finaleci");


		$("div.quarto1").connections({ to: 'div.semifinale1' });
		$("div.quarto2").connections({ to: 'div.semifinale1' });
		$("div.quarto3").connections({ to: 'div.semifinale2' });
		$("div.quarto4").connections({ to: 'div.semifinale2' });
		$("div.semifinale1").connections({ to: 'div.finale' });
		$("div.semifinale2").connections({ to: 'div.finale' });
	});
	</script>
	<?php
	$query='SELECT v.`id` as id, v.`competizione_id` as idc, v.`desc_competizione` as descc, 
	v.`posizione` as pos, v.`sq_id` as ids, sqf.squadra, sqf.allenatore 
	FROM `vincitori` as v
	left join sq_fantacalcio as sqf on sqf.id = v.sq_id
	where v.`competizione_id` = 9
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
	if(count($vincitori) > 0){
		echo '<h1 class="vincitore">'.$vincitori[0]["Squadra"].' è il Vincitore!</h1>';
	}
?>
<div class="grid-container scrollmenu tabellonecoppa">
	<div class="grid-column">
		<div class="grid-item quarto1">
			
		</div>
		<div class="grid-item quarto2">
			
		</div>
		<div class="grid-item quarto3">
			
		</div>
		<div class="grid-item quarto4">
			
		</div>
	</div>
  	<div class="grid-column">
		<div class="grid-item semifinale1">
			
		</div>
		<div class="grid-item semifinale2">
			
		</div>
	</div>
  	<div class="grid-column">
		<div class="grid-item  finaleci">
			
		</div>
	</div> 
</div>
<h1>&nbsp;</h1>
<?php 
include("footer.php");
?>