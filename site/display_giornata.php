<?php
include("menu.php");

?>

<!-- <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
<script>
imgError = function(img){
	// img.src = "https://d22uzg7kr35tkk.cloudfront.net/web/campioncini/small/no-campioncino.png";
	// img.src = str_replace("% %", "-", "https://content.fantacalcio.it/web/campioncini/small/no-campioncino.png");
	img.src = "https://content.fantacalcio.it/web/campioncini/small/no-campioncino.png";
};

showFormazioneIdeale = function()
{
    var action ="formazione_ideale";
    var punteggio =$(this).data("punteggio");
	var modulo =$(this).data("modulo");
	var formazione =$(this).data("formazione");
	var idgiornata =$(this).data("idgiornata");
	

	// $( "#dialog" ).prop('title', "ERROR");                
	// $( "#dialog p" ).html(punteggio +" " +modulo+ " "+ formazione );
	// $( "#dialog" ).dialog({modal:true});
	$.ajax({
        type:'POST',
            url:'display_giornata_controller.php',
            data: {
                "action": action,
                "punteggio": punteggio,
                "modulo": modulo,
                "formazione": formazione,
				"idgiornata": idgiornata,
            },
            success:function(data){
                // debugger;
                var resp=$.parseJSON(data)
                
                if(resp.result == "true"){
                    //show data
                    var template = $('#tmplFormazioneIdeale').html();
                    Mustache.parse(template);   // optional, speeds up future uses
                    var rendered = Mustache.render(template, resp);

					$( "#dialog" ).prop('title', "Formazione Ideale");                
                    $( "#dialog p" ).html(rendered);
                    $( "#dialog" ).dialog({modal:true});                    
                }
                else{
                    $( "#dialog" ).prop('title', "ERROR");                
                    $( "#dialog p" ).html(resp.error.msg);
                    $( "#dialog" ).dialog({modal:true});
                }
            }
    }); 
}
$(document).ready(function(){
    $(".formazione_ideale").off("click").bind("click", showFormazioneIdeale);
})
</script>

