<?php
include("menu.php");

?>

<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
imgError = function(img){
	img.src = "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/no-campioncino.png";
};
</script>
<?php
$id_giornata=$_GET['id_giornata'];

?>

<h2> Giornata <?php echo $id_giornata ;?> </h2>
<div data-role="main" class="ui-content">

<?php


$query2="Select *, b.squadra as sq_casa, c.squadra as sq_ospite, g.id_girone
FROM calendario as a 
left join sq_fantacalcio as b on a.id_sq_casa=b.id 
left join sq_fantacalcio as c on a.id_sq_ospite=c.id 
left join giornate as g on g.id_giornata=a.id_giornata 
where a.id_giornata=".$id_giornata ." order by a.id_partita" ;
#echo "<br> quesry2= " . $query2;
$idgirone = 0;
$result_giornata=$conn->query($query2);
$num_giornata=$result_giornata->num_rows;
$j=0;
while ($row=$result_giornata->fetch_assoc()) {
	$idgirone=$row["id_girone"];

	$id_casa=$row["id_sq_casa"];
	$id_ospite=$row["id_sq_ospite"];
	$sq_casa=$row["sq_casa"];
	$sq_ospite=$row["sq_ospite"];
	
	$addizionalecasa = $row["fattorecasa"];
	$numero_giocanti_casa = $row["numero_giocanti_casa"];
	$voto_netto_casa = $row["punti_casa"];
	$media_difesa_avversaria_casa = $row["md_casa"];
	$voto_totale_casa = $voto_netto_casa + $media_difesa_avversaria_casa + $addizionalecasa;//$row["tot_casa"];
	$gol_casa = $row["gol_casa"];

	$numero_giocanti_ospite  = $row["numero_giocanti_ospite"];
	$voto_netto_ospite = $row["punti_ospiti"];
	$media_difesa_avversaria_ospite = $row["md_ospite"];
	$voto_totale_ospite = $voto_netto_ospite + $media_difesa_avversaria_ospite;//$row["tot_ospite"];
	$gol_ospite = $row["gol_ospiti"];


	$query_formazione="SELECT a.voto,a.voto_md, b.nome, b.ruolo, c.squadra_breve, a.sostituzione
	FROM formazioni as a 
	inner join giocatori as b 
	inner join squadre_serie_a as c 
	where a.id_giornata='" . $id_giornata . "' 
	and a.id_squadra= '". $id_casa ."' 
	and a.id_giocatore=b.id 
	and a.id_squadra_sa=c.id ";
	//echo "<br> query formazione casa= " . $query_formazione;
	$result_formazione=$conn->query($query_formazione);
	$num_giocatori=$result_formazione->num_rows;
	$i=0;
	?>
	 <div class="ui-grid-a">
		<div class="ui-block-a" style="float:left;">
			<h3 class="caption_style" style="text-align: center; margin: 0 1px;"><?php echo $sq_casa; ?></h3>
			<table border=1  id="squadra_casa<?php echo $j;?>">
				<!-- <caption class="caption_style"><?php echo $sq_casa; ?></caption> -->
				<tr>
					<th width="10%" >CASA</th>
					<!-- <th width="5%">&nbsp;</th> -->
					<th width="50%" colspan="2">Nome</th>
					<th width="10%">&nbsp;</th>
					<th width="10%">R</th>
					<th width="10%">V</th>
					<th width="10%">VN</th>
				</tr>
				<?php
				while ($row=$result_formazione->fetch_assoc()) {
						$ruolo_giocatore=$row["ruolo"];
					?>
					<tr id=row_<?php  echo $id_casa  . "_" . ($i+1);?> style="background-color: <?php switch ($ruolo_giocatore) {
						case "P":
							echo "#66CC33";
							break;
						case "D":
							echo "#33CCCC";
							break;
						case "C":
							echo "#FFEF00";
							break;
						case "A":
							echo "#E80000 ";
							break;
						default:
							echo "#FFFFFF";
					}
					?>">
						<?php
							// echo $nome_giocatore;
							$nome_giocatore_pulito = preg_replace('/\s+/', '-', $row["nome"]);
							// echo $nome_giocatore_pulito;
							$filename = str_replace("% %", "-", "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/".$nome_giocatore_pulito.".png"); 
						?>
						<?php if ($i==0) {echo 	"<td rowspan='11' style='background-color: white;'><div class='rotate'> Titolari</div></td>";  } ?>
						<?php if ($i==11) {echo "<td rowspan='8' style='background-color: white;'><div class='rotate'> Riserve </div></td>";  } ?>
						<td style="padding:0; width:3%"><?php echo '<img  onerror="imgError(this);" style="width:20px; height:27px;" src='.$filename.'>';?></td>
						<td ><div class="truncate"><?php echo $row["nome"]; ?></div></td>
						<td><?php echo $row["squadra_breve"]; ?></td>
						<td><?php echo $row["ruolo"]; ?></td>
						<td><?php echo ($row["sostituzione"] == 1 || $i < 11 ? $row["voto"]: ""); ?></td>
						<td><?php echo ($row["sostituzione"] == 1 || $i < 11 ? $row["voto_md"]: ""); ?></td>
					</tr>
					<?php
					++$i;
				}#end giocatori casa
				?>
	
			</table>

			<p> addizionale = <?php echo $addizionalecasa; ?> </p>
			<p> giocatori con  voto = <?php echo $numero_giocanti_casa; ?> </p>
			<p> voto netto = <?php echo $voto_netto_casa; ?> </p>
			<p> media difesa = <?php echo $media_difesa_avversaria_casa; ?> </p>
			<p> voto totale = <?php echo $voto_totale_casa; ?> </p>
			<p> gol = <?php echo $gol_casa; ?> </p>
		</div>

	<?php
	$query_formazione="SELECT a.voto,a.voto_md, b.nome, b.ruolo, c.squadra_breve, a.sostituzione FROM formazioni as a inner join giocatori as b inner join squadre_serie_a as c where a.id_giornata='" . $id_giornata . "' and a.id_squadra= '". $id_ospite ."' and a.id_giocatore=b.id and a.id_squadra_sa=c.id ";

	//echo "<br> query formazione ospite= " . $query_formazione;
	$result_formazione=$conn->query($query_formazione);
	$num_giocatori=$result_formazione->num_rows;
	$i=0;
	?>
	<!-- <div class="ui-block-middle">&nbsp;</div> -->
		<div class="ui-block-b" style="float:right;">
			
			<h3 class="caption_style" style="text-align: center; margin: 0 1px;"><?php echo $sq_ospite; ?></h3>
			<table border=1  id="squadra_ospite<?php echo $j;?>">
				<!-- <caption class="caption_style"><?php echo $sq_ospite; ?></caption> -->

				
				<!-- <th width="5%">&nbsp;</th> -->
				<th width="50%" colspan="2">Nome</th>
				<th width="10%">&nbsp;</th>
				<th width="10%">R</th>
				<th width="10%">V</th>
				<th width="10%">VN</th>
				<th >OSP.</th>

				<?php
				while ($row=$result_formazione->fetch_assoc()) {
					$ruolo_giocatore=$row["ruolo"];
				?>
					<tr id=row_<?php  echo $id_ospite  . "_" . ($i+1);?> style="background-color: <?php switch ($ruolo_giocatore) {
				case "P":
					echo "#66CC33";
					break;
				case "D":
					echo "#33CCCC";
					break;
				case "C":
					echo "#FFEF00";
					break;
				case "A":
					echo "#E80000 ";
					break;
				default:
					echo "#FFFFFF";
				}
				?>">
				<?php
						// echo $nome_giocatore;
						$nome_giocatore_pulito = preg_replace('/\s+/', '-', $row["nome"]);
						// echo $nome_giocatore_pulito;
						$filename = str_replace("% %", "-", "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/".$nome_giocatore_pulito.".png"); 
				?>
				
					<td style="padding:0; width:3%"><?php echo '<img  onerror="imgError(this);" style="width:20px; height:27px;" src='.$filename.'>';?></td>
					<td ><div class="truncate"><?php echo $row["nome"]; ?></div></td>
					<td><?php echo $row["squadra_breve"]; ?></td>
					<td><?php echo $row["ruolo"]; ?></td>
					<td><?php echo ($row["sostituzione"] == 1 || $i < 11 ? $row["voto"]: ""); ?></td>
					<td><?php echo ($row["sostituzione"] == 1 || $i < 11 ? $row["voto_md"]: ""); ?></td>
				<?php if ($i==0) {echo 	"<td rowspan='11' style='background-color: white;'><div class='rotate2'> Titolari</div></td>";  } ?>
				<?php if ($i==11) {echo "<td rowspan='8' style='background-color: white;'><div class='rotate2'> Riserve </div></td>";  } ?>	
				</tr>
					<?php
					++$i;
				}#end giocatori ospiti
				?>
			</table>
			<p> addizionale = 0 </p>
			<p> giocatori con  voto = <?php echo $numero_giocanti_ospite; ?> </p>
			<p> voto netto = <?php echo $voto_netto_ospite; ?> </p>
			<p> media difesa = <?php echo $media_difesa_avversaria_ospite; ?> </p>
			<p> voto totale = <?php echo $voto_totale_ospite; ?> </p>
			<p> gol = <?php echo $gol_ospite; ?> </p></div>
		</div>
	<hr style="display: inline-block;width: 100%;">
<?php
++$j;
echo '</div>';
} # end incontri
?>

<?php 
include("footer.php");
?>