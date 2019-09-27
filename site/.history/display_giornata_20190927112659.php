<?php
include("menu.php");

?>

<!-- <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
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
	<!-- <h3 class="caption_style" style="text-align: center;">
		<div style="width:40%; display:inline-block;"><?php echo $sq_casa; ?> </div>
		<div style="width:10%; display:inline-block;">-</div> 
		<div style="width:40%; display:inline-block;"><?php echo $sq_ospite; ?></div>
	</h3> -->
	<div id="tabellino">
		<table>
			<tr>
				<th style="width:45%"><?php echo $sq_casa; ?></th>
				<th><?php echo $gol_casa; ?> - <?php echo $gol_ospite; ?></th>
				<th style="width:45%"><?php echo $sq_ospite; ?></th>
			</tr>
			<tr style=" <?php echo ($gol_casa != "" && $gol_ospite != "") ? "": "display:none" ?>">
				<td><?php echo $gol_casa; ?> </td>
				<td>GOL</td>
				<td><?php echo $gol_ospite; ?> </td>
			</tr>
			<tr style=" <?php echo ($gol_casa != "" && $gol_ospite != "") ? "": "display:none" ?>">
				<td><?php echo $voto_netto_casa; ?> </td>
				<td>VOTO NETTO</td>
				<td><?php echo $voto_netto_ospite; ?> </td>
			</tr>
			<tr style=" <?php echo ($gol_casa != "" && $gol_ospite != "") ? "": "display:none" ?>">
				<td><?php echo $addizionalecasa; ?> </td>
				<td>FATTORE CASA</td>
				<td>&nbsp;</td>
			</tr>
			<tr style=" <?php echo ($gol_casa != "" && $gol_ospite != "") ? "": "display:none" ?>">
				<td><?php echo $media_difesa_avversaria_casa; ?> </td>
				<td>MEDIA DIFESA</td>
				<td><?php echo $media_difesa_avversaria_ospite; ?></td>
			</tr>
			<tr style=" <?php echo ($gol_casa != "" && $gol_ospite != "") ? "": "display:none" ?>">
				<td><?php echo $voto_totale_casa; ?> </td>
				<td>VOTO TOTALE</td>
				<td><?php echo $voto_totale_ospite; ?></td>
			</tr>
			<tr style=" <?php echo ($gol_casa != "" && $gol_ospite != "") ? "": "display:none" ?>">
				<td><?php echo $numero_giocanti_casa; ?> </td>
				<td># GIOCATORI</td>
				<td><?php echo $numero_giocanti_ospite; ?></td>
			</tr>
		</table>
		
		<!-- <div style="width:40%; display:inline-block;">
			<p> addizionale = <?php echo $addizionalecasa; ?> </p>
			<p> giocatori con  voto = <?php echo $numero_giocanti_casa; ?> </p>
			<p> voto netto = <?php echo $voto_netto_casa; ?> </p>
			<p> media difesa = <?php echo $media_difesa_avversaria_casa; ?> </p>
			<p> voto totale = <?php echo $voto_totale_casa; ?> </p>
			<p> gol = <?php echo $gol_casa; ?> </p>
		</div>
		<div style="width:10%; display:inline-block;">&nbsp;</div> 
		<div style="width:40%; display:inline-block;">
			<p> addizionale = 0 </p>
			<p> giocatori con  voto = <?php echo $numero_giocanti_ospite; ?> </p>
			<p> voto netto = <?php echo $voto_netto_ospite; ?> </p>
			<p> media difesa = <?php echo $media_difesa_avversaria_ospite; ?> </p>
			<p> voto totale = <?php echo $voto_totale_ospite; ?> </p>
			<p> gol = <?php echo $gol_ospite; ?> </p>
		</div> -->
	</div>
	
	
	 <div class="ui-grid-a">
		
		<div class="ui-block-a" style="float:left;">
		<!-- <h3 class="caption_style" style="text-align: center;"><?php echo $sq_casa; ?></h3> -->
			<table border=1  id="squadra_casa<?php echo $j;?>">
				<!-- <caption class="caption_style"><?php echo $sq_casa; ?></caption> -->
				<tr>
					<th width="3%">CAS</th>
					<th colspan="3" >Nome</th>
					<th width="10%">R</th>
					<th width="10%">V</th>
					<th width="10%">VN</th>
				</tr>
				<?php
				while ($row=$result_formazione->fetch_assoc()) {
						$ruolo_giocatore=$row["ruolo"];
					?>
				
					<tr id=row_<?php  echo $id_casa  . "_" . ($i+1);?> style="background-color: <?php 
					switch ($ruolo_giocatore) {
						case "P":
							echo "rgba(102, 204, 51, 1);";
							break;
						case "D":
							echo "rgba(51, 204, 204, 1);";
							break;
						case "C":
							echo "rgba(255, 239, 0, 1);";
							break;
						case "A":
							echo "rgba(232, 0, 0, 1);";
							break;
						default:
							echo "#FFFFFF;";
							break;
						}
					$disable = false;
					if(($gol_casa != "" && $gol_ospite != "") && (($i<11 && $row["voto"] != "") ||  ($i>=11 && $row["sostituzione"] == 1)))
						$disable = false;
					else if (($gol_casa == "" && $gol_ospite == "") && ($i<11))
						$disable = false;
					else
						$disable = true;
					?>">
						<?php
							// echo $nome_giocatore;
							$nome_giocatore_pulito = preg_replace('/\s+/', '-', $row["nome"]);
							// echo $nome_giocatore_pulito;
							$filename = str_replace("% %", "-", "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/".$nome_giocatore_pulito.".png"); 
						?>
						<?php if ($i==0) {echo 	"<td rowspan='11' style='background-color: rgba(51,102,255,0.2);'><div class='rotate'> Titolari</div></td>";  } ?>
						<?php if ($i==11) {echo "<td rowspan='8' style='background-color: rgba(51,102,255,0.4);'><div class='rotate' > Riserve </div></td>";  } ?>	
						<td style="padding:0; width:3%" class="<?php echo ($disable)? "disable": "" ?>"><?php echo '<img  onerror="imgError(this);" style="width:20px; height:27px;" src='.$filename.'>';?></td>
						<td class="<?php echo ($disable)? "disable": "" ?>"><div class="truncate"><?php echo $row["nome"]; ?></div></td>
						<td class="<?php echo ($disable)? "disable": "" ?>"><?php echo $row["squadra_breve"]; ?></td>
						<td class="<?php echo ($disable)? "disable": "" ?>"><?php echo $row["ruolo"]; ?></td>
						<td class="<?php echo ($disable)? "disable": "" ?>"><?php echo ($row["sostituzione"] == 1 || $i < 11 ? $row["voto"]: ""); ?></td>
						<td class="<?php echo ($disable)? "disable": "" ?>"><?php echo ($row["sostituzione"] == 1 || $i < 11 ? $row["voto_md"]: ""); ?></td>
					</tr>
					<?php
					++$i;
				}#end giocatori casa
				?>
	
			</table>
		</div>

	<?php
	$query_formazione="SELECT a.voto,a.voto_md, b.nome, b.ruolo, c.squadra_breve, a.sostituzione FROM formazioni as a inner join giocatori as b inner join squadre_serie_a as c where a.id_giornata='" . $id_giornata . "' and a.id_squadra= '". $id_ospite ."' and a.id_giocatore=b.id and a.id_squadra_sa=c.id ";

	//echo "<br> query formazione ospite= " . $query_formazione;
	$result_formazione=$conn->query($query_formazione);
	$num_giocatori=$result_formazione->num_rows;
	$i=0;
	?>
		
		<div class="ui-block-b" style="float:right;">
		<!-- <h3 class="caption_style" style="text-align: center;"><?php echo $sq_ospite; ?></h3> -->
			<table border=1  id="squadra_ospite<?php echo $j;?>">
				<!-- <caption class="caption_style"><?php echo $sq_ospite; ?></caption> -->
				<th colspan="3" >Nome</th>
				<th width="10%">R</th>
				<th width="10%">V</th>
				<th width="10%">VN</th>
				<th width="3%">OSP</th>

				<?php
				while ($row=$result_formazione->fetch_assoc()) {
					$ruolo_giocatore=$row["ruolo"];
				?>
					<tr id=row_<?php  echo $id_ospite  . "_" . ($i+1);?> style="background-color: <?php 
					switch ($ruolo_giocatore) {
						case "P":
							echo "rgba(102, 204, 51, 1);";
							break;
						case "D":
							echo "rgba(51, 204, 204, 1);";
							break;
						case "C":
							echo "rgba(255, 239, 0, 1);";
							break;
						case "A":
							echo "rgba(232, 0, 0, 1);";
							break;
						default:
							echo "#FFFFFF;";
							break;
						}
					$disable = false;
					if(($gol_casa != "" && $gol_ospite != "") && (($i<11 && $row["voto"] != "") ||  ($i>=11 && $row["sostituzione"] == 1)))
						$disable = false;
					else if (($gol_casa == "" && $gol_ospite == "") && ($i<11))
						$disable = false;
					else
						$disable = true;
				?>">
				<?php
						// echo $nome_giocatore;
						$nome_giocatore_pulito = preg_replace('/\s+/', '-', $row["nome"]);
						// echo $nome_giocatore_pulito;
						$filename = str_replace("% %", "-", "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/".$nome_giocatore_pulito.".png"); 
				?>
				
					<td style="padding:0; width:3%" class="<?php echo ($disable)? "disable": "" ?>"><?php echo '<img  onerror="imgError(this);" style="width:20px; height:27px;" src='.$filename.'>';?></td>
					<td class="<?php echo ($disable)? "disable": "" ?>"><div class="truncate"><?php echo $row["nome"]; ?></div></td>
					<td class="<?php echo ($disable)? "disable": "" ?>"><?php echo $row["squadra_breve"]; ?></td>
					<td class="<?php echo ($disable)? "disable": "" ?>"><?php echo $row["ruolo"]; ?></td>
					<td class="<?php echo ($disable)? "disable": "" ?>"><?php echo ($row["sostituzione"] == 1 || $i < 11 ? $row["voto"]: ""); ?></td>
					<td class="<?php echo ($disable)? "disable": "" ?>"><?php echo ($row["sostituzione"] == 1 || $i < 11 ? $row["voto_md"]: ""); ?></td>
					<?php if ($i==0) {echo 	"<td rowspan='11' style='background-color: rgba(51,102,255,0.2);'><div class='rotate2'> Titolari</div></td>";  } ?>
					<?php if ($i==11) {echo "<td rowspan='8' style='background-color: rgba(51,102,255,0.4);'><div class='rotate2'> Riserve </div></td>";  } ?>
				</tr>
					<?php
					++$i;
				}#end giocatori ospiti
				?>
			</table>
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