<script id="tmplFormazioneIdeale" type="x-tmpl-mustache">
 <div> <span>Modulo: {{modulo}}<span></div> <div><span>Punteggio: {{punteggio}}<span>    	</div>
        {{ #giocatori }}
		<div>
			<img  onerror="imgError(this);" style="width:20px; height:27px;" src='{{imgurl}}'>
        	<span> {{nome}}<span> 
			<span> {{ruolo}}<span> 
			<span> {{squadra_breve}}<span> 
			<span> {{voto}}<span> 
			<span> ({{voto_md}})<span> 

		</div>
        {{ /giocatori }}

</script>
<?php
$id_giornata=$_GET['id_giornata'];

?>

<h2> Giornata <?php echo $id_giornata ;?> </h2>
<div data-role="main" class="ui-content">

<?php


// $query2="Select *, b.squadra as sq_casa, c.squadra as sq_ospite, g.id_girone
// FROM calendario as a 
// left join sq_fantacalcio as b on a.id_sq_casa=b.id 
// left join sq_fantacalcio as c on a.id_sq_ospite=c.id 
// left join giornate as g on g.id_giornata=a.id_giornata 
// where a.id_giornata=".$id_giornata ." order by a.id_partita" ;
$query2="Select a.*, b.squadra as sq_casa, c.squadra as sq_ospite, g.id_girone, 
sg1.punteggio as sq_casa_max, sg2.punteggio as sq_ospite_max,
sg1.modulo as sq_casa_max_modulo, sg2.modulo as sq_ospite_max_modulo,
sg1.formazione_ideale as sq_casa_max_formazione, sg2.formazione_ideale as sq_ospite_max_formazione
FROM calendario as a 
left join sq_fantacalcio as b on a.id_sq_casa=b.id 
left join sq_fantacalcio as c on a.id_sq_ospite=c.id 
left join giornate as g on g.id_giornata=a.id_giornata 
left join sq_fantacalcio_statistiche_giornata as sg1 on sg1.sq_fantacalcio_id = a.id_sq_casa and sg1.giornata_serie_a_id = g.giornata_serie_a_id
left join sq_fantacalcio_statistiche_giornata as sg2 on sg2.sq_fantacalcio_id = a.id_sq_ospite and sg2.giornata_serie_a_id = g.giornata_serie_a_id
where a.id_giornata=$id_giornata order by a.id_partita";
#echo "<br> quesry2= " . $query2;
$idgirone = 0;
$result_giornata=$conn->query($query2);
$num_giornata=$result_giornata->num_rows;
$j=0;
while ($row=$result_giornata->fetch_assoc()) {
	$idgirone=$row["id_girone"];
	$id_partita=$row["id_partita"];
	$id_casa=$row["id_sq_casa"];
	$id_ospite=$row["id_sq_ospite"];
	$sq_casa=$row["sq_casa"];
	$sq_ospite=$row["sq_ospite"];
	
	$addizionalecasa = $row["fattorecasa"];
	$numero_giocanti_casa = $row["numero_giocanti_casa"];
	$voto_netto_casa = $row["punti_casa"];
	$sq_casa_max = $row["sq_casa_max"];
	$sq_casa_max_modulo = $row["sq_casa_max_modulo"];
	$sq_casa_max_formazione = $row["sq_casa_max_formazione"];
	$media_difesa_avversaria_casa = $row["md_casa"];
	$voto_totale_casa = $voto_netto_casa + $media_difesa_avversaria_casa + $addizionalecasa;//$row["tot_casa"];
	$gol_casa = $row["gol_casa"];

	$numero_giocanti_ospite  = $row["numero_giocanti_ospite"];
	$voto_netto_ospite = $row["punti_ospiti"];
	$sq_ospite_max = $row["sq_ospite_max"];
	$sq_ospite_max_modulo = $row["sq_ospite_max_modulo"];
	$sq_ospite_max_formazione = $row["sq_ospite_max_formazione"];
	$media_difesa_avversaria_ospite = $row["md_ospite"];
	$voto_totale_ospite = $voto_netto_ospite + $media_difesa_avversaria_ospite;//$row["tot_ospite"];
	$gol_ospite = $row["gol_ospiti"];


	$query_formazione="SELECT b.id,  gv.voto, gv.voto_md, b.nome, b.ruolo, c.squadra_breve, a.sostituzione, gv.voto_ufficio
	FROM formazioni as a 
	left join giocatori as b on a.id_giocatore=b.id
	left join squadre_serie_a as c on b.id_squadra =c.id
	left join giornate as g on g.id_giornata = a.id_giornata
	left join giocatori_voti as gv on (a.id_giocatore = gv.giocatore_id and g.giornata_serie_a_id = gv.giornata_serie_a_id)
	where a.id_giornata='" . $id_giornata . "' 
	and a.id_squadra= '". $id_casa ."' 
	order by a.id_posizione ";
	// echo $query_formazione;
	//echo "<br> query formazione casa= " . $query_formazione;
	$result_formazione=$conn->query($query_formazione);
	$giocatoricasa = array();
	$formazioneDefaultCasa = false;
	while ($row=$result_formazione->fetch_assoc()) {
		array_push($giocatoricasa, array(
			"nome"=> $row["nome"],
			"squadra_breve"=>$row["squadra_breve"],
			"ruolo"=>$row["ruolo"],
			"voto"=>$row["voto"],
			"voto_md"=>$row["voto_md"],
			"voto_ufficio"=>$row["voto_ufficio"],
			"sostituzione"=>$row["sostituzione"]
			)
		);
	}
	if (count($giocatoricasa) == 0){
		$formazioneDefaultCasa = true;
		$query_formazione_default="SELECT b.nome, b.ruolo, c.squadra_breve
		FROM formazione_standard as a 
		inner join giocatori as b 
		inner join squadre_serie_a as c 
		where a.id_squadra= '". $id_casa ."'  
		and a.id_giocatore=b.id 
		and a.id_squadra_sa=c.id ";
		//echo "<br> query formazione casa= " . $query_formazione;
		$result_formazione_default=$conn->query($query_formazione_default);
		// $giocatoridefault = array();
		while ($row=$result_formazione_default->fetch_assoc()) {
			array_push($giocatoricasa, array(
				"nome"=> $row["nome"],
				"squadra_breve"=>$row["squadra_breve"],
				"ruolo"=>$row["ruolo"],
				"voto"=>"",
				"voto_md"=>"",
				"voto_ufficio"=>"",
				"sostituzione"=>""
				)
			);
		}
		// print_r($giocatoridefault);
	}
	
	?>

	<?php
	$query_formazione="SELECT b.id,  gv.voto, gv.voto_md, b.nome, b.ruolo, c.squadra_breve, a.sostituzione, gv.voto_ufficio
	FROM formazioni as a 
	left join giocatori as b on a.id_giocatore=b.id
	left join squadre_serie_a as c on b.id_squadra =c.id
	left join giornate as g on g.id_giornata = a.id_giornata
	left join giocatori_voti as gv on (a.id_giocatore = gv.giocatore_id and g.giornata_serie_a_id = gv.giornata_serie_a_id)
	where a.id_giornata='" . $id_giornata . "' 
	and a.id_squadra= '". $id_ospite ."' 
	order by a.id_posizione ";

	//echo "<br> query formazione ospite= " . $query_formazione;
	$result_formazione=$conn->query($query_formazione);
	$giocatoritraferta = array();
	$formazioneDefaultOspite = false;
	while ($row=$result_formazione->fetch_assoc()) {
		array_push($giocatoritraferta, array(
			"nome"=> $row["nome"],
			"squadra_breve"=>$row["squadra_breve"],
			"ruolo"=>$row["ruolo"],
			"voto"=>$row["voto"],
			"voto_md"=>$row["voto_md"],
			"voto_ufficio"=>$row["voto_ufficio"],
			"sostituzione"=>$row["sostituzione"]
			)
		);
	}
	if (count($giocatoritraferta) == 0){
		$formazioneDefaultOspite = true;
		$query_formazione_default="SELECT b.nome, b.ruolo, c.squadra_breve
		FROM formazione_standard as a 
		inner join giocatori as b 
		inner join squadre_serie_a as c 
		where a.id_squadra= '". $id_ospite ."'  
		and a.id_giocatore=b.id 
		and a.id_squadra_sa=c.id ";
		// echo "<br> query_formazione_default= " . $query_formazione_default;
		$result_formazione_default=$conn->query($query_formazione_default);
		// $giocatoridefault = array();
		while ($row=$result_formazione_default->fetch_assoc()) {
			array_push($giocatoritraferta, array(
				"nome"=> $row["nome"],
				"squadra_breve"=>$row["squadra_breve"],
				"ruolo"=>$row["ruolo"],
				"voto"=>"",
				"voto_md"=>"",
				"voto_ufficio"=>"",
				"sostituzione"=>""
				)
			);
		}
		// print_r($giocatoridefault);
	}
	?>
	<!-- <h3 class="caption_style" style="text-align: center;">
		<div style="width:40%; display:inline-block;"><?php echo $sq_casa; ?> </div>
		<div style="width:10%; display:inline-block;">-</div> 
		<div style="width:40%; display:inline-block;"><?php echo $sq_ospite; ?></div>
	</h3> -->
	<?php $ritultatocalcolato = ($gol_casa != "" && $gol_ospite != "") ? true: false ?>
	<div id="tabellino<?php echo $id_partita ?>" class="tabellino">
		<table>
			<tr>
				<th style="width:35%"><?php echo $sq_casa; echo ($formazioneDefaultCasa? "**" : ""); ?></th>
				<th><?php echo $gol_casa; ?> - <?php echo $gol_ospite; ?></th>
				<th style="width:35%"><?php echo $sq_ospite; echo ($formazioneDefaultOspite? "**" : "");?></th>
			</tr>
			<tr style=" <?php echo ($ritultatocalcolato) ? "": "display:none" ?>">
				<td><?php echo $gol_casa; ?> </td>
				<td>GOL</td>
				<td><?php echo $gol_ospite; ?> </td>
			</tr>
			<tr style=" <?php echo ($ritultatocalcolato) ? "": "display:none" ?>">
				<td><?php echo $voto_netto_casa ;?> </td>
				<td>VOTO NETTO</td>
				<td><?php echo $voto_netto_ospite; ?> </td>
			</tr>
			<tr style=" <?php echo ($ritultatocalcolato) ? "": "display:none" ?>">
				<td><?php echo $addizionalecasa ?> </td>
				<td>FATTORE CASA</td>
				<td>&nbsp;</td>
			</tr>
			<tr style=" <?php echo ($ritultatocalcolato)? "": "display:none" ?>">
				<td><?php echo $media_difesa_avversaria_casa; ?> </td>
				<td>MEDIA DIFESA</td>
				<td><?php echo $media_difesa_avversaria_ospite; ?></td>
			</tr>
			<tr style=" <?php echo ($ritultatocalcolato) ? "": "display:none" ?>">
				<td><?php echo $voto_totale_casa; ?> </td>
				<td>VOTO TOTALE</td>
				<td><?php echo $voto_totale_ospite; ?></td>
			</tr>
			<tr style=" <?php echo ($ritultatocalcolato) ? "": "display:none" ?>">
				<td><?php echo $numero_giocanti_casa; ?> </td>
				<td># GIOCATORI</td>
				<td><?php echo $numero_giocanti_ospite; ?></td>
			</tr>
			<tr style=" <?php echo ($ritultatocalcolato) ? "": "display:none" ?>">
				<td>
					<span class="formazione_ideale" data-punteggio="<?php echo $sq_casa_max ?>" 
					data-modulo="<?php echo  $sq_casa_max_modulo ?>" data-formazione="<?php echo rtrim($sq_casa_max_formazione, ",") ?>"
					data-idgiornata="<?php echo  $id_giornata ?>"><i class="fas fa-external-link-alt" aria-hidden="true"></i></span>
					<?php echo round(($voto_netto_casa / $sq_casa_max)*100, 0)."%"; ?> 
				</td>
				<td>Efficienza</td>
				<td>
					<?php echo round(($voto_netto_ospite/ $sq_ospite_max)*100, 0)."%"; ?>
					<span class="formazione_ideale" data-punteggio="<?php echo $sq_ospite_max ?>" 
					data-modulo="<?php echo $sq_ospite_max_modulo ?>" data-formazione="<?php echo rtrim($sq_ospite_max_formazione, ",") ?>"
					data-idgiornata="<?php echo  $id_giornata ?>"><i class="fas fa-external-link-alt" aria-hidden="true"></i></span>
				</td>
			</tr>
		</table>
	</div>
	
	
	 <div class="ui-grid-a">
		
		<div class="ui-block-a" style="float:left;">
		<!-- <h3 class="caption_style" style="text-align: center;"><?php echo $sq_casa; ?></h3> -->
			<table  id="squadra_casa_desk<?php echo $j;?>" class="desktop">
				<!-- <caption class="caption_style"><?php echo $sq_casa; ?></caption> -->
				<tr>
					<th width="3%">CAS</th>
					<th colspan="3" >Nome</th>
					<th width="10%">R</th>
					<th width="10%">V</th>
					<th width="10%">VN</th>
				</tr>
				<?php
				$i=0;
				foreach ($giocatoricasa as $row){	
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
							$nome_giocatore_pulito = strtoupper(preg_replace('/\s+/', '-', $row["nome"]));
							// echo $nome_giocatore_pulito;
							$filename = str_replace("% %", "-", "https://content.fantacalcio.it/web/campioncini/small/".$nome_giocatore_pulito.".png"); 
						?>
						<?php if ($i==0) {echo 	"<td rowspan='11' style='background-color: rgba(51,102,255,0.2);'><div class='rotate'> Titolari</div></td>";  } ?>
						<?php if ($i==11) {echo "<td rowspan='10' style='background-color: rgba(51,102,255,0.4);'><div class='rotate' > Riserve </div></td>";  } ?>	
						<td style="padding:0; width:3%" class="<?php echo ($disable)? "disable": "" ?>"><?php echo '<img  onerror="imgError(this);" style="width:20px; height:27px;" src='.$filename.'>';?></td>
						<td class="<?php echo ($disable)? "disable": "" ?>"><div class="truncate"><?php echo $row["nome"]; ?></div></td>
						<td class="<?php echo ($disable)? "disable": "" ?>"><?php echo $row["squadra_breve"]; ?></td>
						<td class="<?php echo ($disable)? "disable": "" ?>"><?php echo $row["ruolo"]; ?></td>
						<td >
							<?php 
							if($ritultatocalcolato){
								echo ($row["voto"] != "" && $row["sostituzione"] == 1 || $i < 11 ? $row["voto"] : "&nbsp;"); 
								echo $row["voto_ufficio"] ? "*": ""; 
							}
							else
								echo $row["voto"] != "" ? $row["voto"] : "&nbsp;";
							?>
						</td>
						<td >
							<?php 
								echo ($row["voto"] != "" && $row["sostituzione"] == 1 || $i < 11 ? $row["voto_md"]: "&nbsp;"); 
							?>
						</td>
					</tr>
					<?php
					++$i;
				}#end giocatori casa
				?>
	
			</table>
			
			<table  id="squadra_casa_mobile<?php echo $j;?>" class="mobile">
				<!-- <caption class="caption_style"><?php echo $sq_casa; ?></caption> -->
				<!-- <tr> 
					<th >Giocatore</th>
					<th width="15%">VOTO</th> 
				</tr> -->
				<?php
				$i=0;
				foreach ($giocatoricasa as $row){	
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
							$nome_giocatore_pulito = strtoupper(preg_replace('/\s+/', '-', $row["nome"]));
							// echo $nome_giocatore_pulito;
							$filename = str_replace("% %", "-", "https://content.fantacalcio.it/web/campioncini/small/".$nome_giocatore_pulito.".png"); 
						?>
						<td >
					<?php 
							// echo  ($row["sostituzione"] == 1  ? '<i class="fas fa-arrow-left" style="color:springgreen"></i>' : ""); 
					?>	
						<div class="<?php echo ($disable)? "disable": "" ?>">
						<div >
							<?php 
								echo '<span class="truncate">'. $row["nome"] .'</span><span class="truncate">('.$row["squadra_breve"] .")</span>"
							?>
						</div>
					</div>

					<?php 
							// echo ($row["voto"] == "" &&  $i < 11 ? '<i class="fas fa-arrow-right" style="color:red"></i>' : ""); 
					?>
					</td>
					<td style="width:10%"> 
						<?php 
						if($ritultatocalcolato){
							echo (($row["sostituzione"] == 1 || $i < 11) && $row["voto"] != "" ? ($row["voto"]."(".$row["voto_md"].")") : "&nbsp;"); 
						}
						else
							echo ($row["voto"] != "" ? ($row["voto"]."(".$row["voto_md"].")") : "&nbsp;"); 
						?>
					</td>
					</tr>
					<?php
					++$i;
				}#end giocatori casa
				?>
	
			</table>
		</div>

	
	
		
		<div class="ui-block-b" style="float:right;">
		<!-- <h3 class="caption_style" style="text-align: center;"><?php echo $sq_ospite; ?></h3> -->
			<table id="squadra_ospite_desk<?php echo $j;?>" class="desktop">
				<!-- <caption class="caption_style"><?php echo $sq_ospite; ?></caption> -->
				<th colspan="3" >Nome</th>
				<th width="10%">R</th>
				<th width="10%">V</th>
				<th width="10%">VN</th>
				<th width="3%">OSP</th>

				<?php
				$i=0;
				foreach ($giocatoritraferta as $row){	
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
						$nome_giocatore_pulito = strtoupper(preg_replace('/\s+/', '-', $row["nome"]));
						// echo $nome_giocatore_pulito;
						$filename = str_replace("% %", "-", "https://content.fantacalcio.it/web/campioncini/small/".$nome_giocatore_pulito.".png"); 
				?>
				
					<td style="padding:0; width:3%" class="<?php echo ($disable)? "disable": "" ?>"><?php echo '<img  onerror="imgError(this);" style="width:20px; height:27px;" src='.$filename.'>';?></td>
					<td class="<?php echo ($disable)? "disable": "" ?>"><div class="truncate"><?php echo $row["nome"]; ?></div></td>
					<td class="<?php echo ($disable)? "disable": "" ?>"><?php echo $row["squadra_breve"]; ?></td>
					<td class="<?php echo ($disable)? "disable": "" ?>"><?php echo $row["ruolo"]; ?></td>
					<td >
						<?php 
						if($ritultatocalcolato){
							echo ($row["voto"] != "" && $row["sostituzione"] == 1 || $i < 11 ? $row["voto"] : "&nbsp;"); 
							echo $row["voto_ufficio"] ? "*": ""; 
						}
						else
							echo $row["voto"] != "" ? $row["voto"] : "&nbsp;";
						?>
					</td>
					<td >
						<?php 
							echo ($row["voto"] != "" && $row["sostituzione"] == 1 || $i < 11 ? $row["voto_md"]: "&nbsp;"); 
						?>
					</td>
					<?php if ($i==0) {echo 	"<td rowspan='11' style='background-color: rgba(51,102,255,0.2);'><div class='rotate2'> Titolari</div></td>";  } ?>
					<?php if ($i==11) {echo "<td rowspan='10' style='background-color: rgba(51,102,255,0.4);'><div class='rotate2'> Riserve </div></td>";  } ?>
				</tr>
					<?php
					++$i;
				}#end giocatori ospiti
				?>
			</table>

			<table  id="squadra_ospite_mobile<?php echo $j;?>" class="mobile">
				<!-- <caption class="caption_style"><?php echo $sq_ospite; ?></caption> -->
				
				<!-- <tr> 
					<th >Giocatore</th>
					<th width="15%">VOTO</th> 
				</tr> -->

				<?php
				$i=0;
				foreach ($giocatoritraferta as $row){	
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
						$nome_giocatore_pulito = strtoupper(preg_replace('/\s+/', '-', $row["nome"]));
						// echo $nome_giocatore_pulito;
						$filename = str_replace("% %", "-", "https://content.fantacalcio.it//web/campioncini/small/".$nome_giocatore_pulito.".png"); 
				?>
					<td >
						<?php 
								// echo  ($row["sostituzione"] == 1  ? '<i class="fas fa-arrow-left" style="color:springgreen"></i>' : ""); 
						?>	
						<div class="<?php echo ($disable)? "disable": "" ?>">
							<div >
								<?php 
									echo '<span class="truncate">'. $row["nome"] .'</span><span class="truncate">('.$row["squadra_breve"] .")</span>"
								?>
							</div>
						</div>

						<?php 
								// echo ($row["voto"] == "" &&  $i < 11 ? '<i class="fas fa-arrow-right" style="color:red"></i>' : ""); 
						?>
					</td>
					<td style="width:10%"> 
						<?php 
							if($ritultatocalcolato){
								echo (($row["sostituzione"] == 1 || $i < 11) && $row["voto"] != "" ? ($row["voto"]."(".$row["voto_md"].")") : "&nbsp;"); 
							}
							else
								echo ($row["voto"] != "" ? ($row["voto"]."(".$row["voto_md"].")") : "&nbsp;"); 
						?>
					</td>
					
					
				</tr>
					<?php
					++$i;
				}#end giocatori ospiti
				?>
			</table>
		</div>
	</div>
	<div style="display: inline-block;width: 100%;">
		<?php
		++$j;
		
		if($formazioneDefaultCasa || $formazioneDefaultOspite){
		echo "<div style=\"text-align: center;\"><i>** formazione di default</i></div>";}
		echo '<hr style="display: inline-block;width: 100%;">';
		} 
		echo "<div style=\"text-align: center;\"><i>* voto d'ufficio</i></div>";
		?>
		
	</div>
	
</div><!-- end incontri-->
<?php 
include("footer.php");
?>