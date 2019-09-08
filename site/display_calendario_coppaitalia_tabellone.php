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

	public $idSquadraVincente;
	
}

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
while ($row=$result->fetch_assoc()) {
    
    $id_sq1=$row["id_sq_casa"];
    $sq1=$row["squadracasa"];
    $id_sq2=$row["id_sq_ospite"];
	$sq2=$row["squadraospite"];
	
	if($index == 0)
	{
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
		
		array_push($giornate,$incontroCoppa);
		$index =0;
	}
  
}
$result->close();
$conn->next_result();

$queryfinale= "SELECT giornate.*, 
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
	echo '</tr>';
	echo '<tr>';
	echo 	'<td >'
	.(($incontro->dataInizioAndata != "") ? date('d/m H:i', strtotime($incontro->dataInizioAndata)) : "").
	' <br> '
	.(($incontro->dataFineAndata != "") ? date('d/m H:i', strtotime($incontro->dataFineAndata)) : "").
	'</td>';
	echo 	'<td >'
	.(($incontro->puntiCasaAndata != "") ? '('.$incontro->puntiCasaAndata.')'.$incontro->golCasaAndata : "").
	
	'</td>';
	echo 	'<td>-</td>';
	echo 	'<td>'
	.(($incontro->puntiTrasfertaAndata != "") ? '('.$incontro->puntiTrasfertaAndata.')'.$incontro->golTrasfertaAndata : "").
	'</td>';
	echo '</tr>';
	echo '<tr>';
	echo 	'<td >'
	.(($incontro->dataInizioRitorno != "") ? date('d/m H:i', strtotime($incontro->dataInizioRitorno)) : "").
	
	' <br> '
	.(($incontro->dataFineRitorno != "") ? date('d/m H:i', strtotime($incontro->dataFineRitorno)) : "").
	
	'</td>';
	echo 	'<td >'
	.(($incontro->puntiCasaRitorno != "") ? '('.$incontro->puntiCasaRitorno.')'.$incontro->golCasaRitorno : "").
	'</td>';
	echo 	'<td>-</td>';
	echo 	'<td>'
	.(($incontro->puntiTrasfertaRitorno != "") ? '('.$incontro->puntiTrasfertaRitorno.')'.$incontro->golTrasfertaRitorno : "").
	'</td>';
	echo '</tr>';
	
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

		$("#element76").appendTo(".finale");


		// $("div.quarto1").connections({ to: 'div.semifinale1' });
		// $("div.quarto2").connections({ to: 'div.semifinale1' });
		// $("div.quarto3").connections({ to: 'div.semifinale2' });
		// $("div.quarto4").connections({ to: 'div.semifinale2' });
		// $("div.semifinale1").connections({ to: 'div.finale' });
		// $("div.semifinale2").connections({ to: 'div.finale' });
	});
	</script>
<div class="grid-container scrollmenu">
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
		<div class="grid-item  finale">
			
		</div>
	</div> 
</div>
<?php 
include("footer.php");
?>